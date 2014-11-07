<?php
class LimitAction extends BaseAction {
	function index() {
		$key = $_POST ["key"];
		import ( "ORG.Util.Page" );
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$sql = "SELECT *,(SELECT COUNT(id) FROM user WHERE role=r.id) AS users FROM role r  where r.code='" . $this->getCode () . "' order by ordernumber";
		$model = new Model ();
		$roles = $model->query ( $sql );
		$count = count ( $roles );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$roles = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $roles );
		parent::index ();
	
	}
	function add() {
		$menu = new MenuModel ();
		$menus = $menu->relation ( true )->where ( "parent_id is null" )->select ();
		$this->assign ( "menus", $menus );
		parent::add ();
	}
	function insert() {
		$role = M ( 'role' );
		$roledetail = M ( 'role_menu' );
		try {
			$role->startTrans ();
			$data = $role->create ();
			$id = $_POST ['id'];
			if (empty ( $id ))
			{
				$ret = $role->add ( $data );
				$this->checkExcept($ret);
			}
			else {
				$ret=$role->save ( $data );
				$this->checkExcept($ret);
				$ret=$roledetail->execute ( "DELETE FROM role_menu WHERE rid=$id" );
				$this->checkExcept($ret);
			}
			// 角色
			$details = json_decode ( $_POST ['menus'], true );
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$rdata ['rid'] = $id;
					$rdata ['mid'] = $value ['mi'];
					$rdata ['ext'] = $value ['ext'];
					$ret=$roledetail->add ( $rdata );
					$this->checkExcept($ret);
				}
			}
			$role->commit ();
		} catch ( Exception $e ) {
			$role->rollback ();
		}
		
		$this->index ();
	}
	function edit() {
		
		$DM = new Model ();
		$id = $_GET ['id'];
		$role=new RoleModel();
		$rdata=$role->find($id);
		$this->assign ( "role", $rdata );
		$sql = "SELECT 
		  m.`id`
		FROM
		  menu m 
		  INNER JOIN role_menu rm 
		    ON m.`id` = rm.`mid` 
		WHERE rid = $id ";
		$data = $DM->query ( $sql );
		foreach ( $data as $key => $value ) {
			$rm .=  ",".$value ['id'];
		}
		
		if(strlen($rm)>0)
		{
			$rm=substr($rm, 1);
		}
		$this->assign ( "rm", $rm );
		$sql = "SELECT 
		  m.`id`,rm.`ext`
		FROM
		  menu m 
		  INNER JOIN role_menu rm 
		    ON m.`id` = rm.`mid` 
		  WHERE rm.`ext` IS NOT NULL  AND rm.`rid`= $id";
		$data = $DM->query ( $sql );
		
		$this->assign ( "exts", $data );
		$this->add ();
	}
	function mm($var) {
		return ($var ['parent_id'] == null);
	}
	function cm($var) {
		return ($var ['parent_id'] != null);
	}
	function delete() {
		$id = $_GET ['id'];
		$role = new RoleModel ();
		$role->delete ( $id );
		$this->index ();
	}
}
?>