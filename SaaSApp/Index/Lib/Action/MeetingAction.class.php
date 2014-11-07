<?php
include 'admin/Common/zip.php';
class MeetingAction extends BaseAction {
	function index() {
		$date = $_POST ['date'];
		$state = $_POST ['state'];
		$where = $this->getWhere ();
		if (! empty ( $date ))
			$where = $where . " and day='" . $date . "'";
		if (! empty ( $state )) {
			$where = $where . " and state='" . $state . "'";
			$this->assign ( "state", $state );
		}
		import ( "ORG.Util.Page" );
		$model = new MeetingModel ();
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
	function insert() {
		import ( "ORG.Net.UploadFile" );
		$meet = new MeetingModel ();
		try {
			$meet->startTrans ();
			$up = new UploadFile ();
			$up->savePath = ATTCHEMENT_PATH_MEETFILE;
			$up->saveRule = 'uniqid';
			$up->uploadReplace = true;
			$data = $meet->create ();
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
			$ret = $meet->add ( $data );
			$this->checkExcept ( $ret );
			// 发布信息到一般信息
			$url = "<a href='http://hohsin.24hours.com.tw". __APP__ . "/Meeting/view?id=" . $ret."' >點擊查看</a>";
			$cont = "您有一則新的會議通知請點擊以下連結查看<br>$url";
			$msg = M ( 'msg' );
			$msgData ['senderid'] = $data ['starter'];
			$msgData ['title'] = '會議通知';
			$msgData ['senddate'] = date ( 'Y-m-d' );
			$msgData ['isread'] = 0;
			$msgData ['cont'] = $cont;
			$msgData ['sendername'] = $_POST ['startername'];
			$msgData ['code'] = $data ['code'];
			$msgData ['receiversid'] = $data ['partersid'].",".$this->id;
			$msgData ['receiversname'] = $data ['partersname'];
			$ret = $msg->add ( $msgData );
			$userids = $data ['partersid'];
			$sql = "select * from `user` where id in ($userids)";
			$users = $meet->query ( $sql );
			if (count ( $users ) > 0) {
				foreach ( $users as $u ) {
					if (! empty ( $u ['email'] )) {
						$emails [] = $u ['email'];
					}
				}
				if (count ( $emails ) > 0) {
					$this->send_email ( $emails, '會議通知', $cont );
				}
			}
			
			$this->checkExcept ( $ret );
			
			$meet->commit ();
		} catch ( Exception $e ) {
			$meet->rollback ();
		}
		$this->index ();
	}
	function changeState() {
		$id = $_GET ['id'];
		$state = $_GET ['state'];
		$data ['state'] = $state;
		$m = M ( 'Meeting' );
		$m->where ( 'id=' . $id )->save ( $data );
		$this->index ();
	}
	function record() {
		$id = $_GET ['id'];
		$sql = "SELECT
				  m.*,hu.name AS hname ,hu.ucode AS hucode,ru.name AS rname ,ru.ucode AS rucode,su.name AS sname ,su.ucode AS sucode
				FROM meeting m 
				INNER JOIN user hu
				ON hu.id=m.hoster
				INNER JOIN user ru
				ON ru.id=m.recorder
				INNER JOIN user su
				ON su.id=m.starter WHERE m.id=" . $id;
		$model = new Model ();
		$meet = $model->query ( $sql );
		$this->assign ( "meet", $meet );
		$mc = M ( 'meetingchoice' );
		$choices = $mc->where ( 'meetingid=' . $id )->select ();
		$this->assign ( "choices", $choices );
		$this->display ( 'record' );
	}
	function view() {
		$id = $_GET ['id'];
		$sql = "SELECT
		m.*,hu.name AS hname ,hu.ucode AS hucode,ru.name AS rname ,ru.ucode AS rucode,su.name AS sname ,su.ucode AS sucode
		FROM meeting m
		INNER JOIN user hu
		ON hu.id=m.hoster
		INNER JOIN user ru
		ON ru.id=m.recorder
		INNER JOIN user su
		ON su.id=m.starter WHERE m.id=" . $id;
		$model = new Model ();
		$meet = $model->query ( $sql );
		$this->assign ( "meet", $meet [0] );
		$mc = M ( 'meetingchoice' );
		$choices = $mc->where ( 'meetingid=' . $id )->select ();
		$this->assign ( "choices", $choices );
		$this->display ( 'view' );
	}
	function delete() {
		$m = new MeetingModel ();
		$m->delete ( $_GET ['id'] );
		$this->index ();
	}
	function addRecord() {
		$changefactors = $_POST ['changefactors'];
		if ($changefactors == 1) {
			$this->changeFactParters ();
			$this->record ();
		} else {
			$meet = new MeetingModel ();
			try {
				
				$meet->startTrans ();
				$data = $meet->create ();
				import ( "ORG.Net.UploadFile" );
				$up = new UploadFile ();
				$up->savePath = ATTCHEMENT_PATH_MEETFILE;
				$up->saveRule = 'uniqid';
				$up->uploadReplace = true;
				$meet = new MeetingModel ();
				$data = $meet->create ();
				if ($up->upload ()) {
					$paths = "";
					$files = $up->getUploadFileInfo ();
					for($i = 0; $i <= count ( $files ); $i ++) {
						$paths = $paths . $files [$i] ["savename"];
						if ($i < count ( $files ) - 1)
							$paths = $paths . ",";
					}
					$data ['atts'] = $data ['atts'] . "," . $paths;
				} else {
					// println ( $up->getErrorMsg () );
				}
				$ret = $meet->save ( $data );
				$this->checkExcept ( $ret );
				// 保存決議事項
				$mc = M ( 'Meetingchoice' );
				$choice = $_POST ['decedechoice'];
				if (! empty ( $choice )) {
					foreach ( $choice as $key => $value ) {
						$datas = explode ( "$", $value );
						$mcs ['cont'] = $datas [0];
						$mcs ['users'] = $datas [1];
						$mcs ['meetingid'] = $data [id];
						$ret = $mc->add ( $mcs );
						$this->checkExcept ( $ret );
					}
				}
				
				$meet->commit ();
			} catch ( Exception $e ) {
				$meet->rollback ();
			}
			$this->index ();
		}
	}
	function changeFactParters() {
		$id = $_POST ['id'];
		$meet = M ( 'meeting' );
		$meetData ['id'] = $id;
		$meetData ['factpartersid'] = $_POST ['factpartersid'];
		$meetData ['factpartersname'] = $_POST ['factpartersname'];
		$meet->save ( $meetData );
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( ATTCHEMENT_PATH_MEETFILE . $name, $name );
	}
	function zipdown() {
		$zip = new PHPZip ();
		$paths = array ();
		$name = $_GET ['names'];
		$names = explode ( ",", $name );
		$i = 0;
		foreach ( $names as $key => $value ) {
			$paths [$i] = ATTCHEMENT_PATH_MEETFILE . $value;
			$i ++;
		}
		$zip->createZip ( $paths, "all.zip", true );
	}
}
?>