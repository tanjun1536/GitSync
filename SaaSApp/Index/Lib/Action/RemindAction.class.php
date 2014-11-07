<?php
class RemindAction extends BaseAction
{
	function index()
	{
		$model=new WorkModel();
		$where=$this->getWhere();
		$where=$where." and awoke=1";
		$where=$where." and uid=".$this->getId();
		$where .= " and UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(DATE_ADD(
			    STR_TO_DATE(
			      CONCAT(
			        DATE(`date`),
			        ' ',
			        ehour,
			        ':',
			        eminute,
			        ':00'
			      ),
			      '%Y-%m-%d %H:%i:%s'
			    ),INTERVAL overday DAY)
			  ) < 0  ";
		$list=$model->where($where)->select();
		$this->assign("list",$list);
		parent::index();
	}
	function extindex()
	{
		$model = new WorkViewModel ();
		import ( "ORG.Util.Page" );
		$date=$this->getParam("sdate");
		$where = $this->getWhereWithTable ( 'Work' );
		$where = $where . " and Work.uid=" . $this->getId ();
		$where=$where." and Work.awoke=0";
		if(!empty($date)) $where.=" AND datediff(Work.date,'$date')=0";
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display();
	}
}
?>