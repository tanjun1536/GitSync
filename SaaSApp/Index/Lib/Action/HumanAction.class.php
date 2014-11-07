<?php
class HumanAction extends BaseAction {
	function index() {
		$key = $_POST ["key"];
		$model = new EncouragementpunishViewModel ();
		import ( "ORG.Util.Page" );
		$where = "Encouragementpunish.code='" . $this->getCode () . "'";
		if (! empty ( $key )) {
			$where = $where . " and Encouragementpunish.uname like '%" . $key . "%'";
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index ();
	}
	function add() {
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		parent::add ();
	}
	function edit() {
		$id = $_GET ["id"];
		$ec = new EncouragementpunishViewModel ();
		$data = $ec->find ( $id );
		$this->assign ( "en", $data );
		$this->display();
	}
	function update() {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = "./Public/Uploads/";
		$up->thumb = true;
		$up->thumbMaxHeight = "100";
		$up->thumbMaxWidth = "100";
		$up->saveRule = time ();
		$up->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg' 
		);
		$ec = new EncouragementPunishModel ();
		$data = $ec->create ();
		$oData = $ec->find ( $data ["id"] );
		if ($up->upload ()) {
			$image = $up->getUploadFileInfo ();
			$data ['attachement'] = $image [0] ["savename"];
		} else {
			$data ['attachement'] = $oData ['attachement'];
		}
		$ec->save ( $data );
		$this->index ();
	}
	function insert() {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = "./Public/Uploads/";
		$up->thumb = true;
		$up->thumbMaxHeight = "100";
		$up->thumbMaxWidth = "100";
		$up->saveRule = time ();
		$up->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg' 
		);
		$ec = M('encouragementpunish');
		$data = $ec->create ();
		$data['uid']=$this->getId();
		$data['uname']=$this->getName();
		$data['code']=$this->getCode();
		
		if ($up->upload ()) {
			$image = $up->getUploadFileInfo ();
			$data ['attachement'] = $image [0] ["savename"];
		}
		$ec->add ( $data );
		$this->index ();
	}
}
?>