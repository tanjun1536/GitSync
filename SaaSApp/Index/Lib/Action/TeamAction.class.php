<?php
class TeamAction extends BaseAction {
	function index() {
		$key = $_POST ["key"];
		import ( "ORG.Util.Page" );
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$sql = "SELECT t.id,t.`name` ,d.`name` AS depart,(SELECT COUNT(id) FROM user WHERE team =t.`id`) AS users FROM team t INNER JOIN depart d ON t.`depart`=d.`id` where d.code='" . $this->getCode () . "'";
		if (! empty ( $key )) {
			$sql = $sql . " and t.name like '%" . $key . "%'";
		}
		$model = new Model ();
		$teams = $model->query ( $sql );
		$count = count ( $teams );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$teams = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "teams", $teams );
		parent::index ();
	}
	function insert() {
		$team = new TeamModel ();
		$data = $team->create ();
		if (empty ( $data ['id'] ))
			$team->add ();
		else $team->save();
		$this->index ();
	}
	function edit() {
		$team = new TeamModel ();
		$id=$_GET ["id"];
		$data=$team->find ($id);
		$this->assign ( "team", $data );
		$this->assign("id",$id);
		$this->index();
	}
	
	function delete() {
		$model = new TeamModel ();
		$model->delete ( $_GET ["id"] );
		$this->index ();
	}
}
?>