<?php
class BusinessAction extends BaseAction
{
	function index() {
	
		$companyname = $_POST ['companyname'];
		$sdate = $_POST ['sdate'];
		$edate = $_POST ['edate'];
		$interactiveway=$_POST ['interactiveway'];
		$linker=$_POST ['linker'];
		$specificmatter=$_POST ['specificmatter'];
		$where = $this->getWhere ();
		if (! empty ( $sdate ))
			$where = $where . " and date>='" . $sdate . "'";
		if (! empty ( $edate )) {
			$where = $where . " and date<='" . $edate . "'";
		}
		if (! empty ( $companyname )) {
			$where = $where . " and companyname like '%" . $companyname . "%'";
		}
		if (! empty ( $linker )) {
			$where = $where . " and linkername like '%" . $linker . "%'";
		}
		if (! empty ( $interactiveway )) {
			$where = $where . " and interactiveway = '" . $interactiveway . "'";
		}
		if (! empty ( $specificmatter )) {
			$where = $where . " INSTR(specificmatters,'".$specificmatter."')>0";
		}
		import ( "ORG.Util.Page" );
		$model = new BusinessModel ();
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index ();
	}
	function insert() {
		$contract = new BusinessModel();
		try {
			$contract->startTrans();
			//保存業務
			$data = $contract->create ();
			$matters=implode(",", $_POST['specific']);
			$data['specificmatters']=$matters;
			$contract->add ( $data );
			//保存工作日誌
			$work=new WorkModel();
			$data['type']=1;
			$data['remark']=$matters;
			$data['description']=$_POST['detail'];
			$data['status']=$_POST['state'];
			$data['uid']=$this->getId();
			$data['uname']=$this->getName();
			$data['ucode']=$this->getCode();
			$work->add($data);
			//查詢提示
			$this->getRemind();
			$this->index ();
			$contract->commit();
		} catch (Exception $e) {
			$contract->rollback();
		}
	
	}
	function view()
	{
		$id=$_GET['id'];
		$model=new BusinessModel();
		$business=$model->find($id);
		$this->assign("business",$business);
		$this->display();
	}
	function getRemind()
	{
		$model = new WorkModel ();
		$where = $this->getWhere();
		$where = $where . " and awoke =1";
		$where = $where . " and uid =".$this->getId();
		$count = $model->where ( $where )->count ();
		$_SESSION[C("AWOKE_WORK_KEY")]=$count;
	}
	function edit()
	{
		$id=$_GET['id'];
		$model=new BusinessModel();
		$business=$model->find($id);
		$this->assign("business",$business);
		$this->display();
	}
	function update()
	{
		$contract = new BusinessModel();
		try {
			$contract->startTrans();
			//保存業務
			$data = $contract->create ();
			$matters=implode(",", $_POST['specific']);
			$data['specificmatters']=$matters;
			$contract->save ( $data );
			$this->index ();
			$contract->commit();
		} catch (Exception $e) {
			$contract->rollback();
		}
	}
	function delete() {
		$id = $_GET ['id'];
		$business = new BusinessModel ();
		$business->delete ( $id );
		$this->index ();
	}
	
	#-----------------------------------------------------------------------
	
	function bid()
	{
		$state=$this->getParam('sstate');
		$clientname=$this->getParam('sclientname');
		$biddate=$this->getParam('sbiddate');
		$bid=M('business_bid');
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		if(!empty($state))
		{
			$where.=" AND state ='$state'";
		}
		if(!empty($clientname))
		{
			$where.=" AND state like '%$clientname%'";
		}
		if(!empty($biddate))
		{
			$where.=" AND DATEDIFF(biddate,'$biddate')";
		}
		$count = $bid->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $bid->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display('bid');
	}
	function addBidPage()
	{
		$this->display('addBid');
	}
	function addBid()
	{
		$bid=M('business_bid');
		$bidDetail=M('business_bid_detail');
		$biddata = $bid->create ();
		try {
			$bid->startTrans ();
			$biddata = $bid->create ();
			$bidid = $biddata ['id'];
			if (empty ( $bidid ))
				$bidid = $bid->add ( $biddata );
			else {
				$bid->save ( $biddata );
				// 刪除原來的明細
				$bidDetail->execute ( "DELETE FROM business_bid_detail WHERE bid=$bidid" );
			}
			
			// 添加採購明細
			$details = $_POST ['detail'];
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$datas = explode ( ",", $value );
					$data ['name'] = $datas [0];
					$data ['unit'] = $datas [1];
					$data ['price'] = $datas [2];
					$data ['bid'] = $bidid;
					$bidDetail->add ( $data );
				}
			}
			$bid->commit ();
		} catch ( Exception $e ) {
			$bid->rollback ();
		}
		$this->bid ();
	}
	
	function editBid()
	{
		$id=$_GET['id'];
		$bid=M('business_bid');
		$data=$bid->find($id);
		$this->assign('bid',$data);
		$bidDetail=M('business_bid_detail');
		$datas=$bidDetail->where('bid='.$id)->select();
		$this->assign('detail',$datas);
		$this->addBidPage();
	}
	function viewBid()
	{
		$id=$_GET['id'];
		$bid=M('business_bid');
		$data=$bid->find($id);
		$this->assign('bid',$data);
		$bidDetail=M('business_bid_detail');
		$datas=$bidDetail->where('bid='.$id)->select();
		$this->assign('detail',$datas);
		$this->display('viewBid');
	}
	function deleteBid()
	{
		$id=$_GET['id'];
		$bid=M('business_bid');
		$bid->delete($id);
		$this->bid ();
	}
}
?>