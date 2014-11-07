<?php
class CompanyAction extends BaseAction
{
	function index()
	{
		$key = $_POST ["key"];
		$model = M('company');
		import ( "ORG.Util.Page" );
		$where ="";
		if (! empty ( $key )) {
			$where = $where . " and name like '" . $key . "'";
		}
		$count = $model->where ( $where )->count ();
		$p=$this->getPage($count);
		$page=$p->show();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index();
	}
	function add()
	{
		//流水號
// 		$code=getCompanyLineCode();
// 		$this->assign("code",$code);
		// 城市下來列表
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		parent::add();
	}
	function edit(){
		$id=$_GET['id'];
		if(empty($id))
			$code=$_GET['code'];
		$c=M('company');
		if(!empty($id))
		{
			$com=$c->find($id);
			$this->assign("com",$com);
		}
		else
		{
			$com=$c->where("code ='".$code."' ")->select();
			$this->assign("com",$com[0]);
		}
		
		// 城市下來列表
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display();
	}
	function insert()
	{
		$c=M('company');
		$c->create();
		$c->add();
		$this->index();
	}
	function update()
	{
		$c=M('company');
		$c->create();
		$c->save();
		$this->index();
	}
	function delete() {
		$model = M('Company');
		$model->delete ( $_GET ["id"] );
		$this->index ();
	}
}
?>