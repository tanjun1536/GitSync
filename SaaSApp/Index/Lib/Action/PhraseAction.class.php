<?php
class PhraseAction extends BaseAction {
	function index() {
		$model = new Model ();
		$sql="SELECT * FROM phrase where `code`='$this->code'  ORDER BY ordernumber";
		$list = $model->query($sql);
		$this->assign ("list", $list );
		parent::index ();
	}
	function insert() {
		$model = new PhraseModel ();
		$model->create ();
		$model->add ();
		$this->index ();
	}
	function delete() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = new PhraseModel ();
		$model->delete ( $where );
		$this->index ();
	}
}
?>