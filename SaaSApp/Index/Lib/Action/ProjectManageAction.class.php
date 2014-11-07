<?php
class ProjectManageAction extends BaseAction {
	
	/**
	 * 报价
	 */
	function PriceList() {
		$depart = $_POST ['sdepart'];
		$date = $_POST ['sdate'];
		$state = $_POST ['sstate'];
		$where = $this->getWhere ();
		if (! empty ( $depart )) {
			$where .= " AND BUunitName like '%$depart%'";
		}
		if (! empty ( $date )) {
			$where .= " AND datediff(pricedate,'$date') =0 ";
		}
		if (! empty ( $state )) {
			$where .= " AND state =''$state";
		}
		$dao = M ( "project_price" );
		
		$this->table_page ( $dao, $where );
		
		$this->display ( 'PriceList' );
	}
	// 新增报价
	function PriceAdd() {
		$this->getDeparts ();
		
		$this->GetProvince ();
		
		$linecode=getProjectPriceLineCode();
		
		$this->assign("linecode",$linecode);
		
		$this->display ( 'PriceAdd' );
	}
	function PriceSave() {
		$price = M ( "project_price" );
		// 保存主表
		try {
			$price->startTrans ();
			$data = $price->create ();
			$id = $data ['id'];
			if (empty ( $id )) {
				$id = $price->add ( $data );
				$this->addDetail ( $id, false );
			} else {
				$price->save ( $data );
				$this->addDetail ( $id, true );
			}
			$price->commit ();
		} catch ( Exception $e ) {
			$price->rollback ();
		}
		
		$this->redirect ( __URL__ . "/PriceList" );
	}
	function addDetail($id, $isUpdate) {
		$m = M ( 'project_price_detail' );
		if ($isUpdate)
			$m->where ( 'price =' . $id )->delete ();
		$details = $_POST ['details'];
		$data ['price'] = $id;
		foreach ( $details as $key => $val ) {
			$value = explode ( ',', $val );
			$data ['productname'] = $value [0];
			$data ['productquantity'] = $value [1];
			$data ['productunit'] = $value [2];
			$data ['productprice'] = $value [3];
			$data ['productfj'] = $value [4];
			$data ['remark'] = $value [5];
			$m->add ( $data );
		}
	}
	function changeState() {
		$price = M ( "project_price" );
		$data ['id'] = $_GET ['id'];
		$data ['state'] = $_GET ['state'];
		$price->save ( $data );
		$this->redirect ( __URL__ . "/PriceList" );
	}
	function PriceEdit() {
		$id = $_GET ['id'];
		
		$price = M ( "project_price" );
		
		$price_detail = M ( 'project_price_detail' );
		
		$data = $price->find ( $id );
		
		$this->assign ( "price", $data );
		
		$detail = $price_detail->where ( 'price=' . $id )->select ();
		
		$this->assign ( "details", $detail );
		
		$this->getDeparts ();
		
		$this->GetProvince ();
		
		$this->display ( 'PriceEdit' );
	}
	function PricePrint() {
		$id = $_GET ['id'];
		
		$price = M ( "project_price" );
		
		$price_detail = M ( 'project_price_detail' );
		
		$sql = "SELECT 
			  *,
			  u.`name` AS undertakername,
			  pp.`name` AS projectprovincename,
			  cp.`name` AS clientprovincename,
			  pc.`name` AS projectcityname,
			  cc.`name` AS clientcityname 
			FROM
			  project_price p 
			  LEFT OUTER JOIN `user` u 
			    ON u.id = p.`undertaker` 
			  LEFT OUTER JOIN `area` pp 
			    ON pp.`id` = p.`projectprovince` 
			  LEFT OUTER JOIN `area` cp 
			    ON cp.`id` = p.`clientprovince` 
			  LEFT OUTER JOIN `area` pc 
			    ON pc.`id` = p.`projectcity` 
			  LEFT OUTER JOIN `area` cc 
			    ON cc.`id` = p.`clientcity` 
			    
			    WHERE p.`id`=$id";
		$data = $price->query ( $sql );
		
		$this->assign ( "price", $data [0] );
		
		$detail = $price_detail->where ( 'price=' . $id )->select ();
		
		$this->assign ( "details", $detail );
		
		$this->getDeparts ();
		
		$this->GetProvince ();
		
		$this->display ( 'PricePrint' );
	}
	function PriceDelete() {
		$id = $_GET ['id'];
		$price = M ( "project_price" );
		$price->delete ( $id );
		$price_detail = M ( 'project_price_detail' );
		$price_detail->where ( 'price =' . $id )->delete ();
		$this->redirect ( __URL__ . "/PriceList" );
	}
	
	/**
	 * 请款
	 */
	function InvoiceList() {
		$date = $_POST ['sdate'];
		$pricecode = $_POST ['spricecode'];
		$where = $this->getWhere ();
		if (! empty ( $date )) {
			$where .= " AND datediff(reqdate,'$date') =0 ";
			$this->assign ( 'sdate', $date );
		}
		if (! empty ( $pricecode )) {
			$where .= " AND pricecode ='$pricecode'";
			$this->assign ( 'spricecode', $pricecode );
		}
		$dao = M ( "project_invoice" );
		
		$this->table_page ( $dao, $where );
		
		$this->display ( 'InvoiceList' );
	}
	function InvoiceAdd() {
		$depart = M ( 'depart' );
		$data = $depart->find ( $this->getDepart () );
		$this->assign ( 'depart', $data );
		$this->display ( 'InvoiceAdd' );
	}
	function InvoiceSave() {
		$price = M ( "project_invoice" );
		// 保存主表
		try {
			$price->startTrans ();
			$data = $price->create ();
			$id = $data ['id'];
			if (empty ( $id )) {
				$id = $price->add ( $data );
				$this->addInvoiceDetail ( $id, false );
			} else {
				$price->save ( $data );
				$this->addInvoiceDetail ( $id, true );
			}
			$price->commit ();
		} catch ( Exception $e ) {
			$price->rollback ();
		}
		
		$this->redirect ( __URL__ . "/InvoiceList" );
	}
	function addInvoiceDetail($id, $isUpdate) {
		$m = M ( 'project_invoice_detail' );
		if ($isUpdate)
			$m->where ( 'invoice =' . $id )->delete ();
		$details = $_POST ['details'];
		$data ['invoice'] = $id;
		foreach ( $details as $key => $val ) {
			$value = explode ( ',', $val );
			$data ['productname'] = $value [0];
			$data ['productcount'] = $value [1];
			$data ['productprice'] = $value [2];
			$data ['totalprice'] = $value [3];
			$m->add ( $data );
		}
	}
	function InvoiceEdit() {
		$id = $_GET ['id'];
		
		$invoice = M ( "project_invoice" );
		
		$invoice_detail = M ( 'project_invoice_detail' );
		
		$data = $invoice->find ( $id );
		
		$this->assign ( "invoice", $data );
		
		$detail = $invoice_detail->where ( 'invoice=' . $id )->select ();
		
		$this->assign ( "details", $detail );
		
		$this->display ( 'InvoiceEdit' );
	}
	function InvoiceDelete() {
		$id = $_GET ['id'];
		$price = M ( "project_invoice" );
		$price->delete ( $id );
		$price_detail = M ( 'project_invoice_detail' );
		$price_detail->where ( 'invoice =' . $id )->delete ();
		$this->redirect ( __URL__ . "/InvoiceList" );
	}
	/**
	 * 抬头设定
	 */
	function TitleSetting() {
		$this->GetProvince ();
		$title = M ( 'project_title' );
		$data = $title->getByCode ( $this->code );
		$this->assign ( "title", $data );
		$this->display ( 'TitleSetting' );
	}
	/**
	 * 保存设定
	 */
	function TitleSave() {
		$title = M ( 'project_title' );
		$data = $title->create ();
		if (empty ( $data ['id'] )) {
			$title->add ( $data );
		} else {
			$title->save ( $data );
		}
		$this->redirect ( __URL__ . "/TitleSetting" );
	}
	
	
	function PriceView()
	{
		$id = $_GET ['id'];
		
		$price = M ( "project_price" );
		
		$sql="SELECT 
			p.*,
			  u.`email`,
			  u.`phone`,
			  clientprov.`name` clientprovname,
			  clientcity.`name` clientcityname,
			  projectprov.`name` projectprovname,
			  projectcity.`name` projectcityname 
			FROM
			  project_price p 
			  INNER JOIN `user` u 
			    ON p.`undertaker` = u.`id` 
			  LEFT JOIN `area` clientprov 
			    ON p.`clientprovince` = clientprov.`id` 
			  LEFT JOIN `area` clientcity 
			    ON p.`clientcity` = clientcity.`id` 
			  LEFT JOIN `area` projectprov 
			    ON p.`projectprovince` = projectprov.`id` 
			  LEFT JOIN `area` projectcity 
			    ON p.`projectcity` = projectcity.`id` WHERE p.id=$id";
		
		$price_detail = M ( 'project_price_detail' );
		
		$data = $price->query($sql);
		
		$this->assign ( "price", $data[0] );
		
		$detail = $price_detail->where ( 'price=' . $id )->select ();
		
		$this->assign ( "details", $detail );
		
		$this->display();
	}
}
?>