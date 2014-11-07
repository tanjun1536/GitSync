<?php
class PriceAction extends BaseAction {
	function PriceCustomerList() {
		import ( "ORG.Util.Page" );
		$date=$this->getParam('sdate');
		$state=$this->getParam('sstate');
		$sql="SELECT 
		  pc.*,
		  u.`name` uname 
		FROM
		  `price_query` pc 
		  INNER JOIN `user` u 
		    ON pc.`queryer` = u.`id` 
		 WHERE pc.CODE='$this->code' AND type='客戶詢價'";
		$where =$this->getWhere();
		if(!empty($date))
		{
			$sql.=" AND datediff('$date',querydate)=0 ";
		}
		if(!empty($state))
		{
			$sql.=" AND state ='$state' ";
		}
		$price=new Model();
		$list = $price->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $price->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'PriceCustomerList' );
	}
	function PriceCustomerAdd() {
		// 流水号
		$linecode = getPriceCustomerLineCode ();
		$this->assign ( 'linecode', $linecode );
		// 部门
		$departs = $this->getDeparts ();
		
		$this->display ( 'PriceCustomerAdd' );
	}
	function PriceCustomerSave() {
		$price = M ( 'price_query' );
		try {
			$price->startTrans ();
			$data = $price->create ();
			$id = $data ['id'];
			if (empty ( $id )) {
				$id = $price->add ( $data );
				$this->addDetail ( $id, false,'price_query_detail' );
			} else {
				$price->save ( $data );
				$this->addDetail ( $id, true,'price_query_detail' );
			}
			$price->commit ();
		} catch ( Exception $e ) {
			$price->rollback ();
		}
		$this->PriceCustomerList ();
	}
	function addDetail($id, $isUpdate,$model) {
		//
		$price_detail = M ( $model );
		if ($isUpdate)
			$price_detail->where ( 'price =' . $id )->delete ();
		$details = $_POST ['detail'];
		if (! empty ( $details )) {
			foreach ( $details as $key => $value ) {
				$datas = explode ( ",", $value );
				$data ['cp'] = $datas ['0'];
				$data ['spmc'] = $datas ['1'];
				$data ['ggcc'] = $datas ['2'];
				$data ['cpxh'] = $datas ['3'];
				$data ['sl'] = $datas ['4'];
				$data ['dw'] = $datas ['5'];
				$data ['dj'] = $datas ['6'];
				$data ['fj'] = $datas ['7'];
				$data ['bz'] = $datas ['8'];
				$data ['price'] = $id;
				$price_detail->add ( $data );
			}
		}
	}
	function PriceCustomerEdit() {
		$this->getDeparts();
		$id=$_GET['id'];
		//查詢主表
		$price=$price = M ( 'price_query' );
		$data=$price->find($id);
		$this->assign('price',$data);
		//查詢子表
		$price_detail = M ( 'price_query_detail' );
		$datas=$price_detail->where("price=$id")->select();
		$this->assign('details',$datas);
		$this->display ( 'PriceCustomerEdit' );
	}
	function PriceCustomerDelete() {
		$id=$_GET['id'];
		$price=$price = M ( 'price_query' );
		$data=$price->delete($id);
		$this->PriceCustomerList ();
	}
	function PriceBusinessList() {
		import ( "ORG.Util.Page" );
		$date=$this->getParam('sdate');
		$state=$this->getParam('sstate');
		$sql="SELECT
		pc.*,
		u.`name` uname
		FROM
		`price_query` pc
		INNER JOIN `user` u
		ON pc.`queryer` = u.`id`
		WHERE pc.CODE='$this->code'";
		$where =$this->getWhere();
		if(!empty($date))
		{
		$sql.=" AND datediff('$date',querydate)=0 ";
		}
		if(!empty($state))
		{
		$sql.=" AND state ='$state' ";
		}
		$price=new Model();
		$list = $price->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
		$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $price->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'PriceBusinessList' );
	}
	function PriceBusinessAdd() {
		// 流水号
		$linecode = getPriceBusinessLineCode();
		$this->assign ( 'linecode', $linecode );
		// 部门
		$departs = $this->getDeparts ();
		
		$this->display ( 'PriceBusinessAdd' );
	}
	function PriceBusinessSave() {
		$price = M ( 'price_query' );
		try {
			$price->startTrans ();
			$data = $price->create ();
			$id = $data ['id'];
			if (empty ( $id )) {
				$id = $price->add ( $data );
				$this->addDetail ( $id, false ,'price_query_detail');
			} else {
				$price->save ( $data );
				$this->addDetail ( $id, true ,'price_query_detail');
			}
			$price->commit ();
		} catch ( Exception $e ) {
			$price->rollback ();
		}
		$this->PriceBusinessList ();
	}
	function PriceBusinessEdit() {
		$this->getDeparts();
		$id=$_GET['id'];
		//查詢主表
		$price=$price = M ( 'price_query' );
		$data=$price->find($id);
		$this->assign('price',$data);
		//查詢子表
		$price_detail = M ( 'price_query_detail' );
		$datas=$price_detail->where("price=$id")->select();
		$this->assign('details',$datas);
		$this->display ( 'PriceBusinessEdit' );
	}
	function PriceBusinessDelete() {
		$id=$_GET['id'];
		$price=$price = M ( 'price_query' );
		$data=$price->delete($id);
		$this->PriceBusinessList ();
	}
}
?>