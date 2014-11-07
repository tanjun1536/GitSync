<?php
class CustomerAction extends BaseAction {
	
	function customerTypeList()
	{
		$this->onesql_page("SELECT * FROM client_type");
		$this->display('customertype');
	}
	function addCustomerType()
	{
		$dao=M("client_type");
		$data=$dao->create();
		if(empty($data['id']))
		{
			$dao->add($data);
		}
		else {
			$dao->save($data);
		}
		$this->redirect("customerTypeList");
	}
	function editCustomerType()
	{
		$id=$_GET['id'];
		$dao=M("client_type");
		$data=$dao->find($id);
		$this->assign("ct",$data);
		$this->customerTypeList();
	}
	function deleteCustomerType()
	{
		$id=$_GET['id'];
		$dao=M("client_type");
		$dao->delete($id);
		$this->redirect("customerTypeList");
	}
	
	function index()
	{
		$sql="SELECT * FROM client WHERE code = $this->code "; 
		$scn=$this->getParam("scn");
		$hyb=$this->getParam("hyb");
		if(!empty($scn))
			$sql.=" and companyname like '%$scn%'";
		if(!empty($hyb))
			$sql.=" and hytype = $hyb";
		$sql.=" ORDER by clientcode";
		$dao=new Model();
		$ctlist=$dao->query("SELECT * FROM client_type");
		$this->assign("ctlist",$ctlist);
		$this->onesql_page($sql);
		
		$this->display('index');
	}
	function exportExcel()
	{
	    $sql="SELECT `clientcode`,`clienttitle`,`linkername1`,`linkerphone1` FROM client WHERE code = $this->code ";
	    $scn=$this->getParam("scn");
	    $hyb=$this->getParam("hyb");
	    if(!empty($scn))
	        $sql.=" and companyname like '%$scn%'";
	    if(!empty($hyb))
	        $sql.=" and hytype = $hyb";
	    $sql.=" ORDER by clientcode";
	    $title = '客戶.xls';
	    $headers = '客戶編號,客戶名稱,聯絡人,電話';
	    $q = new Model ();
	    $data = $q->query ( $sql );
	    $this->export ( $title, $headers, $data );	
	}
	function editCustomer()
	{
		$id=$this->GetReqId();
		$this->GetProvince();
		$cus=M('client');
		$customer=$cus->find($id);
		$this->assign('customer',$customer);
		$ctlist=$cus->query("SELECT * FROM client_type");
		$this->assign("ctlist",$ctlist);
		$this->display('edit');
		
	}
	
	function addCustomer()
	{
		// 城市下來列表
		$this->GetProvince();
		$dao=new Model();
		$ctlist=$dao->query("SELECT * FROM client_type");
		$this->assign("ctlist",$ctlist);
		$this->display('add');
	}
	function viewCustomer()
	{
		$this->assign("view",true);
		$this->editCustomer();
	}
	function saveCustomer()
	{
		$cus=M('client');
		$data=$cus->create();
		if(empty($data['id']))
		{
			$cus->add($data);
		}
		else
		{
			$cus->save($data);
		}
		$this->redirect('index');
	}
	function deleteCustomer($model)
	{	
		$cus=M('client');
		$cus->delete($this->GetReqId());
		$this->redirect('index');
		
	}
}
?>