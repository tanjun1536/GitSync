<?php
class NewsAction extends BaseAction {
	function index() {
		$key = $_POST ["key"];
		$model = new NewsModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		if (! empty ( $key )) {
			$where = $where . " and title like '%" . $key . "%'";
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index ();
	}
	function view() {
		$n = new NewsModel ();
		try {
			$n->startTrans ();
			$data = $n->find ( $_GET ['id'] );
			$this->assign ( "news", $data );
			// 加入查看人列表
			$m = M ( 'newsreader' );
			$reader = $m->where ( "news=" . $_GET ['id'] . " and readerid=" . $this->getId () )->find ();
			if (! $reader) {
				$datareader ['news'] = $_GET ['id'];
				$datareader ['readerid'] = $this->getId ();
				$datareader ['readername'] = $this->getName ();
				$datareader ['readercode'] = $this->getUCode ();
				$datareader ['readerimage'] = $this->getImage ();
				$datareader ['readerdepart'] = $this->getDepart ();
				$datareader ['readerdate'] = date ( 'Y-m-d H:i:s' );
				$m->add ( $datareader );
				$sql = "UPDATE news set readercount=IFNULL(readercount,0)+1 WHERE id=" . $_GET ['id'];
				$n->execute ( $sql );
			}
			// 更新news表的readcount
			
			$this->display ();
			$n->commit ();
		} catch ( Exception $e ) {
			$n->rollback ();
		}
	}
	function insert() {
		$news = new NewsModel ();
		$data = $news->create ();
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_NEWSFILE;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
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
			$msg=$up->getErrorMsg ();
		}
		$news->add ( $data );
		$this->redirect("index");
	}
	function update() {
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
	function viewreaders() {
		$depart = $_GET ["depart"];
		$model = M ( 'newsreader' );
		import ( "ORG.Util.Page" );
		$this->assign ( "id", $_GET ['id'] );
		$where = " news=" . $_GET ['id'];
		if (! empty ( $depart )) {
			$this->assign ( "depart", $depart );
			$where = $where . " and readerdepart=" . $depart;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( ATTCHEMENT_PATH_NEWSFILE . $name, $name );
	}
	function delete() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = new NewsModel ();
		$model->delete ( $where );
		$this->index ();
	}
}
?>