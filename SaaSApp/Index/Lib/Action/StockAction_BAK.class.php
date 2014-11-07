<?php
class StockAction extends BaseAction {
	// ---------产品大类别----------------------------------------------
	function productBigType() {
		$sql = " SELECT * FROM product_category ";
		$this->shop_page($sql);
		$this->display ( 'productBigType' );
	}
	function addProductBigType() {
		$mt = M ( 'stock_product_big_type' );
		$data = $mt->create ();
		if (empty ( $data ['id'] )) {
			$mt->add ( $data );
		} else {
			$mt->save ( $data );
		}
		$this->productBigType ();
	}
	function updateProductBigType() {
		$mt = M ( 'stock_product_big_type' );
		$data = $mt->find ( $_GET ['id'] );
		$this->assign ( 'mt', $data );
		$this->productBigType ();
	}
	function deleteProductBigType() {
		$mt = M ( 'stock_product_big_type' );
		$mt->delete ( $_GET ['id'] );
		$this->productBigType ();
	}
	// ---------产品主类别----------------------------------------------
	function productMainType() {
// 		import ( "ORG.Util.Page" );
// 		$bt = M ( 'stock_product_big_type' );
// 		$btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
// 		$this->assign ( 'btypes', $btypes );
		// 查询子类别
		$sql = "SELECT 
			  mt.*,
			  bt.`name` AS bname,
			  bt.`id` as bid
			FROM
			  `stock_product_main_type` mt 
			  INNER JOIN `stock_product_big_type` bt 
			    ON bt.`id` = mt.`btype` ";
		if (! empty ( $_GET ['big'] )) {
			$where .= " WHERE  bt.`id` =  " . $_GET ['big'];
			$sql .= $where;
		}
		$this->shop_page($sql);
		$this->display ( 'productMainType' );
	}
	function addProductMainType() {
		$mt = M ( 'stock_product_main_type' );
		$data = $mt->create ();
		if (empty ( $data ['id'] )) {
			$mt->add ( $data );
		} else {
			$mt->save ( $data );
		}
		$this->productMainType ();
	}
	function updateProductMainType() {
		$mt = M ( 'stock_product_main_type' );
		$data = $mt->find ( $_GET ['id'] );
		$this->assign ( 'mt', $data );
		$this->productMainType ();
	}
	function deleteProductMainType() {
		$mt = M ( 'stock_product_main_type' );
		$mt->delete ( $_GET ['id'] );
		$this->productMainType ();
	}
	// ---------产品子类别----------------------------------------------
	function productChildType() {
		import ( "ORG.Util.Page" );
		$bt = M ( 'stock_product_big_type' );
		$btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'btypes', $btypes );
		$mt = M ( 'stock_product_main_type' );
		$mtypes = $mt->where ( "`code`='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'mtypes', $mtypes );
		$model = M ( 'stock_product_child_type' );
		// 查询子类别
		$sql = "SELECT 
			  ct.*,
			  mt.`name` AS mname,
			  mt.`id` as mid,
			  bt.`name` AS bname,
			 bt.`id` as bid
			FROM
			  `stock_product_child_type` ct 
			  INNER JOIN `stock_product_main_type` mt 
			    ON mt.`id` = ct.`mtype` 
			   INNER JOIN `stock_product_big_type` bt 
			    ON bt.`id` = ct.`btype` ";
		$where = "WHERE " . $this->getWhere ();
		if (! empty ( $_GET ['bt'] ))
			$where .= " AND  bt.`id` =  " . $_GET ['bt'];
		if (! empty ( $_GET ['mt'] ))
			$where .= " AND  mt.`id` =  " . $_GET ['mt'];
		$sql .= $where;
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'productChildType' );
	}
	function addProductChildType() {
		$mt = M ( 'stock_product_child_type' );
		$data = $mt->create ();
		if (empty ( $data ['id'] )) {
			$mt->add ( $data );
		} else {
			$mt->save ( $data );
		}
		$this->productChildType ();
	}
	function updateProductChildType() {
		$mt = M ( 'stock_product_child_type' );
		$data = $mt->find ( $_GET ['id'] );
		$this->assign ( 'ct', $data );
		$this->productChildType ();
	}
	function deleteProductChildType() {
		$mt = M ( 'stock_product_child_type' );
		$mt->delete ( $_GET ['id'] );
		$this->productChildType ();
	}
	// ---------产品子类别----------------------------------------------
	function productCChildType() {
		import ( "ORG.Util.Page" );
		$bt = M ( 'stock_product_big_type' );
		$btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'btypes', $btypes );
		$mt = M ( 'stock_product_main_type' );
		$mtypes = $mt->where ( "`code`='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'mtypes', $mtypes );
		$model = M ( 'stock_product_cchild_type' );
		// 查询子类别
		$sql = "SELECT 
			  cct.* ,
			  ct.`name` AS cname,
			  mt.`name` AS mname,
			  bt.`name` AS bname
			FROM
			  `stock_product_cchild_type` cct 
			  INNER JOIN `stock_product_child_type` ct 
			    ON ct.`id` = cct.`ctype` 
			  INNER JOIN `stock_product_main_type` mt 
			    ON mt.`id` = ct.`mtype` 
			  INNER JOIN `stock_product_big_type` bt 
			    ON bt.`id` = cct.`btype`";
		$where = "WHERE " . $this->getWhere ();
		if (! empty ( $_GET ['bt'] ))
			$where .= " AND  bt.`id` =  " . $_GET ['bt'];
		if (! empty ( $_GET ['mt'] ))
			$where .= " AND  mt.`id` =  " . $_GET ['mt'];
		if (! empty ( $_GET ['ct'] ))
			$where .= " AND  ct.`id` =  " . $_GET ['ct'];
		$sql .= $where;
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'productCChildType' );
	}
	function addProductCChildType() {
		$mt = M ( 'stock_product_cchild_type' );
		$data = $mt->create ();
		if (empty ( $data ['id'] )) {
			$mt->add ( $data );
		} else {
			$mt->save ( $data );
		}
		$this->productCChildType ();
	}
	function updateProductCChildType() {
		$mt = M ( 'stock_product_cchild_type' );
		$data = $mt->find ( $_GET ['id'] );
		$this->assign ( 'cct', $data );
		$this->productCChildType ();
	}
	function deleteProductCChildType() {
		$mt = M ( 'stock_product_cchild_type' );
		$mt->delete ( $_GET ['id'] );
		$this->productCChildType ();
	}
	function getMainType() {
		$type = $_POST ['type'];
		if (! empty ( $type ))
			$where .= " btype= " . $type;
		$ct = M ( 'stock_product_main_type' );
		$datas = $ct->where ( $where )->select ();
		echo json_encode ( $datas );
	}
	function getChildType() {
		$type = $_POST ['type'];
		if (! empty ( $type ))
			$where .= " mtype= " . $type;
		$ct = M ( 'stock_product_child_type' );
		$datas = $ct->where ( $where )->select ();
		echo json_encode ( $datas );
	}
	function getCChildType() {
		$mt = $_POST ['mt'];
		if (! empty ( $mt ))
			$where .= " mtype= " . $mt;
		$ct = $_POST ['ct'];
		if (! empty ( $ct ))
			$where .= " and ctype= " . $ct;
		$ct = M ( 'stock_product_cchild_type' );
		$datas = $ct->where ( $where )->select ();
		echo json_encode ( $datas );
	}
	// ---------产品----------------------------------------------
	public function product() {
		$bt = M ( 'stock_product_big_type' );
		$btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'btypes', $btypes );
		
		$mt = $this->getParam ( 'maintype' );
		$ct = $this->getParam ( 'childtype' );
		$cct = $this->getParam ( 'cchildtype' );
		$name = $this->getParam ( 'pname' );
		$code = $this->getParam ( 'pcode' );
		$model = M ( 'stock_product' );
		import ( "ORG.Util.Page" );
		$sql = "SELECT p.*,
		mt.`name` AS mname ,
		ct.`name` AS cname,
		cct.`name` AS ccname
		 FROM `stock_product` p 
		INNER JOIN `stock_product_main_type` mt ON p.`mt`=mt.`id`
		INNER JOIN `stock_product_child_type` ct ON p.`ct`=ct.`id` 
		INNER JOIN  `stock_product_cchild_type` cct ON p.`cct` =cct.`id`
		WHERE p.`code`='" . $this->getCode () . "'
		";
		if (! empty ( $mt ))
			$where .= " AND mt=" . $mt;
		if (! empty ( $ct ))
			$where .= " AND ct=" . $$ct;
		if (! empty ( $cct ))
			$where .= " AND cct=" . $cct;
		if (! empty ( $name ))
			$where .= " AND productname like '%$name%'";
		if (! empty ( $code ))
			$where .= " AND productcode='$code'";
		
		$sql .= $where;
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'product' );
	}
	function addProductPage() {
		$bt = M ( 'stock_product_big_type' );
		$btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'btypes', $btypes );
		$this->display ( 'addProduct' );
	}
	function addProduct() {
		$product = M ( 'stock_product' );
		$data = $product->create ();
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_PRODUCT;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		if ($up->upload ()) {
			$paths = "";
			$files = $up->getUploadFileInfo ();
			$paths = $paths . $files [0] ["savename"];
			$data ['productimage'] = $paths;
		} else {
			// echo $up->getErrorMsg ();
		}
		if (empty ( $data ['id'] )) {
			$product->add ( $data );
		} else {
			$product->save ( $data );
		}
		$this->product ();
	}
	function updateProduct() {
		$product = M ( 'stock_product' );
		$data = $product->find ( $_GET ['id'] );
		$this->assign ( 'p', $data );
		$this->addProductPage ();
	}
	function deleteProduct() {
		$product = M ( 'stock_product' );
		$product->delete ( $_GET ['id'] );
		$this->product ();
	}
	// ---------厂商类别----------------------------------------------
	public function manufacturersType() {
		$smt = M ( 'stock_manufacturers_type' );
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$count = $smt->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $smt->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'manufacturersType' );
	}
	function addManufacturersType() {
		$smt = M ( 'stock_manufacturers_type' );
		$data = $smt->create ();
		if (empty ( $data ['id'] )) {
			$smt->add ( $data );
		} else {
			$smt->save ( $data );
		}
		$this->manufacturersType ();
	}
	function updateManufacturersType() {
		$smt = M ( 'stock_manufacturers_type' );
		$data = $smt->find ( $_GET ['id'] );
		$this->assign ( 'smt', $data );
		$this->manufacturersType ();
	}
	function deleteManufacturersType() {
		$smt = M ( 'stock_manufacturers_type' );
		$smt->delete ( $_GET ['id'] );
		$this->manufacturersType ();
	}
	// ---------廠商----------------------------------------------
	public function manufacturers() {
		$smt = M ( 'stock_manufacturers_type' );
		$list = $smt->where ( $this->getWhere () )->select ();
		$this->assign ( "types", $list );
		
		$model = M ( 'stock_manufacturers' );
		import ( "ORG.Util.Page" );
		$type = $this->getParam ( 'qtype' );
		$name = $this->getParam ( 'qname' );
		$sql = "SELECT 
			  m.*,
			  t.`name` AS tname 
			FROM
			  `stock_manufacturers` m 
			  INNER JOIN `stock_manufacturers_type` t 
			    ON m.`type` = t.`id` 
		WHERE m.`code`='" . $this->getCode () . "'
		";
		if (! empty ( $type ))
			$where .= " AND type=" . $type;
		if (! empty ( $name ))
			$where .= " AND productname like '%$name%'";
		
		$sql .= $where;
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'manufacturers' );
	}
	function addManufacturersPage() {
		// 類別
		$smt = M ( 'stock_manufacturers_type' );
		$where = $this->getWhere ();
		$list = $smt->where ( $where )->select ();
		$this->assign ( "types", $list );
		// 城市下來列表
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
		
		$this->display ( 'addManufacturers' );
	}
	function addManufacturers() {
		$stock = M ( 'stock_manufacturers' );
		$data = $stock->create ();
		if (empty ( $data ['id'] )) {
			$stock->add ( $data );
		} else {
			$stock->save ( $data );
		}
		$this->manufacturers ();
	}
	function updateManufacturers() {
		$stock = M ( 'stock_manufacturers' );
		$data = $stock->find ( $_GET ['id'] );
		$this->assign ( 'm', $data );
		$this->addManufacturersPage ();
	}
	function deleteManufacturers() {
		$stock = M ( 'stock_manufacturers' );
		$stock->delete ( $_GET ['id'] );
		$this->manufacturers ();
	}
	// ---------仓库----------------------------------------------
	public function stock() {
		$model = M ( 'stock_warehouse' );
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'stock' );
	}
	function addStock() {
		$stock = M ( 'stock_warehouse' );
		$data = $stock->create ();
		if (empty ( $data ['id'] )) {
			$stock->add ( $data );
		} else {
			$stock->save ( $data );
		}
		$this->stock ();
	}
	function updateStock() {
		$stock = M ( 'stock_warehouse' );
		$data = $stock->find ( $_GET ['id'] );
		$this->assign ( 'stock', $data );
		$this->stock ();
	}
	function deleteStock() {
		$stock = M ( 'stock_warehouse' );
		$stock->delete ( $_GET ['id'] );
		$this->stock ();
	}
	function stockView() {
		import ( "ORG.Util.Page" );
		$code = $this->getParam ( 'scode' );
		$name = $this->getParam ( 'sname' );
		if (! empty ( $code ))
			$where = "sp.productcode='$code'";
		if (! empty ( $name )) {
			if (! empty ( $where ))
				$where .= " AND";
			$where = $where . " sp.productname like '%$name%'";
		}
		if (! empty ( $where ))
			$where = "WHERE " . $where;
		$id = $_GET ['id'];
		$sql = "SELECT 
				  sp.`productname`,
				  sp.`productprice`,
				  p.* 
				FROM
				  (SELECT 
				    sps.`productcode`,
				    sps.`storage`,
				    sps.`stockcode` 
				  FROM
				    stock_product_storage sps 
				    INNER JOIN stock_warehouse sw 
				      ON sw.`stockcode` = sps.`stockcode` 
				  WHERE sw.`id` = $id
				    AND sps.id = 
				    (SELECT 
				      MAX(id) 
				    FROM
				      stock_product_storage  
				    WHERE `productcode` = sps.`productcode` AND stockcode=sw.`stockcode`)) p 
				  INNER JOIN stock_product sp 
				    ON p.productcode = sp.`productcode`  $where ";
		$model = new Model ();
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->assign ( 'id', $id );
		$this->display ( 'stockView' );
	}
	function stockChangeRecord() {
		import ( "ORG.Util.Page" );
		$id = $_GET ['id'];
		$this->assign ( 'id', $id );
		$sw = M ( 'stock_warehouse' );
		$data = $sw->find ( $id );
		$this->assign ( 'name', $data ['stockname'] );
		$sql = "SELECT 
		  IFNULL(sc.indate, sc.outdate) dodate,
		  scd.`productname`,
		  sc.`type`,
		  scd.`quantity`,
		  sps.`storage`,
		  scd.`remark`,
		  IFNULL(sc.inuser, sc.outuser) douser 
		FROM
		  `stock_product_storage` sps 
		  INNER JOIN `stock_change_detail` scd 
		    ON sps.`detailid` = scd.`id` 
		  INNER JOIN `stock_change` sc 
		    ON sc.`id` = scd.`changeid` 
		  INNER JOIN `stock_warehouse` sw 
		    ON sw.`stockcode` = sps.`stockcode` 
		WHERE sw.`id` =$id";
		$model = new Model ();
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'stockChangeRecord' );
	}
	// ----------采购------------------------------------------
	function purchase() {
		$state = $this->getParam ( 'state' );
		$mname = $this->getParam ( 'mname' );
		$model = new Model ();
		$sql = "SELECT 
  sp.*,
  sm.`mname` 
FROM
  `stock_purchase` sp 
  INNER JOIN `stock_manufacturers` sm 
    ON sp.`manufacturer` = sm.`id` 
   WHERE  sp.code ='" . $this->getCode () . "'";
		if (! empty ( $state ))
			$sql .= "purchasestate='$state'";
		if (! empty ( $mname ))
			$sql .= "AND sm.`mname` LIKE '%$mname%'";
		$smt = M ( 'stock_manufacturers_type' );
		$list = $smt->where ( $this->getWhere () )->select ();
		$this->assign ( "types", $list );
		
		import ( "ORG.Util.Page" );
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'purchase' );
	}
	function getManufacturers() {
		$type = $_POST ['type'];
		$manufacturer = M ( 'stock_manufacturers' );
		$data = $manufacturer->where ( "type='$type' " )->select ();
		echo json_encode ( $data );
	}
	function getProduct() {
		$code = $_POST ['code'];
		$p = M ( 'stock_product' );
		$where = $this->getWhere () . " AND productcode ='$code' ";
		$data = $p->where ( $where )->find ();
		echo json_encode ( $data );
	}
	function addPurchasePage() {
		// 查询供应商类别
		$smt = M ( 'stock_manufacturers_type' );
		$list = $smt->where ( $this->getWhere () )->select ();
		$this->assign ( "types", $list );
		// 设置流水号
		$linecode = getStockPurchaseCode ();
		$this->assign ( 'linecode', $linecode );
		$this->display ( 'addPurchase' );
	}
	function addPurchase() {
		$sp = M ( 'stock_purchase' );
		$spd = M ( 'stock_purchase_detail' );
		try {
			$sp->startTrans ();
			$spdata = $sp->create ();
			$purchase = $spdata ['id'];
			if (empty ( $purchase ))
				$purchase = $sp->add ( $spdata );
			else {
				$sp->save ( $spdata );
				// 刪除原來的明細
				$spd->execute ( "DELETE FROM stock_purchase_detail WHERE purchase=$purchase" );
			}
			
			// 添加採購明細
			$details = $_POST ['detail'];
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$datas = explode ( ",", $value );
					$data ['productcode'] = $datas [0];
					$data ['productname'] = $datas [1];
					$data ['price'] = $datas [2];
					$data ['quantity'] = $datas [3];
					$data ['subtotal'] = $datas [4];
					$data ['purchase'] = $purchase;
					$spd->add ( $data );
				}
			}
			$sp->commit ();
		} catch ( Exception $e ) {
			$sp->rollback ();
		}
		$this->purchase ();
	}
	function deletePurchase() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = M ( 'stock_purchase' );
		$model->delete ( $where );
		$model = M ( 'stock_purchase_detail' );
		$model->execute ( "DELETE FROM stock_purchase_detail WHERE purchase IN ($where) " );
		$this->purchase ();
	}
	function purchaseCheckPage() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_purchase' );
		$sql = "SELECT
		sp.*,
		sm.`mname`
		FROM
		`stock_purchase` sp
		INNER JOIN `stock_manufacturers` sm
		ON sp.`manufacturer` = sm.`id` WHERE sp.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sp', $data [0] );
		$spd = M ( 'stock_purchase_detail' );
		$datas = $spd->where ( 'purchase= ' . $id )->select ();
		$this->assign ( 'spd', $datas );
		
		$this->display ( 'purchaseCheck' );
	}
	function purchaseCheck() {
		$sp = M ( 'stock_purchase' );
		$data = $sp->create ();
		$sp->save ( $data );
		$this->purchase ();
	}
	function purchaseView() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_purchase' );
		$sql = "SELECT
		sp.*,
		sm.`mname`
		FROM
		`stock_purchase` sp
		INNER JOIN `stock_manufacturers` sm
		ON sp.`manufacturer` = sm.`id` WHERE sp.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sp', $data [0] );
		$spd = M ( 'stock_purchase_detail' );
		$datas = $spd->where ( 'purchase= ' . $id )->select ();
		$this->assign ( 'spd', $datas );
		$this->display ( 'purchaseView' );
	}
	function purchaseEdit() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_purchase' );
		$sql = "SELECT
		sp.*,
		sm.`mname`
		FROM
		`stock_purchase` sp
		INNER JOIN `stock_manufacturers` sm
		ON sp.`manufacturer` = sm.`id` WHERE sp.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sp', $data [0] );
		$spd = M ( 'stock_purchase_detail' );
		$datas = $spd->where ( 'purchase= ' . $id )->select ();
		$this->assign ( 'spd', $datas );
		$this->display ( 'purchaseEdit' );
	}
	// ----------验货------------------------------------------
	function stockCheck() {
		$state = $this->getParam ( 'state' );
		$mname = $this->getParam ( 'mname' );
		$model = new Model ();
		$sql = "SELECT
		sc.*,
		sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer` = sm.`id`
		WHERE  sc.code ='" . $this->getCode () . "'";
		// if (! empty ( $state ))
		// $sql .= "purchasestate='$state'";
		if (! empty ( $mname ))
			$sql .= "AND sm.`mname` LIKE '%$mname%'";
		$smt = M ( 'stock_manufacturers_type' );
		$list = $smt->where ( $this->getWhere () )->select ();
		$this->assign ( "types", $list );
		
		import ( "ORG.Util.Page" );
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'stockCheck' );
	}
	function addStockCheckPage() {
		// 查询供应商类别
		$smt = M ( 'stock_manufacturers_type' );
		$list = $smt->where ( $this->getWhere () )->select ();
		$this->assign ( "types", $list );
		// 设置流水号
		$linecode = getStockCheckCode ();
		$this->assign ( 'linecode', $linecode );
		$this->display ( 'addStockCheck' );
	}
	function getPurchase() {
		$code = $this->getCode ();
		$manufacturer = $_POST ['manufacturer'];
		$sql = "SELECT 
		  sp.`purchasecode`,spd.* ,(quantity-IF(ISNULL(income),0,income)) unincome
		FROM
		  `stock_purchase` sp 
		  INNER JOIN `stock_purchase_detail` spd 
		    ON sp.`id` = spd.`purchase` 
		    
		  LEFT OUTER JOIN 
		  (SELECT 
		  sc.`code`,scd.`productcode`,SUM(scd.income) income
		FROM
		  `stock_check` sc 
		   INNER JOIN `stock_check_detail` scd 
		    ON sc.`id` = scd.`checkid`  GROUP BY sc.`code`,scd.`productcode`
		    ) ck ON ck.code =sp.`code` AND ck.productcode=spd.`productcode`
		    
		    WHERE (quantity-IF(ISNULL(income),0,income))>0 AND sp.`code`= '$code' AND sp.`manufacturer`=$manufacturer
		 ";
		
		$m = new Model ();
		$data = $m->query ( $sql );
		echo json_encode ( $data );
	}
	function addStockCheck() {
		$sc = M ( 'stock_check' );
		$scd = M ( 'stock_check_detail' );
		try {
			$sc->startTrans ();
			$scdata = $sc->create ();
			$scid = $scdata ['id'];
			if (empty ( $scid )) {
				$scid = $sc->add ( $scdata );
				$sci = M ( 'stock_check_in' );
				$scidata ['checkid'] = $scid;
				$scidata ['storagecode'] = getStockStorageCode ();
				$scidata ['code'] = $scdata ['code'];
				$sci->add ( $scidata );
			} else {
				$sc->save ( $scdata );
				// 刪除原來的明細
				$scd->execute ( "DELETE FROM stock_check_detail WHERE checkid=$scid" );
			}
			
			// 驗貨明細
			$checkdetails = $_POST ['checkdetail'];
			if (! empty ( $checkdetails )) {
				$details = explode ( ";", $checkdetails );
				if (! empty ( $details )) {
					foreach ( $details as $key => $value ) {
						$datas = explode ( ",", $value );
						$data ['purchasecode'] = $datas [0];
						$data ['productcode'] = $datas [1];
						$data ['productname'] = $datas [2];
						$data ['quantity'] = $datas [3];
						$data ['price'] = $datas [7];
						$data ['uncome'] = $datas [4];
						$data ['income'] = $datas [5];
						$data ['subtotal'] = $datas [6];
						$data ['checkid'] = $scid;
						$scd->add ( $data );
					}
				}
			}
			$sc->commit ();
		} catch ( Exception $e ) {
			$sc->rollback ();
		}
		
		$this->stockCheck ();
	}
	function stockCheckView() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_check' );
		$sql = "SELECT 
		  sc.*,
		  sm.`mname`
		FROM
		  `stock_check` sc 
		  INNER JOIN `stock_manufacturers` sm 
		    ON sc.`manufacturer` = sm.`id` 
		  WHERE sc.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sc', $data [0] );
		$scd = M ( 'stock_check_detail' );
		$datas = $scd->where ( 'checkid= ' . $id )->select ();
		$this->assign ( 'scd', $datas );
		$this->display ( 'stockCheckView' );
	}
	function updateStockCheck() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_check' );
		$sql = "SELECT
		sc.*,
		sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer` = sm.`id`
		WHERE sc.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sc', $data [0] );
		$scd = M ( 'stock_check_detail' );
		$datas = $scd->where ( 'checkid= ' . $id )->select ();
		$this->assign ( 'scd', $datas );
		$this->display ( 'stockCheckEdit' );
	}
	function deleteStockCheck() {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = M ( 'stock_check' );
		$model->delete ( $where );
		$model = M ( 'stock_check_detail' );
		$model->execute ( "DELETE FROM stock_check_detail WHERE checkid IN ($where) " );
		$this->stockCheck ();
	}
	// ----------进货---------------------------------------------
	function stockStorage() {
		$state = $this->getParam ( 'sstate' );
		$mname = $this->getParam ( 'mname' );
		$model = new Model ();
		$sql = "SELECT
			sc.*,sci.`storagecode`,sm.`mname`
			FROM
			`stock_check` sc
			INNER JOIN `stock_check_in` sci
			ON sc.`id` = sci.`checkid`
			INNER JOIN `stock_manufacturers` sm
			ON sc.`manufacturer`=sm.`id`
			WHERE  sc.code ='" . $this->getCode () . "'";
		if (! empty ( $state ))
			$sql .= " AND sc.state='$state'";
		if (! empty ( $mname ))
			$sql .= "AND sm.`mname` LIKE '%$mname%'";
		import ( "ORG.Util.Page" );
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'stockStorage' );
	}
	// 进货审核 其实是审核验货的内容
	function stockStorageCheckPage() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_check' );
		$sql = "SELECT
			sc.*,sci.`storagecode`,sm.`mname`
			FROM
			`stock_check` sc
			INNER JOIN `stock_check_in` sci
			ON sc.`id` = sci.`checkid`
			INNER JOIN `stock_manufacturers` sm
			ON sc.`manufacturer`=sm.`id`
		WHERE sc.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sc', $data [0] );
		$scd = M ( 'stock_check_detail' );
		$datas = $scd->where ( 'checkid= ' . $id )->select ();
		$this->assign ( 'scd', $datas );
		$this->display ( 'stockStorageCheck' );
	}
	function stockStorageCheck() {
		$sc = M ( 'stock_check' );
		$data = $sc->create ();
		$sc->save ( $data );
		$this->stockStorage ();
	}
	function stockStorageView() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_check' );
		$sql = "SELECT
		sc.*,sci.`storagecode`,sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_check_in` sci
		ON sc.`id` = sci.`checkid`
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer`=sm.`id`
		WHERE sc.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sc', $data [0] );
		$scd = M ( 'stock_check_detail' );
		$datas = $scd->where ( 'checkid= ' . $id )->select ();
		$this->assign ( 'scd', $datas );
		$this->display ( 'stockStorageView' );
	}
	function stockStorageBackPage() {
		$id = $_GET ['id'];
		$sp = M ( 'stock_check' );
		$sql = "SELECT
		sc.*,sci.`storagecode`,sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_check_in` sci
		ON sc.`id` = sci.`checkid`
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer`=sm.`id`
		WHERE sc.id=$id";
		$data = $sp->query ( $sql );
		$this->assign ( 'sc', $data [0] );
		$scd = M ( 'stock_check_detail' );
		$datas = $scd->where ( 'checkid= ' . $id )->select ();
		$this->assign ( 'scd', $datas );
		$this->display ( 'stockStorageBack' );
	}
	function stockStorageBack() {
		$sb = M ( 'stock_back' );
		$sbd = M ( 'stock_back_detail' );
		try {
			$sb->startTrans ();
			// 添加退貨主表
			$sbdata = $sb->create ();
			$sbid = $sb->add ( $sbdata );
			// 更新驗貨表狀態為退貨
			$sc = M ( 'stock_check' );
			$scdata ['id'] = $sbdata ['checkid'];
			$scdata ['state'] = '退貨';
			$sc->save ( $scdata );
			// 退貨明細
			$backdetails = $_POST ['backdetail'];
			if (! empty ( $backdetails )) {
				$details = explode ( ";", $backdetails );
				if (! empty ( $details )) {
					foreach ( $details as $key => $value ) {
						$datas = explode ( ",", $value );
						$data ['purchasecode'] = $datas [0];
						$data ['productcode'] = $datas [1];
						$data ['productname'] = $datas [2];
						$data ['inquantity'] = $datas [3];
						$data ['backquantity'] = $datas [4];
						$data ['price'] = $datas [5];
						$data ['subtotal'] = $datas [6];
						$data ['backid'] = $sbid;
						$sbd->add ( $data );
					}
				}
			}
			$sb->commit ();
		} catch ( Exception $e ) {
			$sb->rollback ();
		}
		
		$this->stockStorage ();
	}
	// ----------异动---------------------------------------------
	function stockChange() {
		import ( "ORG.Util.Page" );
		$model = new Model ();
		// 查询子类别
		$sql = "SELECT 
		  IF(
		    ISNULL(sc.inwarehousecode),
		    sc.outwarehousecode,
		    sc.inwarehousecode
		  ) warehousecode ,
		  IF(
		    ISNULL(sc.inwarehousename),
		    sc.outwarehousename,
		    sc.inwarehousename
		  ) warehousename,
		    IF(
		    ISNULL(sc.indate),
		    sc.outdate,
		    sc.indate
		  ) dodate,
		  sc.`type`,
		  sc.`state`,sc.id
		  
		FROM
		  `stock_change` sc  WHERE sc.`code`= '" . $this->getCode () . "'";
		$type = $this->getParam ( 'stocktype' );
		if (! empty ( $type ))
			$sql .= " AND  sc.`type` = '$type' ";
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'stockChange' );
	}
	function stockChangeView() {
		import ( "ORG.Util.Page" );
		$model = new Model ();
		// 查询子类别
		$sql = "";
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . parent::getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		$this->display ( 'stockChangeView' );
	}
	function stockIn() {
		$type = M ( 'stock_in_type' );
		$list = $type->where ( "code ='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'types', $list );
		$this->display ( 'stockIn' );
	}
	function addStockIn() {
		$sc = M ( 'stock_change' );
		$scd = M ( 'stock_change_detail' );
		
		$sc->startTrans ();
		// 主表
		$data = $sc->create ();
		$ret = $scid = $sc->add ( $data );
		// 明細
		$details = $_POST ['detail'];
		if (! empty ( $details )) {
			foreach ( $details as $key => $value ) {
				$datas = explode ( ",", $value );
				$data ['productcode'] = $datas [0];
				$data ['productname'] = $datas [1];
				$data ['price'] = $datas [2];
				$data ['quantity'] = $datas [3];
				$data ['subtotal'] = $datas [4];
				$data ['remark'] = $datas [5];
				$data ['changeid'] = $scid;
				$ret2 = $scd->add ( $data );
				// $ret3 = $scd->execute ( "UPDATE stock_product SET
				// productstock=productstock+$datas[3] WHERE
				// productcode='$datas[0]'" );
				$ret = $ret && $ret2;
			}
		}
		if ($ret) {
			$sc->commit ();
		} else {
			$sc->rollback ();
		}
		
		$this->stockChange ();
	}
	function stockOut() {
		$type = M ( 'stock_out_type' );
		$list = $type->where ( "code ='" . $this->getCode () . "'" )->select ();
		$this->assign ( 'types', $list );
		$this->display ( 'stockOut' );
	}
	function addStockOut() {
		$sc = M ( 'stock_change' );
		$ret = $scd = M ( 'stock_change_detail' );
		$sc->startTrans ();
		// 主表
		$data = $sc->create ();
		$scid = $sc->add ( $data );
		// 明細
		$details = $_POST ['detail'];
		if (! empty ( $details )) {
			foreach ( $details as $key => $value ) {
				$datas = explode ( ",", $value );
				$data ['productcode'] = $datas [0];
				$data ['productname'] = $datas [1];
				$data ['price'] = $datas [2];
				$data ['quantity'] = $datas [3];
				$data ['subtotal'] = $datas [4];
				$data ['remark'] = $datas [5];
				$data ['changeid'] = $scid;
				// $ret2 = $scd->execute ( "UPDATE stock_product SET
				// productstock=productstock-$datas[3] WHERE
				// productcode='$datas[0]'" );
				$ret2 = $scd->add ( $data );
				$ret = $ret && $ret2;
			}
		}
		if ($ret) {
			$sc->commit ();
		} else {
			$sc->rollback ();
		}
		$this->stockChange ();
	}
	function stockAllocate() {
		$this->display ( 'stockAllocate' );
	}
	function addStockAllocate() {
		$sc = M ( 'stock_change' );
		$scd = M ( 'stock_change_detail' );
		try {
			$sc->startTrans ();
			// 主表
			$data = $sc->create ();
			$scid = $sc->add ( $data );
			// 明細
			$details = $_POST ['detail'];
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$datas = explode ( ",", $value );
					$data ['productcode'] = $datas [0];
					$data ['productname'] = $datas [1];
					$data ['price'] = $datas [2];
					$data ['quantity'] = $datas [3];
					$data ['subtotal'] = $datas [4];
					$data ['remark'] = $datas [5];
					$data ['changeid'] = $scid;
					$scd->add ( $data );
				}
			}
			$sc->commit ();
		} catch ( Exception $e ) {
			$sc->rollback ();
		}
		$this->stockChange ();
	}
	function setData() {
		$id = $_GET ['id'];
		$sc = M ( 'stock_change' );
		// $sql = "SELECT * FROM stock_change id=$id";
		$data = $sc->find ( $id );
		$this->assign ( 'sc', $data );
		$spd = M ( 'stock_change_detail' );
		$datas = $spd->where ( 'changeid= ' . $id )->select ();
		$this->assign ( 'scd', $datas );
	}
	function stockInView() {
		$this->setData ();
		$this->display ();
	}
	function stockOutView() {
		$this->setData ();
		$this->display ();
	}
	function stockAllocateView() {
		$this->setData ();
		$this->display ();
	}
	function stockInCheckPage() {
		$this->setData ();
		$this->display ( 'stockInCheck' );
	}
	function stockOutCheckPage() {
		$this->setData ();
		$this->display ( 'stockOutCheck' );
	}
	function stockAllocateCheckPage() {
		$this->setData ();
		$this->display ( 'stockAllocateCheck' );
	}
	function stockChangeCheck() {
		$sc = M ( 'stock_change' );
		$sc->startTrans ();
		$data = $sc->create ();
		$ret = $sc->save ( $data );
		if ($data ['state'] == '核可') {
			$id = $data ['id'];
			$data = $sc->find ( $id );
			$scd = M ( 'stock_change_detail' );
			$datas = $scd->where ( 'changeid= ' . $id )->select ();
			$sps = M ( 'stock_product_storage' );
			$type = $data ['type'];
			// stock_product_storage 和stock_change_detail 关联起来
			if ($type == '入庫') {
				// 查询库存stock_product_storage
				foreach ( $datas as $k => $v ) {
					// 查询以前是否有异动信息 如果有库存就取上次的库存加或者减这次的变化量，如果没有库存就为这次的数量
					// 仓库编号
					$ccode = $data ['inwarehousecode'];
					// 产品编号
					$pcode = $v ['productcode'];
					// 公司编号
					$code = $this->code;
					$sql = "SELECT * FROM stock_product_storage WHERE stockcode='$ccode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
					$qData = $sc->query ( $sql );
					if (count ( $qData ) > 0) {
						$iData ['storage'] = $qData [0] ['storage'] + $v ['quantity'];
					} else {
						$iData ['storage'] = $v ['quantity'];
					}
					$iData ['stockcode'] = $data ['inwarehousecode'];
					$iData ['productcode'] = $v ['productcode'];
					$iData ['detailid'] = $v ['id'];
					$iData ['code'] = $code;
					$ret = $ret && $sps->add ( $iData );
					//
				}
			} else if ($type == '出庫') {
				// 查询库存stock_product_storage
				foreach ( $datas as $k => $v ) {
					// 查询以前是否有异动信息 如果有库存就取上次的库存加或者减这次的变化量，如果没有库存就为这次的数量
					// 仓库编号
					$ccode = $data ['outwarehousecode'];
					// 产品编号
					$pcode = $v ['productcode'];
					// 公司编号
					$code = $this->code;
					$sql = "SELECT * FROM stock_product_storage WHERE stockcode='$ccode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
					$qData = $sc->query ( $sql );
					if (count ( $qData ) > 0) {
						$iData ['storage'] = $qData [0] ['storage'] - $v ['quantity'];
					} else {
						$iData ['storage'] = 0 - $v ['quantity'];
					}
					$iData ['stockcode'] = $ccode;
					$iData ['productcode'] = $pcode;
					$iData ['detailid'] = $v ['id'];
					$iData ['code'] = $code;
					$ret = $ret && $sps->add ( $iData );
				}
			} else {
				// 查询库存stock_product_storage
				foreach ( $datas as $k => $v ) {
					// 查询以前是否有异动信息 如果有库存就取上次的库存加或者减这次的变化量，如果没有库存就为这次的数量
					// 调入仓库编号
					$icode = $data ['inwarehousecode'];
					// 调出仓库编号
					$ocode = $data ['outwarehousecode'];
					// 产品编号
					$pcode = $v ['productcode'];
					// 公司编号
					$code = $this->code;
					// 调入开始
					/**
					 * *************************
					 */
					$sql = "SELECT * FROM stock_product_storage WHERE stockcode='$icode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
					
					$qData = $sc->query ( $sql );
					if (count ( $qData ) > 0) {
						$iData ['storage'] = $qData [0] ['storage'] + $v ['quantity'];
					} else {
						$iData ['storage'] = $v ['quantity'];
					}
					$iData ['stockcode'] = $icode;
					$iData ['productcode'] = $pcode;
					$iData ['detailid'] = $v ['id'];
					$iData ['code'] = $code;
					$ret = $ret && $sps->add ( $iData );
					/**
					 * ***********************
					 */
					// 调出开始
					/**
					 * *************************
					 */
					$sql = "SELECT * FROM stock_product_storage WHERE stockcode='$ocode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
					
					$qData = $sc->query ( $sql );
					if (count ( $qData ) > 0) {
						$iData ['storage'] = $qData [0] ['storage'] - $v ['quantity'];
					} else {
						$iData ['storage'] = 0 - $v ['quantity'];
					}
					$iData ['stockcode'] = $ocode;
					$iData ['productcode'] = $pcode;
					$iData ['detailid'] = $v ['id'];
					$iData ['code'] = $code;
					$ret = $ret && $sps->add ( $iData );
				/**
				 * ***********************
				 */
				}
			}
		}
		if ($ret)
			$sc->commit ();
		else
			$sc->rollback ();
		
		$this->stockChange ();
	}
	function getStock() {
		$code = $_POST ['code'];
		$stock = M ( 'stock_warehouse' );
		$data = $stock->where ( "stockcode='$code'" )->find ();
		echo json_encode ( $data ['stockname'] );
	}
	function stockInType() {
		$model = M ( 'stock_in_type' );
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'stockInType' );
	}
	function addStockInType() {
		$type = M ( 'stock_in_type' );
		$data = $type->create ();
		if (empty ( $data ['id'] )) {
			$type->add ( $data );
		} else {
			$type->save ( $data );
		}
		$this->stockInType ();
	}
	function updateStockInType() {
		$type = M ( 'stock_in_type' );
		$data = $type->find ( $_GET ['id'] );
		$this->assign ( 'intype', $data );
		$this->stockInType ();
	}
	function deleteStockInType() {
		$stock = M ( 'stock_in_type' );
		$stock->delete ( $_GET ['id'] );
		$this->stockInType ();
	}
	function stockOutType() {
		$model = M ( 'stock_out_type' );
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'stockOutType' );
	}
	function addStockOutType() {
		$type = M ( 'stock_out_type' );
		$data = $type->create ();
		if (empty ( $data ['id'] )) {
			$type->add ( $data );
		} else {
			$type->save ( $data );
		}
		$this->stockOutType ();
	}
	function updateStockOutType() {
		$type = M ( 'stock_out_type' );
		$data = $type->find ( $_GET ['id'] );
		$this->assign ( 'outtype', $data );
		$this->stockOutType ();
	}
	function deleteStockOutType() {
		$stock = M ( 'stock_out_type' );
		$stock->delete ( $_GET ['id'] );
		$this->stockOutType ();
	}
	// 盘点
	function stockInventoryAdd() {
		$stock = M ( 'stock_warehouse' );
		$id = $_GET ['stockid'];
		$data = $stock->find ( $id );
		$this->assign ( 'stock', $data );
		
		$id = $_GET ['id'];
		$Inventory = M ( 'stock_inventory' );
		$inv = $Inventory->find ( $id );
		$this->assign ( 'inventory', $inv );
		$stockid = $_GET ['stockid'];
		$this->display ( 'stockInventoryAdd' );
		$this->display ( 'stockInventoryAdd' );
	}
	function stockInventoryList() {
		$stock = M ( 'stock_warehouse' );
		$id = $_GET ['id'];
		$data = $stock->find ( $id );
		$this->assign ( 'stock', $data );
		import ( "ORG.Util.Page" );
		$Inventory = M ( 'stock_inventory' );
		$where = 'stockid=' . $id;
		$count = $Inventory->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $Inventory->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ( 'stockInventoryList' );
	}
	function stockInventorySave() {
		$Inventory = M ( 'stock_inventory' );
		$Inventory->startTrans ();
		try {
			$data = $Inventory->create ();
			$ret = $Inventory->add ( $data );
			$this->checkExcept ( $ret );
			// 保存盘点主表
			
			// 修改仓库状态为关闭
			$stock = M ( 'stock_warehouse' );
			$stockData ['id'] = $_GET ['id'];
			$stockData ['stockstate'] = '關閉';
			$ret = $stock->save ( $stockData );
			$this->checkExcept ( $ret );
			
			$Inventory->commit ();
		} catch ( Exception $e ) {
			$Inventory->rollback ();
		}
		$this->stockInventoryList ();
	}
	function stockInventoryView() {
		$id = $_GET ['id'];
		$Inventory = M ( 'stock_inventory' );
		$inv = $Inventory->find ( $id );
		$this->assign ( 'inventory', $inv );
		$stockid = $_GET ['stockid'];
		
		$stock = M ( 'stock_warehouse' );
		$data = $stock->find ( $stockid );
		$this->assign ( 'stock', $data );
		
		$state = $this->getParam ( 'state' );
		$csql = "SELECT 
			  COUNT(*) 
			FROM
			  (SELECT 
			    sps.*,
			    IF(
			      ISNULL(inventory.productcode),
			      '未盤點',
			      '已盤點'
			    ) state 
			  FROM
			    (SELECT 
			      MAX(id) id,
			      productcode 
			    FROM
			      `stock_product_storage` 
			    WHERE stockcode = 
			      (SELECT 
			        stockcode 
			      FROM
			        stock_warehouse 
			      WHERE id = $stockid) 
			    GROUP BY productcode) store 
			    INNER JOIN `stock_product_storage` sps 
			      ON store.id = sps.`id` 
			    LEFT JOIN 
			      (SELECT 
			        id.productcode 
			      FROM
			        `stock_inventory` i 
			        INNER JOIN `stock_inventory_detail` id 
			          ON i.`id` = id.`inventoryid` 
			      WHERE i.id = $id) inventory 
			      ON store.productcode = inventory.productcode) z ";
		$dsql = "SELECT 
			  * 
			FROM
			  (SELECT 
			    sps.*,p.`productname`,p.`productprice`,
			    IF(
			      ISNULL(inventory.productcode),
			      '未盤點',
			      '已盤點'
			    ) state ,inventory.productfactquantity
			  FROM
			    (SELECT 
			      MAX(id) id,
			      productcode 
			    FROM
			      `stock_product_storage` 
			    WHERE stockcode = 
			      (SELECT 
			        stockcode 
			      FROM
			        stock_warehouse 
			      WHERE id = $stockid) 
			    GROUP BY productcode) store 
			    INNER JOIN `stock_product_storage` sps 
			      ON store.id = sps.`id` INNER JOIN `stock_product` p ON sps.`productcode`=p.`productcode`
			    LEFT JOIN 
			      (SELECT 
			        id.productcode ,id.productfactquantity
			      FROM
			        `stock_inventory` i 
			        INNER JOIN `stock_inventory_detail` id 
			          ON i.`id` = id.`inventoryid` 
			      WHERE i.id = $id) inventory 
			      ON store.productcode = inventory.productcode) z ";
		if (! empty ( $state )) {
			$csql .= " WHERE z.state='$state'";
			$dsql .= " WHERE z.state='$state'";
			$this->assign ( 'state', $state );
		}
		$this->page ( $csql, $dsql );
		$this->display ( 'stockInventoryView' );
	}
	function getProductStorage() {
		$code = $_POST ['code'];
		$stockcode = $_POST ['stockcode'];
		$sql = "SELECT 
			  p.*,
			  store.`storage` 
			FROM
			  `stock_product_storage` store 
			  INNER JOIN stock_product p 
			    ON store.`productcode` = p.`productcode` 
			WHERE store.`stockcode` ='$stockcode'
			  AND store.id = 
			  (SELECT 
			    MAX(id) 
			  FROM
			    `stock_product_storage` 
			  WHERE productcode = '$code' AND `stockcode` = '$stockcode' )";
		$data = $this->execObj ( $sql );
		echo json_encode ( $data [0] );
	}
	function stockInventoryDetailSave() {
		$inventoryid = $_GET ['id'];
		$stockid = $_GET ['stockid'];
		$continue = $_POST ['continue'];
		$detail = M ( 'stock_inventory_detail' );
		$detail->startTrans ();
		try {
			if ($continue == 0) {
				// 修改仓库状态为开启
				$stock = M ( 'stock_warehouse' );
				$stockData ['id'] = $stockid;
				$stockData ['stockstate'] = '開啟';
				$ret = $stock->save ( $stockData );
				$this->checkExcept ( $ret );
				// 结束盘点填入日期
				$inv = M ( 'stock_inventory' );
				$data = $inv->create ();
				$data ['id'] = $inventoryid;
				$data ['enddate'] = date ( 'Y/m/d' );
				$data ['stockopenhour'] = date ( 'h' );
				$data ['stockopenminute'] = date ( 'i' );
				$ret = $inv->save ( $data );
				$this->checkExcept ( $ret );
			}
			$details = $_POST ['detail'];
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$datas = explode ( ",", $value );
					$datadetail ['inventoryid'] = $inventoryid;
					$datadetail ['stockid'] = $stockid;
					$datadetail ['productcode'] = $datas [0];
					$datadetail ['productname'] = $datas [1];
					$datadetail ['productprice'] = $datas [2];
					$datadetail ['productstorage'] = $datas [3];
					$datadetail ['productfactquantity'] = $datas [4];
					$ret = $detail->add ( $datadetail );
					$this->checkExcept ( $ret );
				}
			}
			$detail->commit ();
		} catch ( Exception $e ) {
			$detail->rollback ();
		}
		
		$this->stockInventoryView ();
	}
}
?>