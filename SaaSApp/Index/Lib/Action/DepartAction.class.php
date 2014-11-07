<?php
class DepartAction extends BaseAction {
	function index() {
		
		$user=M('user');
		$id = $_GET ["id"];
		if(empty($id))
		{
			$users=$user->where("code = '".parent::getCode()."'")->select();
		}
		else {
			$users=$user->where("code = '".parent::getCode()."' AND depart=".$id)->select();
		}
		$this->assign('users',$users);
		$key = $_POST ["key"];
		import ( "ORG.Util.Page" );
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$sql = "SELECT 
			  d.`id`,
			  d.`name`,
			  (SELECT NAME FROM `user` WHERE id= d.`leader`) AS leader,
			  (SELECT 
			    COUNT(id) 
			  FROM
			    `user` u 
			  WHERE u.`depart` = d.`id`) AS users 
			FROM
			  depart d 
			WHERE d.code ='" . $this->getCode () . "'";
		if (! empty ( $key )) {
			$sql = $sql . " and d.name like '%" . $key . "%'";
		}
		$model = new Model ();
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
	function edit() {
		$depart = new DepartModel ();
		$id = $_GET ["id"];
		$data = $depart->find ( $id );
		$this->assign ( "depart", $data );
		$this->assign ( "id", $id );
		$this->index ();
	}
	function insert() {
		$depart = new DepartModel ();
		try {
			$depart->startTrans();
			$data = $depart->create ();
			$id=$data ['id'];
			if (empty ( $id ))
				$id=$depart->add ();
			else
				$depart->save ();
			//更改主管的depart
			$user=M('user');
			$datas['depart']=$id;
			$user->where('id='.$data['leader'])->save($datas);
			
			$depart->commit();
		} catch (Exception $e) {
			$depart->rollback();
		}
		
		$this->index ();
	}
	
	function delete() {
		$model = new DepartModel ();
		$model->delete ( $_GET ["id"] );
		$this->index ();
	}
}
?>