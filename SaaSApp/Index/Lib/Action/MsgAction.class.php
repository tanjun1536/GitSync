<?php
class MsgAction extends BaseAction {
	function index() {
		$model = new MsgModel ();
		import ( "ORG.Util.Page" );
		$sql = "SELECT 
			  m.*,IFNULL(mr.readerid,0) isread 
			FROM
			  msg m LEFT JOIN msgreader mr ON m.`id`=mr.`msgid` AND mr.`readerid`=$this->id
			WHERE INSTR(
			    CONCAT(',', m.receiversid, ','),
			    CONCAT(',', $this->id, ',')
			  ) > 0 AND m.code = $this->code ORDER by m.id desc";
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index ();
	}
	function create() {
		$this->getUnRead ();
		$this->display ();
	}
	function addMsg() {
		$msg = new MsgModel ();
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_MSGFILE;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		try {
			$msg->startTrans ();
			$data = $msg->create ();
			// println ( $data );
			if ($up->upload ()) {
				$paths = "";
				$files = $up->getUploadFileInfo ();
				for($i = 0; $i <= count ( $files ); $i ++) {
					$paths = $paths . $files [$i] ["savename"];
					if ($i < count ( $files ) - 1)
						$paths = $paths . ",";
				}
				if (empty ( $data ['atts'] ))
					$data ['atts'] = $paths;
				else
					$data ['atts'] = $data ['atts'] . "," . $paths;
			} else {
				// println ( $up->getErrorMsg () );
			}
			$msg->add ( $data );
			$this->getUnRead ( $this->getId () );
			$msg->commit ();
		} catch ( Exception $e ) {
			$msg->rollback ();
		}
		$this->index ();
	}
	function send() {
		$model = new MsgModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$where = $where . " and senderid=" . $this->getId ();
		// $where=$where.' and
		// INSTR(CONCAT(",",receiversid,","),",'.$this->getId().',")>0';
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ();
	}
	function view() {
		$id = $_GET ['id'];
		$model = new MsgModel ();
		if (! empty ( $_GET ['noread'] )) {
			$reader = M ( 'msgreader' );
			// 更新已讀標記
			$data ['msgid'] = $id;
			$data ['readerid'] = $this->id;
			$reader->add ( $data );
		}
		
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		if (! empty ( $msg ['responseid'] )) {
			$orign = $model->find ( $msg ['responseid'] );
			$this->assign ( "orign", $orign );
		}
		$this->getUnRead ( $this->getId () );
		$this->display ();
	}
	function response() {
		$id = $_GET ['id'];
		$model = new MsgModel ();
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		$this->display ();
	}
	function addResponse() {
		$this->addMsg ();
	}
	function sendtoothers() {
		$id = $_GET ['id'];
		$model = new MsgModel ();
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		$this->display ();
	}
	function addSendtoothers() {
		$this->addMsg ();
	}
	function getUnRead($id) {
		$model = new MsgModel ();
		$sql = "SELECT COUNT(*) as C FROM (SELECT 
			  m.id,IFNULL(mr.readerid,0) isread 
			FROM
			  msg m LEFT JOIN msgreader mr ON m.`id`=mr.`msgid` AND mr.`readerid`=$this->id
			WHERE INSTR(
			    CONCAT(',', m.receiversid, ','),
			    CONCAT(',', $this->id, ',')
			  ) > 0 AND m.code = $this->code) z WHERE z.isread =0";
		$count = $model->query($sql);
		$_SESSION [C ( "MSG_COMM_KEY" )] =$count[0]['C'];
	}
	
	// ========================================WORK
	function work() {
		$model = new MsgworkModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$where = $where . " and senderid=" . $this->getId ();
		// $where = $where . ' and INSTR(CONCAT(",",receiversid,","),",' .
		// $this->getId () . ',")>0';
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->getOtherWorkMsg ( $this->getUser () );
		$this->display ( 'work' );
	}
	function otherwork() {
		$model = new MsgworkModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$where = $where . " and receiverid=" . $this->getId ();
		// $where = $where . ' and INSTR(CONCAT(",",receiversid,","),",' .
		// $this->getId () . ',")>0';
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'otherwork' );
	}
	function addWorkMsg() {
		$msg = new MsgworkModel ();
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_MSGFILE;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		try {
			$msg->startTrans ();
			$data = $msg->create ();
			// println($_POST['receiversid']);
			// println($_POST['receiversname']);
			$receiversid = explode ( ",", $_POST ['receiversid'] );
			$receiversname = explode ( ",", $_POST ['receiversname'] );
			
			if ($up->upload ()) {
				$paths = "";
				$files = $up->getUploadFileInfo ();
				for($i = 0; $i <= count ( $files ); $i ++) {
					$paths = $paths . $files [$i] ["savename"];
					if ($i < count ( $files ) - 1)
						$paths = $paths . ",";
				}
				if (empty ( $data ['atts'] ))
					$data ['atts'] = $paths;
				else
					$data ['atts'] = $data ['atts'] . "," . $paths;
			} else {
				// println ( $up->getErrorMsg () );
			}
			$data ['state'] = '要求回報';
			$data ['senderimage'] = $_SESSION [C ( "USER_SESSION_KEY" )] ["userimage"];
			for($i = 0; $i < count ( $receiversid ); $i ++) {
				$data ['receiverid'] = $receiversid [$i];
				$data ['receivername'] = $receiversname [$i];
				$msg->add ( $data );
			}
			$this->getWorkMsg ( $this->getUser () );
			$msg->commit ();
		} catch ( Exception $e ) {
			$msg->rollback ();
		}
		$this->work ();
	}
	function workview() {
		$id = $_GET ['id'];
		$model = new MsgworkModel ();
		// 更新已讀標記
		$data ['issenderread'] = 1;
		$data ['id'] = $id;
		$model->save ( $data );
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		// 查詢細節
		$detail = M ( 'msgworkdetail' );
		$details = $detail->where ( "workid=" . $id )->order ( 'id desc' )->select ();
		$this->assign ( "details", $details );
		$this->getWorkMsg ( $this->getUser () );
		$this->display ();
	}
	function otherworkview() {
		$id = $_GET ['id'];
		$model = new MsgworkModel ();
		// 更新已讀標記
		$data ['isreceiverread'] = 1;
		$data ['id'] = $id;
		$model->save ( $data );
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		// 查詢細節
		$detail = M ( 'msgworkdetail' );
		$details = $detail->where ( "workid=" . $id )->order ( 'id desc' )->select ();
		$this->assign ( "details", $details );
		$this->getOtherWorkMsg ( $this->getUser () );
		$this->display ();
	}
	function workresponse() {
		$id = $_GET ['id'];
		$model = new MsgworkModel ();
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		$this->display ();
	}
	function otherworkresponse() {
		$id = $_GET ['id'];
		$model = new MsgworkModel ();
		$msg = $model->find ( $id );
		$this->assign ( "msg", $msg );
		$this->display ();
	}
	function addWorkResponse() {
		$model = M ( 'msgworkdetail' );
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_MSGFILE;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		try {
			$model->startTrans ();
			$data = $model->create ();
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
			}
			$data ['responsedate'] = date ( "Y-m-d H:i:s" );
			// 保存回复
			$model->add ( $data );
			// 更新msgwork isenderread, responsedate,state
			$msgwork = new MsgworkModel ();
			$mw ['id'] = $_POST ['workid'];
			$mw ['isreceiverread'] = 0;
			$mw ['state'] = $data ['state'];
			$mw ['responsedate'] = $data ['responsedate'];
			// println ( $mw );
			$msgwork->save ( $mw );
			$model->commit ();
		} catch ( Exception $e ) {
			$model->rollback ();
		}
		$this->work ();
	}
	function addOtherWorkResponse() {
		$model = M ( 'msgworkdetail' );
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_MSGFILE;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		try {
			$model->startTrans ();
			$data = $model->create ();
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
			}
			$data ['responsedate'] = date ( "Y-m-d H:i:s" );
			// 保存回复
			$model->add ( $data );
			// 更新msgwork isenderread, responsedate,state
			$msgwork = new MsgworkModel ();
			$mw ['id'] = $_POST ['workid'];
			$mw ['issenderread'] = 0;
			$mw ['state'] = $data ['state'];
			$mw ['responsedate'] = $data ['responsedate'];
			// println ( $mw );
			$msgwork->save ( $mw );
			$model->commit ();
		} catch ( Exception $e ) {
			$model->rollback ();
		}
		$this->otherwork ();
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( ATTCHEMENT_PATH_MSGFILE . $name, $name );
	}
	function zipdown() {
		$zip = new PHPZip ();
		$paths = array ();
		$name = $_GET ['names'];
		$names = explode ( ",", $name );
		$i = 0;
		foreach ( $names as $key => $value ) {
			$paths [$i] = ATTCHEMENT_PATH_MSGFILE . $value;
			$i ++;
		}
		$zip->createZip ( $paths, "all.zip", true );
	}
	function getWorkMsg($data) {
		$model = new MsgworkModel ();
		$where = "code='" . $data ['code'] . "'";
		$where = $where . " and issenderread =0";
		$where = $where . " and senderid =" . $data ['id'];
		$count = $model->where ( $where )->count ();
		$_SESSION [C ( "MSG_WORK_KEY" )] = $count;
	}
	function getOtherWorkMsg($data) {
		$model = new MsgworkModel ();
		$where = "code='" . $data ['code'] . "'";
		$where = $where . " and isreceiverread =0";
		$where = $where . " and receiverid =" . $data ['id'];
		$count = $model->where ( $where )->count ();
		$_SESSION [C ( "MSG_OTHER_WORK_KEY" )] = $count;
	}
}
?>