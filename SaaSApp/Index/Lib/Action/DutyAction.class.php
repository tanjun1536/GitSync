<?php
class DutyAction extends BaseAction
{
	function index()
	{
		$key = $_POST ["key"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$where.=" and id in(select uid from dutydelegate)";
		if (! empty ( $key )) {
			$where = $where . " and name like '%" . $key . "%'";
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->relation("dutydelegate")->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index();
	}
	function add()
	{
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$user=new UserModel();
		$users=$user->selectByCode();
		$this->assign ( "users", $users );
		parent::add();
	}
	function edit()
	{
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$user=new UserModel();
		$users=$user->selectByCode();
		$this->assign ( "users", $users );
		$data=$user->relation("dutydelegate")->find($_GET['id']);
		$this->assign ( "user", $data );
		parent::edit();
	}
	function insert()
	{
		$data['uid']=$_POST['user'];
		$this->addDuties ($data);
		$this->index();
	}
	/**
	 * @param data
	 * @param dd
	 * @param datas
	 */
	private function addDuties($data) {
		$duties=$_POST['duties'];
		if (! empty ( $duties )) {
			foreach ( $duties as $key => $value ) {
				$dd=new DutydelegateModel();
				$datas = explode ( ",", $value );
				$data ['code'] = $this->getCode();
				$data ['departmentname'] = $datas [0];
				$data ['delegatorname'] = $datas [1];
				$data ['duty'] = $datas [2];
				$dd->add ( $data );
			}
		}
	}

	function update()
	{
		$uid=$_POST['uid'];
		$q=new Model();
		$q->startTrans();
		try {
			$sql="delete from dutydelegate where uid=".$uid;
			$q->query($sql);
			$data['uid']=$_POST['uid'];
			$this->addDuties($data);
			$q->commit();
			$this->index();
		}
		catch (Exception $e)
		{
			$q->rollback();
		}
	
		
	}
	function delete($id='')
	{
		if(empty($id))
		{
			$id=$_GET['id'];
		}
		$q=new Model();
		$sql="delete from dutydelegate where uid=".$id;
		$q->query($sql);
		$this->index();
	}
}
?>