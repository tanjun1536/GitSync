<?php
class LevelAction extends BaseAction {
	function index() {
		import ( "ORG.Util.Page" );
		$sql = "SELECT t.id,t.`lcode` ,t.`remark`,(SELECT COUNT(id) FROM user WHERE level =t.`id`) AS users FROM level t  where t.code='" . $this->getCode () . "' order by ordernumber";
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
	function insert() {
		$level = new LevelModel ();
		$data = $level->create ();
		if (empty ( $_POST ['id'] ))
			$level->add ();
		else
			$level->save ();
		$this->index ();
	}
	function edit() {
		$id = $_GET ['id'];
		$level = new LevelModel ();
		$data = $level->find ( $id );
		$this->assign ( "level", $data );
		$this->index ();
	}
	function delete() {
		$id = $_GET ['id'];
		$level = new LevelModel ();
		$level->delete($id);
		$this->index ();
	}
}
?>