<?php
class FormAction extends BaseAction {
	function index() {
		// 加载类别
		$formtype = new FormtypeModel ();
		$types = $formtype->selectByCode ();
		$this->assign ( "types", $types );
		
		//查询列表
		$model = new FormViewModel();
		import ( "ORG.Util.Page" );
		$where = " Form.code='".$this->getCode()."'";
		if(!empty($_POST['type']))
		{
			$where=$where." and Form.type=".$_POST['type'];
			$this->assign("type",$_POST['type']);
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		parent::index ();
	}
	function add() {
		// 加载类别
		$formtype = new FormtypeModel ();
		$types = $formtype->selectByCode ();
		$this->assign ( "types", $types );
		
		parent::add ();
	}
	function insert() {
		
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_FORMFILE;
		$up->saveRule='uniqid';
		$up->uploadReplace = true;
		$form = new FormModel ();
		$data = $form->create ();
		if ($up->upload ()) {
			$file = $up->getUploadFileInfo ();
			$data ['atts'] = $file [0] ["savename"];
		}
		$form->add( $data );
		$this->index();
	}
	function delete() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = new FormModel();
		$model->delete ( $where );
		$this->index ();
	}
	function edit() {
		$id = $_GET ['id'];
		$type = new FormtypeModel ();
		$formtype = $type->find ( $id );
		$this->assign ( "formtype", $formtype );
		$this->category ();
	}
	function category() {
		$category = new FormtypeModel ();
		$list = $category->selectByCode ();
		$this->assign ( "list", $list );
		$this->display ( 'category' );
	}
	function addCategory() {
		$category = new FormtypeModel ();
		$category->create ();
		if (empty ( $_POST ['id'] ))
			$category->add ();
		else
			$category->save ();
		$this->category ();
	}
	function deleteCategory() {
		$id = $_GET ['id'];
		$ft = new FormtypeModel ();
		$ft->delete ( $id );
		$this->category ();
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( ATTCHEMENT_PATH_FORMFILE . $name, $name );
	
	}
}
?>