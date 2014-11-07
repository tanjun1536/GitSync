<?php
class AcceptAction extends BaseAction {
	
	// 點交驗收人員管理
	function accepterList() {
		$this->display ( 'accepterList' );
	}
	function accepterAdd() {
		$this->display ( 'accepteAdd' );
	}
	// 點交驗收管理
	function acceptList() {
		$dao = M ( "accept" );
		$where = " code='$this->code'";
		$this->table_page ( $dao, $where );
		$this->display ( 'acceptList' );
	}
	function acceptAdd() {
		$this->display ( 'acceptAdd' );
	}
	function acceptEdit() {
		$accept = M ( "accept" );
		$data = $accept->find ( $_GET ['id'] );
		$this->assign ( "accept", $data );
		$this->display ( 'acceptEdit' );
	}
	function acceptDelete() {
		$accept = M ( "accept" );
		$accept->delete ( $_GET ['id'] );
		$this->redirect ( "Accept/acceptList" );
	}
	function acceptSave() {
		$accept = M ( "accept" );
		$data = $accept->create ();
		if (empty ( $data ['id'] )) {
			$accept->add ( $data );
		} else {
			$accept->save ( $data );
		}
		$this->redirect ( "Accept/acceptList" );
	}
	function acceptCheckList() {
		$accept = $this->getParam('accept');
		$acceptcheck=M('accept_check');
		$where=" accept= $accept";
		$this->table_page($acceptcheck, $where);
		$this->display ( 'acceptCheckList' );
	}
	function acceptCheckAdd() {
		$accept = $_GET['accept'];
		$user = M ( 'user' );
		$list=$user->query("select * from user where id in( SELECT acceptuser from accept_user where accept=$accept)");
		$this->assign("list",$list);
		$this->display ( 'acceptCheckAdd' );
	}
	function acceptCheckEdit() {
		$acceptcheck=M('accept_check');
// 		$user = M ( 'user' );
// 		$list=$user->query("select * from user where id in( SELECT acceptuser from accept_user where accept=$accept)");
// 		$this->assign("list",$list);
		$data=$acceptcheck->find($_GET['id']);
		$this->assign("acc",$data);
		$this->display ( 'acceptCheckEdit' );
	}
	function acceptCheckSave() {
		
		$accept = $_POST ['accept'];
		$acceptcheck=M('accept_check');
		$data=$acceptcheck->create();
		$this->UpLoadFile(ATTCHEMENT_PATH_ACCEPT,$data);
		if(empty($data['id']))
		{
			$acceptcheck->add($data);
		}
		else {
			$acceptcheck->save($data);
		}
		$this->redirect("Accept/acceptCheckList?accept=$accept" );
	}
	function acceptUserList() {
		$accept = $_GET['accept'];
		$user = M ( 'user' );
		$this->table_page($user, " id in( SELECT acceptuser from accept_user where accept=$accept)");
		$this->display ( 'acceptUserList' );
	}
	function acceptUserSave() {
		$accept = $_POST ['accept'];
		$users = $_POST ['users'];
		$acceptuser = M ( 'accept_user' );
		$acceptuser->startTrans ();
		try {
			foreach ( $users as $user ) {
				$data['accept']=$accept;
				$data['acceptuser']=$user;
				$ret=$acceptuser->add($data);
				$this->checkExcept($ret);
			}
			$acceptuser->commit ();
		} catch ( Exception $e ) {
			$acceptuser->rollback ();
		}
		
		$this->redirect ( "Accept/acceptUserList?accept=$accept" );
	}
	function acceptUserAdd() {
		$this->getDeparts ();
		$this->display ( 'acceptUserAdd' );
	}
	function acceptUserDelete() {
		$accept = $_GET['accept'];
		$user=$_GET['id'];
		$acceptuser = new Model();
		$sql="DELETE FROM accept_user WHERE accept=$accept AND acceptuser=$user ";
		$acceptuser->execute($sql);
		$this->redirect ( "Accept/acceptUserList?accept=$accept" );
	}
}
?>