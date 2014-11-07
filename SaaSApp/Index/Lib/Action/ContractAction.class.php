<?php
class ContractAction extends BaseAction {
	function index() {
		
		$comname = $_POST ['comname'];
		$sdate = $_POST ['ssdate'];
		$edate = $_POST ['eedate'];
		$where = $this->getWhere ();
		if (! empty ( $sdate ))
			$where = $where . " and sdate>='" . $sdate . "'";
		if (! empty ( $edate )) {
			$where = $where . " and edate<='" . $edate . "'";
		}
		if (! empty ( $comname )) {
			$where = $where . " and companyname like '%" . $comname . "%'";
		}
		import ( "ORG.Util.Page" );
		$model = new ContractModel ();
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		parent::index ();
	}
	function insert() {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_CONTRACTFILE;
		$up->saveRule='uniqid';
		$up->uploadReplace = true;
		$contract = new ContractModel ();
		$data = $contract->create ();
		if ($up->upload ()) {
			$paths = "";
			$files = $up->getUploadFileInfo ();
			for($i = 0; $i <= count ( $files ); $i ++) {
				$paths = $paths . $files [$i] ["savename"];
				if ($i < count ( $files ) - 1)
					$paths = $paths . ",";
			}
			$data ['att'] = $paths;
		}
		$contract->add ( $data );
		$this->redirect("index");
	}
	function update() {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_CONTRACTFILE;
		$up->uploadReplace = true;
		$up->saveRule='uniqid';
		$contract = new ContractModel ();
		$data = $contract->create ();
		if ($up->upload ()) {
			$paths = "";
			$files = $up->getUploadFileInfo ();
			for($i = 0; $i <= count ( $files ); $i ++) {
				$paths = $paths . $files [$i] ["savename"];
				if ($i < count ( $files ) - 1)
					$paths = $paths . ",";
			}
			$data ['att'] = $paths;
		}
		$contract->save ( $data );
		$this->index ();
	}
	function edit()
	{
		$id=$_GET['id'];
		$model=new ContractModel();
		$contract=$model->find($id);
		$this->assign("contract",$contract);
		$this->display();
	}
	function delete() {
		$id = $_GET ['id'];
		$business = new ContractModel ();
		$business->delete ( $id );
		$this->index ();
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( ATTCHEMENT_PATH_CONTRACTFILE . $name, $name );
	
	}
}
?>