<?php
class ElecAction extends BaseAction {
	function index() {
		$elec = new ElecViewModel ();
		// 查询列表
		import ( "ORG.Util.Page" );
		$where = $this->getWhereWithTable ( 'Elec' );
		$where = $where . " and Elec.requester=" . $this->getId ();
		if (! empty ( $_POST ['state'] )) {
			$where = $where . " and Elec.state='" . $_POST ['state'] . "'";
			$this->assign ( "state", $_POST ['state'] );
		}
		if (! empty ( $_POST ['sdate'] )) {
			$where = $where . " and Elec.requesterdate'=" . $_POST ['requesterdate'] . "'";
		}
		$count = $elec->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $elec->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		parent::index ();
	}
	function add() {
		// 加载级别
		$category = new ElectypeModel ();
		$categories = $category->select ();
		$this->assign ( "categories", $categories );
		// 加载部门
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		
		parent::add ();
	}
	function insert() {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_MEETFILE;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		$elec = new ElecModel ();
		try {
			$elec->startTrans ();
			$data = $elec->create ();
			if ($up->upload ()) {
				$paths = "";
				$files = $up->getUploadFileInfo ();
				for($i = 0; $i <= count ( $files ); $i ++) {
					$paths = $paths . $files [$i] ["savename"];
					if ($i < count ( $files ) - 1)
						$paths = $paths . ",";
				}
				$data ['atts'] = $paths;
			} else {
				// println ( $up->getErrorMsg () );
			}
			// println ( $data );
			$checkers_str = $_POST ['checkers'];
			$checkers = json_decode ( $checkers_str, true );
			$data ['nextchecker'] = $checkers [0] ['id'];
			$data ['state'] = '申請';
			$elec->add ( $data );
			$id = $elec->getLastInsID ();
			foreach ( $checkers as $key => $value ) {
				$ef = M ( 'elecflow' );
				$data ['elec'] = $id;
				$data ['checkerid'] = $value ['id'];
				$data ['checkername'] = $value ['name'];
				$ef->add ( $data );
			}
			$elec->commit ();
		} catch ( Exception $e ) {
			$elec->rollback ();
		}
		
		$this->index ();
	}
	function dirty() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = new ElecModel ();
		$data ['state'] = '作廢';
		$model->where ( "id in (" . $where . ")" )->save ( $data );
		$this->index ();
	}
	function receive() {
		$elec = new ElecViewModel ();
		// 查询列表
		import ( "ORG.Util.Page" );
		$where = $this->getWhereWithTable ( 'Elec' );
		$where = $where . " and Elec.nextchecker=" . $this->getId ();
		$where = $where . " and Elec.state!='作廢' and Elec.state!='生效'";
		
		if (! empty ( $_POST ['state'] )) {
			$where = $where . " and Elec.state='" . $_POST ['state'] . "'";
			$this->assign ( "state", $_POST ['state'] );
		}
		if (! empty ( $_POST ['sdate'] )) {
			$where = $where . " and Elec.requesterdate'=" . $_POST ['requesterdate'] . "'";
		}
		$count = $elec->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $elec->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'receive' );
	}
	function aggree() {
		$id = $_POST ['id'];
		$ids = implode ( ",", $id );
		if(empty($ids))
			$ids=$id;
		$model = new ElecModel ();
		try {
			$model->startTrans ();
			// 查询出所有提交的签呈
			$elecs = $model->where ( "id in (" . $ids . ")" )->select ();
			foreach ( $elecs as $key => $elec ) {
				$data ['id'] = $elec ['id'];
				$data['description']=$_POST['description'];
				// 判断是否还有下一节点如果有就更新nextchecker
				// 如果没有就更新nextchecker和状态
				$elecflow = M ( 'elecflow' );
				$flows = $elecflow->where ( "elec=" . $elec ['id'] )->order ( 'id' )->select ();
				$len = count ( $flows );
				for($i = 0; $i < $len; $i ++) {
					// 当前流程的审核人和流程步骤中的审核人一样的时候判断是否还有下一个审核人
					if ($elec ['nextchecker'] == $flows [$i] ['checkerid']) {
						// 保存当前步骤的审核结果为同意
						$flow ['id'] = $flows [$i] ['id'];
						$flow ['checkerresult'] = '同意';
						$elecflow->save ( $flow );
						if ($i < $len - 1) {
							$data ['state'] = '簽核中';
							$data ['nextchecker'] = $flows [$i + 1] ['checkerid'];
						} else 						// 没有人审核了说明生效了。
						{
							$data ['state'] = '生效';
							$data ['nextchecker'] = null;
						}
					}
				}
				$model->save ( $data );
			}
			$model->commit ();
		} catch ( Exception $e ) {
			$model->rollback ();
		}
		$this->receive ();
	}
	function disaggree() {
		$id = $_POST ['id'];
		$model = new ElecModel ();
		try {
			$model->startTrans ();
			// 查询出所有提交的签呈
			$elec = $model->find ( $id );
			$data ['id'] = $elec ['id'];
			$data['description']=$_POST['description'];
			// 判断是否还有下一节点如果有就更新nextchecker
			// 如果没有就更新nextchecker和状态
			$elecflow = M ( 'elecflow' );
			$flows = $elecflow->where ( "elec=" . $id )->order ( 'id' )->select ();
			$len = count ( $flows );
			for($i = 0; $i < $len; $i ++) {
				// 当前流程的审核人和流程步骤中的审核人一样的时候判断是否还有下一个审核人
				if ($elec ['nextchecker'] == $flows [$i] ['checkerid']) {
					// 保存当前步骤的审核结果为同意
					$flow ['id'] = $flows [$i] ['id'];
					$flow ['checkerresult'] = '不同意';
					$elecflow->save ( $flow );
				}
			}
			$data ['state'] = '不同意';
			$data ['nextchecker'] = null;
			
			$model->save ( $data );
			$model->commit ();
		} catch ( Exception $e ) {
			$model->rollback ();
		}
		$this->receive ();
	}
	function view() {
		$id = $_GET ['id'];
		$elec = new ElecModel ();
		$data = $elec->switchModel ( "View", array (
				"viewFields" 
		) )->find ( $id );
		$this->assign ( "elec", $data );
		$flow = M ( 'elecflow' );
		$flows = $flow->where ( "elec=" . $id )->select ();
		$this->assign ( "flows", $flows );
		$this->display ();
	}
	function check() {
		$id = $_GET ['id'];
		$elec = new ElecModel ();
		$data = $elec->switchModel ( "View", array (
				"viewFields" 
		) )->find ( $id );
		$this->assign ( "elec", $data );
		$flow = M ( 'elecflow' );
		$flows = $flow->where ( "elec=" . $id )->select ();
		$this->assign ( "flows", $flows );
		$this->display ();
	}
	function getLevel() {
		$id = $_POST ["id"];
		$sql = "SELECT * FROM `level` WHERE LOCATE(CONCAT(',', id,','),CONCAT(',',  (SELECT LEVEL FROM `user` WHERE id=$id),','))>0";
		$dao = new Model ();
		$data = $dao->query ( $sql );
		echo json_encode ( $data );
	}
	function getChildElecById() {
		$pid = $_POST ["pid"];
		$child = new Model ( 'elecchildtype' );
		$childs = $child->where ( "elec=" . $pid )->select ();
		echo json_encode ( $childs );
	}
	function getLevels() {
		$id = $_POST ["id"];
		$child = new Model ( 'elecchildtype' );
		$levelids = $child->where ( 'id=' . $id )->getField ( 'levels' );
		$level = new Model ( 'level' );
		$levels = $level->where ( 'id in(' . $levelids . ')' )->select ();
		$names = "";
		$len = count ( $levels );
		for($i = 0; $i < $len; $i ++) {
			$names .= $levels [$i] ["remark"];
			if ($i < $len - 1)
				$names .= ",";
		}
		echo $levelids . "|" . $names;
	}
	function category() {
		$elec = new ElectypeModel ();
		$list = $elec->where("code='$this->code'")->select ();
		$this->assign ( "list", $list );
		$this->display ( 'category' );
	}
	function addElec() {
		$elec = new ElectypeModel ();
		
		$elec->create ();
		if (empty ( $_POST ['id'] ))
			$elec->add ();
		else
			$elec->save ();
		$this->category ();
	}
	function editElec() {
		$id = $_GET ['id'];
		$elec = new ElectypeModel ();
		$data = $elec->find ( $id );
		$this->assign ( "elec", $data );
		$this->category ();
	}
	function delElec() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = new ElectypeModel ();
		$model->delete ( $where );
		$this->category ();
	}
	function childcategory() {
		$key = $_POST ['key'];
		$eleccView = new ElecchildtypeViewModel ();
		$where = " Electype.code = '" . $this->getCode () . "'";
		import ( "ORG.Util.Page" );
		if (! empty ( $key )) {
			$where = $where . " and Electype.id='" . $key . "'";
			$this->assign ( "stype", $key );
		}
		$count = $eleccView->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $eleccView->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$elec = new ElectypeModel ();
		$types = $elec->select ();
		$this->assign ( "types", $types );
		
		$this->display ( 'childcategory' );
	}
	function addChildcategory() {
		// 查询类别
		$elec = new ElectypeModel ();
		$types = $elec->where("code='$this->code'")->select ();
		$this->assign ( "types", $types );
		// 查询级别
		$level = new LevelModel ();
		$levels=$level->selectByCode();
		$this->assign ( "levels", $levels );
		
		$this->display ( 'addChildcategory' );
	}
	function addChildElec() {
		$elec = new ElecchildtypeModel ();
		$data = $elec->create ();
		$data ['levels'] = implode ( ",", $_POST ['level'] );
		if (empty ( $_POST ['id'] ))
			$elec->add ( $data );
		else
			$elec->save ( $data );
		$this->childcategory ();
	}
	function editChildElec() {
		$id = $_GET ['id'];
		
		$elecchild = new ElecchildtypeModel ();
		
		$data = $elecchild->find ( $id );
		
		$this->assign ( "elecc", $data );
		
		$this->addChildcategory ();
	}
	function childcategoryview() {
		$id = $_GET ['id'];
		$elecchild = new ElecchildtypeViewModel ();
		$data = $elecchild->find ( $id );
		$this->assign ( "elecv", $data );
		$this->display ( 'childcategoryview' );
	}
	function delChildElec() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = new ElecchildtypeModel ();
		$model->delete ( $where );
		$this->childcategory ();
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( ATTCHEMENT_PATH_ELECFILE . $name, $name );
	}
	function zipdown() {
		$zip = new PHPZip ();
		$paths = array ();
		$name = $_GET ['names'];
		$names = explode ( ",", $name );
		$i = 0;
		foreach ( $names as $key => $value ) {
			$paths [$i] = ATTCHEMENT_PATH_ELECFILE . $value;
			$i ++;
		}
		$zip->createZip ( $paths, "all.zip", true );
	}
}
?>