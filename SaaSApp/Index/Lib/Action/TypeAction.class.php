<?php
class TypeAction extends BaseAction {
	function category($id='') {
		$model = new TypeModel ();
		$list = $model->selectByCode();
		$this->assign ( "list", $list );
		if(empty($id))
			$this->assign ( "action", "addcategory" );
		else 
		{
			$this->assign ( "action", "alertcategory" );
			$this->assign("id",$id);
		}
		$this->display('category');
	}
	function childcategory($id='')
	{
		$model = new TypeModel ();
		$list = $model->selectByCode();
		$this->assign ( "types", $list );
		if(empty($id))
			$this->assign ( "action", "addchildcategory" );
		else
		{
			$this->assign ( "action", "alertchildcategory" );
			$this->assign("id",$id);
		}
		// 导入分页类库
		import ( "ORG.Util.Page" );
		$model = new Model ();
		// 查询
		$sql = "SELECT t.`id` AS tid,t.`ccode`,t.`name` AS mname,ct.* FROM TYPE t INNER JOIN childtype ct ON t.`id`=ct.`type` ";
		
		$sql = $sql . " WHERE t.code='" . $this->getCode()."'";
		
		$type = $_POST ['stype'];
		if (! empty ( $type ))
			$sql = $sql . " and t.id='" . $type . "'";
		
		$childtypes = $model->query ( $sql );
		$count = count ( $childtypes );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$checks = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $childtypes );
		
		$this->display('childcategory');
	}
	function addchildcategory()
	{
		$model=M('childtype');
		$model->create();
		$model->add();
		$this->childcategory();
	}
	function editcategory() {
		$model=new TypeModel();
		$type=$model->find($_GET ["id"]);
		$this->assign("type",$type);
		$this->category ($_GET ["id"]);
	}
	function editchildcategory() {
		$model= M('childtype');
		$type=$model->find($_GET ["id"]);
		$this->assign("type",$type);
		$this->childcategory ($_GET ["id"]);
	}
	
	function addcategory() {
		$model = new TypeModel ();
		$model->create ();
		$model->add ();
		$this->category ();
	}
	function alertcategory() {
		$model = new TypeModel ();
		$model->create ();
		$model->save();
		$this->category ();
	}
	function alertchildcategory()
	{
		$model = M('childtype');
		$model->create ();
		$model->save();
		$this->childcategory ();
	}
	function deletecategory() {
		$model = new TypeModel ();
		$model->delete ( $_GET ["id"] );
		$this->category ();
	}
	function deletechildcategory() {
		$model =  M('childtype');
		$model->delete ( $_GET ["id"] );
		$this->childcategory ();
	}
}
?>