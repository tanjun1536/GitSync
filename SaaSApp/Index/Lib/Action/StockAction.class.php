<?php

class StockAction extends BaseAction
{
    // ---------产品大类别----------------------------------------------
    function productBigType()
    {
        $sql = " SELECT * FROM `tb_pro_sort` WHERE `s_id`='0'  ORDER BY  `s_order`";
        $this->shop_page($sql);
        $this->display('productBigType');
    }

    function addProductBigType()
    {
        $mt = M('stock_product_big_type');
        $data = $mt->create();
        if (empty($data['id'])) {
            $mt->add($data);
        } else {
            $mt->save($data);
        }
        $this->productBigType();
    }

    function updateProductBigType()
    {
        $mt = M('stock_product_big_type');
        $data = $mt->find($_GET['id']);
        $this->assign('mt', $data);
        $this->productBigType();
    }

    function deleteProductBigType()
    {
        $mt = M('stock_product_big_type');
        $mt->delete($_GET['id']);
        $this->productBigType();
    }
    // ---------产品主类别----------------------------------------------
    function productMainType()
    {
        // import ( "ORG.Util.Page" );
        // $bt = M ( 'stock_product_big_type' );
        // $btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
        // $this->assign ( 'btypes', $btypes );
        // 查询子类别
        $sql = "SELECT 
					  s.*,
					  b.s_name AS cname ,
					  b.id as bid
					FROM
					  `tb_pro_sort` s 
					  INNER JOIN `tb_pro_sort` b 
					    ON s.s_id = b.id 
					WHERE s.`s_id` >= '1' 
					  AND s.`s_mid` <= '1' ";
        
        if (! empty($_GET['bt'])) {
            $where .= " AND  b.`id` =  " . $_GET['bt'];
            $sql .= $where;
        }
        $sql .= " ORDER BY s.s_order ";
        $this->shop_page($sql);
        $this->display('productMainType');
    }

    function addProductMainType()
    {
        $mt = M('stock_product_main_type');
        $data = $mt->create();
        if (empty($data['id'])) {
            $mt->add($data);
        } else {
            $mt->save($data);
        }
        $this->productMainType();
    }

    function updateProductMainType()
    {
        $mt = M('stock_product_main_type');
        $data = $mt->find($_GET['id']);
        $this->assign('mt', $data);
        $this->productMainType();
    }

    function deleteProductMainType()
    {
        $mt = M('stock_product_main_type');
        $mt->delete($_GET['id']);
        $this->productMainType();
    }
    // ---------产品子类别----------------------------------------------
    function productChildType()
    {
        // import ( "ORG.Util.Page" );
        // $bt = M ( 'stock_product_big_type' );
        // $btypes = $bt->where ( "`code`='" . $this->getCode () . "'" )->select ();
        // $this->assign ( 'btypes', $btypes );
        // $mt = M ( 'stock_product_main_type' );
        // $mtypes = $mt->where ( "`code`='" . $this->getCode () . "'" )->select ();
        // $this->assign ( 'mtypes', $mtypes );
        // $model = M ( 'stock_product_child_type' );
        // 查询子类别
        $sql = "SELECT 
				  c2.*,
				  c2.`s_name` c2name,
				  c1.`s_name` c1name,
				  c.`s_name` cname 
				FROM
				  `tb_pro_sort` c2 
				  INNER JOIN `tb_pro_sort` c1 
				    ON c2.`s_mid` = c1.`id` 
				  INNER JOIN `tb_pro_sort` c 
				    ON c2.`s_id` = c.`id` 
				WHERE c2.`s_mid` >= '1' 
				  AND c2.`s_sid` <= '1'";
        $where = " ";
        if (! empty($_GET['bt']))
            $where .= " AND  c.`id` =  " . $_GET['bt'];
        if (! empty($_GET['mt']))
            $where .= " AND  c1.`id` =  " . $_GET['mt'];
        $sql .= $where . " ORDER BY c2.`s_order` ";
        $this->shop_page($sql);
        $this->display('productChildType');
    }

    function addProductChildType()
    {
        $mt = M('stock_product_child_type');
        $data = $mt->create();
        if (empty($data['id'])) {
            $mt->add($data);
        } else {
            $mt->save($data);
        }
        $this->productChildType();
    }

    function updateProductChildType()
    {
        $mt = M('stock_product_child_type');
        $data = $mt->find($_GET['id']);
        $this->assign('ct', $data);
        $this->productChildType();
    }

    function deleteProductChildType()
    {
        $mt = M('stock_product_child_type');
        $mt->delete($_GET['id']);
        $this->productChildType();
    }
    // ---------产品子类别----------------------------------------------
    function productCChildType()
    {
        import("ORG.Util.Page");
        $bt = M('stock_product_big_type');
        $btypes = $bt->where("`code`='" . $this->getCode() . "'")
            ->select();
        $this->assign('btypes', $btypes);
        $mt = M('stock_product_main_type');
        $mtypes = $mt->where("`code`='" . $this->getCode() . "'")
            ->select();
        $this->assign('mtypes', $mtypes);
        $model = M('stock_product_cchild_type');
        // 查询子类别
        $sql = " SELECT 
				  c4.*,
				  c4.`s_name` c4name,
				  c3.`s_name` c3name,
				  c2.`s_name` c2name,
				  c1.`s_name` c1name 
				FROM
				  `tb_pro_sort` c4 
				  INNER JOIN `tb_pro_sort` c3 
				    ON c4.`s_sid` = c3.`id` 
				  INNER JOIN `tb_pro_sort` c2 
				    ON c4.`s_mid` = c2.`id` 
				  INNER JOIN `tb_pro_sort` c1 
				    ON c4.`s_id` = c1.`id` 
				WHERE c4.`s_sid` >= '1' ";
        
        $where = " ";
        if (! empty($_GET['bt']))
            $where .= " AND  c1.`id` =  " . $_GET['bt'];
        if (! empty($_GET['mt']))
            $where .= " AND  c2.`id` =  " . $_GET['mt'];
        if (! empty($_GET['ct']))
            $where .= " AND  c3.`id` =  " . $_GET['ct'];
        $sql .= $where;
        $sql .= " ORDER BY c4.`s_order` ";
        $this->shop_page($sql);
        $this->display('productCChildType');
    }

    function addProductCChildType()
    {
        $mt = M('stock_product_cchild_type');
        $data = $mt->create();
        if (empty($data['id'])) {
            $mt->add($data);
        } else {
            $mt->save($data);
        }
        $this->productCChildType();
    }

    function updateProductCChildType()
    {
        $mt = M('stock_product_cchild_type');
        $data = $mt->find($_GET['id']);
        $this->assign('cct', $data);
        $this->productCChildType();
    }

    function deleteProductCChildType()
    {
        $mt = M('stock_product_cchild_type');
        $mt->delete($_GET['id']);
        $this->productCChildType();
    }

    function getMainType()
    {
        $type = $_POST['type'];
        $dao = new Model();
        $datas = $dao->db(1, C('shop_db'))->query("SELECT * FROM `tb_pro_sort` WHERE `s_id` >= '1' 
					  AND `s_mid` <= '1' AND `s_id`=$type");
        echo json_encode($datas);
    }

    function getChildType()
    {
        $type = $_POST['type'];
        $dao = new Model();
        $datas = $dao->db(1, C('shop_db'))->query("SELECT * FROM `tb_pro_sort` WHERE  `s_mid` >= '1' 
				  AND `s_sid` <= '1' AND `s_mid`=$type");
        echo json_encode($datas);
    }

    function getCChildType()
    {
        $mt = $_POST['mt'];
        $ct = $_POST['ct'];
        $dao = new Model();
        $datas = $dao->db(1, C('shop_db'))->query("SELECT * FROM `tb_pro_sort` WHERE  `s_sid` >= '1' AND `s_mid` = $mt and `s_sid`=$ct");
        echo json_encode($datas);
    }
    // ---------产品----------------------------------------------
    public function product()
    {
        $dao = new Model();
        $btypes = $dao->db(1, C('shop_db'))->query("SELECT * FROM `tb_pro_sort` WHERE `s_id`='0'  ORDER BY  `s_order`");
        $this->assign('btypes', $btypes);
        
        $bt = $this->getParam('bigtype');
        $mt = $this->getParam('maintype');
        $ct = $this->getParam('childtype');
        $cct = $this->getParam('cchildtype');
        $name = $this->getParam('pname');
        $code = $this->getParam('pcode');
        $sql = "SELECT p.*,
			c1.`s_name` c1name,
			c2.`s_name` c2name,
			c3.`s_name` c3name,
			c4.`s_name` c4name,b.`b_name`
			 FROM tb_pro  p
			LEFT JOIN `tb_pro_sort` c1
			ON p.`p_mid`=c1.`id`
			LEFT JOIN `tb_pro_sort` c2
			ON p.`p_sid`=c2.`id`
			LEFT JOIN `tb_pro_sort` c3
			ON p.`p_tid`=c3.`id`
			LEFT JOIN `tb_pro_sort` c4
			ON p.`p_fid`=c4.`id` 
			LEFT JOIN `tb_pro_brand` b ON p.`p_brand`=b.`id`
			 WHERE 1=1  ";
        if (! empty($bt)) {
            $where .= " AND c1.id=" . $bt;
            $this->assign("bt", $bt);
        }
        if (! empty($mt)) {
            $where .= " AND c2.id=" . $mt;
            $this->assign("mt", $mt);
        }
        if (! empty($ct)) {
            $where .= " AND c3.id=" . $ct;
            $this->assign("ct", $ct);
        }
        if (! empty($cct)) {
            $where .= " AND c4.id=" . $cct;
            $this->assign("cct", $cct);
        }
        if (! empty($name)) {
            $where .= " AND p_name like '%$name%'";
            $this->assign("name", $name);
        }
        
        if (! empty($code)) {
            $where .= " AND p_id='$code'";
            $this->assign("code", $code);
        }
        $sql .= $where;
        $sql .= " order by p.`p_fid` asc ,id desc";
        $this->shop_page($sql);
        $this->display('product');
    }

    function addProductPage()
    {
        $bt = M('stock_product_big_type');
        $btypes = $bt->where("`code`='" . $this->getCode() . "'")
            ->select();
        $this->assign('btypes', $btypes);
        $this->display('addProduct');
    }

    function addProduct()
    {
        $product = M('stock_product');
        $data = $product->create();
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_PRODUCT;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            $paths = "";
            $files = $up->getUploadFileInfo();
            $paths = $paths . $files[0]["savename"];
            $data['productimage'] = $paths;
        } else {
            // echo $up->getErrorMsg ();
        }
        if (empty($data['id'])) {
            $product->add($data);
        } else {
            $product->save($data);
        }
        $this->product();
    }

    function updateProduct()
    {
        $product = M('stock_product');
        $data = $product->find($_GET['id']);
        $this->assign('p', $data);
        $this->addProductPage();
    }

    function deleteProduct()
    {
        $product = M('stock_product');
        $product->delete($_GET['id']);
        $this->product();
    }
    // ---------厂商类别----------------------------------------------
    public function manufacturersType()
    {
        $smt = M('stock_manufacturers_type');
        import("ORG.Util.Page");
        $where = $this->getWhere();
        $count = $smt->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $smt->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('manufacturersType');
    }

    function addManufacturersType()
    {
        $smt = M('stock_manufacturers_type');
        $data = $smt->create();
        if (empty($data['id'])) {
            $smt->add($data);
        } else {
            $smt->save($data);
        }
        $this->manufacturersType();
    }

    function updateManufacturersType()
    {
        $smt = M('stock_manufacturers_type');
        $data = $smt->find($_GET['id']);
        $this->assign('smt', $data);
        $this->manufacturersType();
    }

    function deleteManufacturersType()
    {
        $smt = M('stock_manufacturers_type');
        $smt->delete($_GET['id']);
        $this->manufacturersType();
    }
    // 厂商分类
    public function manufacturersCategory()
    {
        $smt = M('stock_manufacturers_category');
        import("ORG.Util.Page");
        $where = $this->getWhere();
        $count = $smt->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $smt->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('manufacturersCategory');
    }

    function addManufacturersCategory()
    {
        $smt = M('stock_manufacturers_category');
        $data = $smt->create();
        if (empty($data['id'])) {
            $smt->add($data);
        } else {
            $smt->save($data);
        }
        $this->manufacturersCategory();
    }

    function updateManufacturersCategory()
    {
        $smt = M('stock_manufacturers_category');
        $data = $smt->find($_GET['id']);
        $this->assign('smt', $data);
        $this->manufacturersCategory();
    }

    function deleteManufacturersCategory()
    {
        $smt = M('stock_manufacturers_category');
        $smt->delete($_GET['id']);
        $this->manufacturersCategory();
    }
    // ---------廠商----------------------------------------------
    public function manufacturers()
    {
        $smt = M('stock_manufacturers_type');
        $list = $smt->where($this->getWhere())
            ->select();
        $this->assign("types", $list);
        
        $model = M('stock_manufacturers');
        import("ORG.Util.Page");
        $type = $this->getParam('qtype');
        $name = $this->getParam('qname');
        $sql = "SELECT 
			  m.*,
			  t.`name` AS tname 
			FROM
			  `stock_manufacturers` m 
			  INNER JOIN `stock_manufacturers_type` t 
			    ON m.`type` = t.`id` 
		WHERE m.`code`='" . $this->getCode() . "'
		";
        if (! empty($type)) {
            $where .= " AND type=" . $type;
            $this->assign("type", $type);
        }
        if (! empty($name)) {
            $where .= " AND mname like '%$name%'";
            $this->assign("mname", $name);
        }
        
        $sql .= $where;
        $sql .= " ORDER BY mcode";
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('manufacturers');
    }

    function addManufacturersPage()
    {
        // 類別
        $smt = M('stock_manufacturers_type');
        $where = $this->getWhere();
        $list = $smt->where($where)->select();
        $this->assign("types", $list);
        $cat = M('stock_manufacturers_category');
        $categories = $cat->where($where)->select();
        $this->assign("categories", $categories);
        // 城市下來列表
        $province = new Model('area');
        $provinces = $province->where("pid=0")->select();
        $this->assign("provinces", $provinces);
        
        $this->display('addManufacturers');
    }

    function addManufacturers()
    {
        $stock = M('stock_manufacturers');
        $data = $stock->create();
        if (empty($data['id'])) {
            $stock->add($data);
        } else {
            $stock->save($data);
        }
        $this->redirect("manufacturers");
    }

    function updateManufacturers()
    {
        $stock = M('stock_manufacturers');
        $data = $stock->find($_GET['id']);
        $this->assign('m', $data);
        $this->addManufacturersPage();
    }

    function deleteManufacturers()
    {
        $stock = M('stock_manufacturers');
        $stock->delete($_GET['id']);
        $this->redirect("manufacturers");
    }
    // ---------仓库----------------------------------------------
    public function stock()
    {
        $model = M('stock_warehouse');
        import("ORG.Util.Page");
        $where = $this->getWhere();
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('stock');
    }

    function addStock()
    {
        $stock = M('stock_warehouse');
        $data = $stock->create();
        if (empty($data['id'])) {
            $stock->add($data);
        } else {
            $stock->save($data);
        }
        $this->stock();
    }

    function updateStock()
    {
        $stock = M('stock_warehouse');
        $data = $stock->find($_GET['id']);
        $this->assign('stock', $data);
        $this->stock();
    }

    function deleteStock()
    {
        $stock = M('stock_warehouse');
        $stock->delete($_GET['id']);
        $this->stock();
    }

    function stockView()
    {
        import("ORG.Util.Page");
        $code = $this->getParam('scode');
        $name = $this->getParam('sname');
        if (! empty($code))
            $where = "sp.p_id='$code'";
        if (! empty($name)) {
            if (! empty($where))
                $where .= " AND";
            $where = $where . " sp.p_name like '%$name%'";
        }
        if (! empty($where))
            $where = "WHERE " . $where;
        $id = $_GET['id'];
        $sql = "SELECT 
			  sp.p_name `productname`,
			  sp.p_all_name `p_all_name`,
			  sp.p_pc_price `productprice`,
			  p.* 
			FROM
			  (SELECT 
			    sps.`productcode`,
			    sps.`storage`,
			    sps.`stockcode` 
			  FROM
			    saas.stock_product_storage sps 
			    INNER JOIN saas.stock_warehouse sw 
			      ON sw.`stockcode` = sps.`stockcode` 
			  WHERE sw.`id` = $id 
			    AND sps.id = 
			    (SELECT 
			      MAX(id) 
			    FROM
			      saas.stock_product_storage 
			    WHERE `productcode` = sps.`productcode` 
			      AND stockcode = sw.`stockcode`)) p 
			  INNER JOIN hohsin.`tb_pro` sp 
			    ON p.productcode = sp.p_id   $where ";
        $model = new Model();
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->assign('id', $id);
        $sw = M('stock_warehouse');
        $data = $sw->find($id);
        $this->assign('name', $data['stockname']);
        $this->display('stockView');
    }

    function stockChangeRecord()
    {
        import("ORG.Util.Page");
        $code = $this->getParam('scode');
        $name = $this->getParam('sname');
        if (! empty($code))
            $where = "scd.productcode='$code'";
        if (! empty($name)) {
            if (! empty($where))
                $where .= " AND";
            $where = $where . " scd.productname like '%$name%'";
        }
        $id = $_GET['id'];
        $this->assign('id', $id);
        $sw = M('stock_warehouse');
        $data = $sw->find($id);
        $this->assign('name', $data['stockname']);
        $sql = "SELECT 
		  IFNULL(sc.indate, sc.outdate) dodate,
		  scd.`productname`,
		  scd.`productcode`,
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
		WHERE sw.`id` =$id ";
        if (! empty($where))
            $sql .= " AND $where";
        $model = new Model();
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('stockChangeRecord');
    }
    // ----------采购------------------------------------------
    function purchase()
    {
        $state = $this->getParam('state');
        $mname = $this->getParam('mname');
        $model = new Model();
        $sql = "SELECT 
  sp.*,
  sm.`mname` 
FROM
  `stock_purchase` sp 
  INNER JOIN `stock_manufacturers` sm 
    ON sp.`manufacturer` = sm.`id` 
   WHERE  sp.code ='" . $this->getCode() . "'";
        if (! empty($state))
            $sql .= "purchasestate='$state'";
        if (! empty($mname))
            $sql .= "AND sm.`mname` LIKE '%$mname%'";
        $smt = M('stock_manufacturers_type');
        $list = $smt->where($this->getWhere())
            ->select();
        $this->assign("types", $list);
        
        import("ORG.Util.Page");
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('purchase');
    }

    function getManufacturers()
    {
        $type = $_POST['type'];
        $manufacturer = M('stock_manufacturers');
        $data = $manufacturer->where("type='$type' ")->select();
        echo json_encode($data);
    }

    function getProduct()
    {
        $code = $_POST['code'];
        $dao = new Model();
        $data = $dao->db(1, C('shop_db'))->query("SELECT 
															p_price AS productprice,p_pc_price as productpcprice,
														  p_all_name AS productname,p_unit AS productunit,
														  p_size AS productsize,
														  p_model AS productmodel,
														  p_cp AS productcp,p_from AS productcd
															FROM
															  tb_pro WHERE p_id = '$code'");
        echo json_encode($data[0]);
    }

    function addPurchasePage()
    {
        // 查询供应商类别
        $smt = M('stock_manufacturers_type');
        $list = $smt->where($this->getWhere())
            ->select();
        $this->assign("types", $list);
        // 设置流水号
        $linecode = getStockPurchaseCode();
        $this->assign('linecode', $linecode);
        $this->display('addPurchase');
    }

    function addPurchase()
    {
        $sp = M('stock_purchase');
        $spd = M('stock_purchase_detail');
        try {
            $sp->startTrans();
            $spdata = $sp->create();
            $purchase = $spdata['id'];
            if (empty($purchase))
                $purchase = $sp->add($spdata);
            else {
                $sp->save($spdata);
                // 刪除原來的明細
                $spd->execute("DELETE FROM stock_purchase_detail WHERE purchase=$purchase");
            }
            
            // 添加採購明細
            $details = $_POST['detail'];
            if (! empty($details)) {
                foreach ($details as $key => $value) {
                    $datas = explode(",", $value);
                    $data['productcode'] = $datas[0];
                    $data['productname'] = $datas[1];
                    $data['price'] = $datas[2];
                    $data['quantity'] = $datas[3];
                    $data['subtotal'] = $datas[4];
                    $data['purchase'] = $purchase;
                    $spd->add($data);
                }
            }
            $sp->commit();
        } catch (Exception $e) {
            $sp->rollback();
        }
        $this->purchase();
    }

    function deletePurchase()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('stock_purchase');
        $model->delete($where);
        $model = M('stock_purchase_detail');
        $model->execute("DELETE FROM stock_purchase_detail WHERE purchase IN ($where) ");
        $this->purchase();
    }

    function purchaseCheckPage()
    {
        $id = $_GET['id'];
        $sp = M('stock_purchase');
        $sql = "SELECT
		sp.*,
		sm.`mname`
		FROM
		`stock_purchase` sp
		INNER JOIN `stock_manufacturers` sm
		ON sp.`manufacturer` = sm.`id` WHERE sp.id=$id";
        $data = $sp->query($sql);
        $this->assign('sp', $data[0]);
        $spd = M('stock_purchase_detail');
        $datas = $spd->where('purchase= ' . $id)->select();
        $this->assign('spd', $datas);
        
        $this->display('purchaseCheck');
    }

    function purchaseCheck()
    {
        $sp = M('stock_purchase');
        $data = $sp->create();
        $sp->save($data);
        $this->purchase();
    }

    function purchaseView()
    {
        $id = $_GET['id'];
        $sp = M('stock_purchase');
        $sql = "SELECT
		sp.*,
		sm.`mname`
		FROM
		`stock_purchase` sp
		INNER JOIN `stock_manufacturers` sm
		ON sp.`manufacturer` = sm.`id` WHERE sp.id=$id";
        $data = $sp->query($sql);
        $this->assign('sp', $data[0]);
        $spd = M('stock_purchase_detail');
        $datas = $spd->where('purchase= ' . $id)->select();
        $this->assign('spd', $datas);
        $this->display('purchaseView');
    }

    function purchaseEdit()
    {
        $id = $_GET['id'];
        $sp = M('stock_purchase');
        $sql = "SELECT
		sp.*,
		sm.`mname`
		FROM
		`stock_purchase` sp
		INNER JOIN `stock_manufacturers` sm
		ON sp.`manufacturer` = sm.`id` WHERE sp.id=$id";
        $data = $sp->query($sql);
        $this->assign('sp', $data[0]);
        $spd = M('stock_purchase_detail');
        $datas = $spd->where('purchase= ' . $id)->select();
        $this->assign('spd', $datas);
        $this->display('purchaseEdit');
    }
    // ----------验货------------------------------------------
    function stockCheck()
    {
        $state = $this->getParam('state');
        $mname = $this->getParam('mname');
        $model = new Model();
        $sql = "SELECT
		sc.*,
		sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer` = sm.`id`
		WHERE  sc.code ='" . $this->getCode() . "'";
        // if (! empty ( $state ))
        // $sql .= "purchasestate='$state'";
        if (! empty($mname))
            $sql .= "AND sm.`mname` LIKE '%$mname%'";
        $smt = M('stock_manufacturers_type');
        $list = $smt->where($this->getWhere())
            ->select();
        $this->assign("types", $list);
        
        import("ORG.Util.Page");
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('stockCheck');
    }

    function addStockCheckPage()
    {
        // 查询供应商类别
        $smt = M('stock_manufacturers_type');
        $list = $smt->where($this->getWhere())
            ->select();
        $this->assign("types", $list);
        // 设置流水号
        $linecode = getStockCheckCode();
        $this->assign('linecode', $linecode);
        $this->display('addStockCheck');
    }

    function getPurchase()
    {
        $code = $this->getCode();
        $manufacturer = $_POST['manufacturer'];
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
        
        $m = new Model();
        $data = $m->query($sql);
        echo json_encode($data);
    }

    function addStockCheck()
    {
        $sc = M('stock_check');
        $scd = M('stock_check_detail');
        try {
            $sc->startTrans();
            $scdata = $sc->create();
            $scid = $scdata['id'];
            if (empty($scid)) {
                $scid = $sc->add($scdata);
                $sci = M('stock_check_in');
                $scidata['checkid'] = $scid;
                $scidata['storagecode'] = getStockStorageCode();
                $scidata['code'] = $scdata['code'];
                $sci->add($scidata);
            } else {
                $sc->save($scdata);
                // 刪除原來的明細
                $scd->execute("DELETE FROM stock_check_detail WHERE checkid=$scid");
            }
            
            // 驗貨明細
            $checkdetails = $_POST['checkdetail'];
            if (! empty($checkdetails)) {
                $details = explode(";", $checkdetails);
                if (! empty($details)) {
                    foreach ($details as $key => $value) {
                        $datas = explode(",", $value);
                        $data['purchasecode'] = $datas[0];
                        $data['productcode'] = $datas[1];
                        $data['productname'] = $datas[2];
                        $data['quantity'] = $datas[3];
                        $data['price'] = $datas[7];
                        $data['uncome'] = $datas[4];
                        $data['income'] = $datas[5];
                        $data['subtotal'] = $datas[6];
                        $data['checkid'] = $scid;
                        $scd->add($data);
                    }
                }
            }
            $sc->commit();
        } catch (Exception $e) {
            $sc->rollback();
        }
        
        $this->stockCheck();
    }

    function stockCheckView()
    {
        $id = $_GET['id'];
        $sp = M('stock_check');
        $sql = "SELECT 
		  sc.*,
		  sm.`mname`
		FROM
		  `stock_check` sc 
		  INNER JOIN `stock_manufacturers` sm 
		    ON sc.`manufacturer` = sm.`id` 
		  WHERE sc.id=$id";
        $data = $sp->query($sql);
        $this->assign('sc', $data[0]);
        $scd = M('stock_check_detail');
        $datas = $scd->where('checkid= ' . $id)->select();
        $this->assign('scd', $datas);
        $this->display('stockCheckView');
    }

    function updateStockCheck()
    {
        $id = $_GET['id'];
        $sp = M('stock_check');
        $sql = "SELECT
		sc.*,
		sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer` = sm.`id`
		WHERE sc.id=$id";
        $data = $sp->query($sql);
        $this->assign('sc', $data[0]);
        $scd = M('stock_check_detail');
        $datas = $scd->where('checkid= ' . $id)->select();
        $this->assign('scd', $datas);
        $this->display('stockCheckEdit');
    }

    function deleteStockCheck()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('stock_check');
        $model->delete($where);
        $model = M('stock_check_detail');
        $model->execute("DELETE FROM stock_check_detail WHERE checkid IN ($where) ");
        $this->stockCheck();
    }
    // ----------进货---------------------------------------------
    function stockStorage()
    {
        $state = $this->getParam('sstate');
        $mname = $this->getParam('mname');
        $model = new Model();
        $sql = "SELECT
			sc.*,sci.`storagecode`,sm.`mname`
			FROM
			`stock_check` sc
			INNER JOIN `stock_check_in` sci
			ON sc.`id` = sci.`checkid`
			INNER JOIN `stock_manufacturers` sm
			ON sc.`manufacturer`=sm.`id`
			WHERE  sc.code ='" . $this->getCode() . "'";
        if (! empty($state))
            $sql .= " AND sc.state='$state'";
        if (! empty($mname))
            $sql .= "AND sm.`mname` LIKE '%$mname%'";
        import("ORG.Util.Page");
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('stockStorage');
    }
    // 进货审核 其实是审核验货的内容
    function stockStorageCheckPage()
    {
        $id = $_GET['id'];
        $sp = M('stock_check');
        $sql = "SELECT
			sc.*,sci.`storagecode`,sm.`mname`
			FROM
			`stock_check` sc
			INNER JOIN `stock_check_in` sci
			ON sc.`id` = sci.`checkid`
			INNER JOIN `stock_manufacturers` sm
			ON sc.`manufacturer`=sm.`id`
		WHERE sc.id=$id";
        $data = $sp->query($sql);
        $this->assign('sc', $data[0]);
        $scd = M('stock_check_detail');
        $datas = $scd->where('checkid= ' . $id)->select();
        $this->assign('scd', $datas);
        $this->display('stockStorageCheck');
    }

    function stockStorageCheck()
    {
        $sc = M('stock_check');
        $data = $sc->create();
        $sc->save($data);
        $this->stockStorage();
    }

    function stockStorageView()
    {
        $id = $_GET['id'];
        $sp = M('stock_check');
        $sql = "SELECT
		sc.*,sci.`storagecode`,sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_check_in` sci
		ON sc.`id` = sci.`checkid`
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer`=sm.`id`
		WHERE sc.id=$id";
        $data = $sp->query($sql);
        $this->assign('sc', $data[0]);
        $scd = M('stock_check_detail');
        $datas = $scd->where('checkid= ' . $id)->select();
        $this->assign('scd', $datas);
        $this->display('stockStorageView');
    }

    function stockStorageBackPage()
    {
        $id = $_GET['id'];
        $sp = M('stock_check');
        $sql = "SELECT
		sc.*,sci.`storagecode`,sm.`mname`
		FROM
		`stock_check` sc
		INNER JOIN `stock_check_in` sci
		ON sc.`id` = sci.`checkid`
		INNER JOIN `stock_manufacturers` sm
		ON sc.`manufacturer`=sm.`id`
		WHERE sc.id=$id";
        $data = $sp->query($sql);
        $this->assign('sc', $data[0]);
        $scd = M('stock_check_detail');
        $datas = $scd->where('checkid= ' . $id)->select();
        $this->assign('scd', $datas);
        $this->display('stockStorageBack');
    }

    function stockStorageBack()
    {
        $sb = M('stock_back');
        $sbd = M('stock_back_detail');
        try {
            $sb->startTrans();
            // 添加退貨主表
            $sbdata = $sb->create();
            $sbid = $sb->add($sbdata);
            // 更新驗貨表狀態為退貨
            $sc = M('stock_check');
            $scdata['id'] = $sbdata['checkid'];
            $scdata['state'] = '退貨';
            $sc->save($scdata);
            // 退貨明細
            $backdetails = $_POST['backdetail'];
            if (! empty($backdetails)) {
                $details = explode(";", $backdetails);
                if (! empty($details)) {
                    foreach ($details as $key => $value) {
                        $datas = explode(",", $value);
                        $data['purchasecode'] = $datas[0];
                        $data['productcode'] = $datas[1];
                        $data['productname'] = $datas[2];
                        $data['inquantity'] = $datas[3];
                        $data['backquantity'] = $datas[4];
                        $data['price'] = $datas[5];
                        $data['subtotal'] = $datas[6];
                        $data['backid'] = $sbid;
                        $sbd->add($data);
                    }
                }
            }
            $sb->commit();
        } catch (Exception $e) {
            $sb->rollback();
        }
        
        $this->stockStorage();
    }
    // ----------异动---------------------------------------------
    function stockChange()
    {
        import("ORG.Util.Page");
        $model = new Model();
        // 查询子类别
        $sql = "SELECT * FROM (SELECT 
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
		  sc.outcode,sc.incode,sc.allocatecode,
		  sc.`state`,sc.id
		  
		FROM
		  `stock_change` sc  WHERE sc.`code`= '" . $this->getCode() . "' ) x WHERE id is NOT NULL ";
        $type = $this->getParam('stocktype');
        $sdate = $this->getParam('sdate');
        $edate = $this->getParam('edate');
        if (! empty($type)) {
            $sql .= " AND  `type` = '$type' ";
            $this->assign("type", $type);
        }
        if (! empty($sdate)) {
            $sql .= " AND  `dodate` >= '$sdate' ";
            $this->assign("sdate", $sdate);
        }
        if (! empty($edate)) {
            $sql .= " AND  `dodate` <= '$edate 23:59:59' ";
            $this->assign("edate", $edate);
        }
        $sql .= " ORDER BY id desc";
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('stockChange');
    }

    function stockChangeView()
    {
        import("ORG.Util.Page");
        $model = new Model();
        // 查询子类别
        $sql = "";
        $list = $model->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $model->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('stockChangeView');
    }

    function stockIn()
    {
        $type = M('stock_in_type');
        $list = $type->where("code ='" . $this->getCode() . "'")
            ->select();
        $this->assign('types', $list);
        $this->assign('incode', getStockInCode());
        $this->display('stockIn');
    }

    function addStockIn()
    {
        $sc = M('stock_change');
        $scd = M('stock_change_detail');
        
        $sc->startTrans();
        // 主表
        $data = $sc->create();
        $ret = $scid = $sc->add($data);
        // 明細
        $details = $_POST['detail'];
        if (! empty($details)) {
            foreach ($details as $key => $value) {
                /*$('#productcode').val() + ","
					+ $('#productname').html() + "," 
					+ $('#productprice').val()+ "," 
					+ $('#quantity').val() + "," 
					+ $('#subtotal').html()+ "," + "," 
					+ $('#productremark').val() + ","
					+ $('#productunit').val() + "," 
					+ $('#productmodel').val()+ "," 
					+ $('#productsize').val() + ","
					+ $('#productcp').val() + "," 
					+ $('#productcd').val();*/
                $datas = explode(",", $value);
                $data['productcode'] = $datas[0];
                $data['productname'] = $datas[1];
                $data['price'] = $datas[2];
                $data['quantity'] = $datas[3];
                $data['subtotal'] = $datas[4];
                $data['remark'] = $datas[5];
                $data['productunit'] = $datas[6];
                $data['productmodel'] = $datas[7];
                $data['productsize'] = $datas[8];
                $data['productcp'] = $datas[9];
                $data['productcd'] = $datas[10];
                $data['changeid'] = $scid;
                $ret2 = $scd->add($data);
                // $ret3 = $scd->execute ( "UPDATE stock_product SET
                // productstock=productstock+$datas[3] WHERE
                // productcode='$datas[0]'" );
                $ret = $ret && $ret2;
            }
        }
        
        if ($ret) {
            $sc->commit();
        } else {
            $sc->rollback();
        }
        
        $this->redirect("stockChange");
    }

    function stockOut()
    {
        $type = M('stock_out_type');
        $list = $type->where("code ='" . $this->getCode() . "'")
            ->select();
        $this->assign('types', $list);
        $this->assign('outcode', getStockOutCode());
        $this->display('stockOut');
    }

    function addStockOut()
    {
        $sc = M('stock_change');
        $ret = $scd = M('stock_change_detail');
        $sc->startTrans();
        // 主表
        $data = $sc->create();
        $scid = $sc->add($data);
        // 明細
        $details = $_POST['detail'];
        if (! empty($details)) {
            foreach ($details as $key => $value) {
                /* $('#productcode').val() + ","
					+ $('#productname').html() + "," 
					+ $('#productprice').val()+ "," 
					+ $('#quantity').val() + "," 
					+ $('#subtotal').html()+ "," 
					+ $('#productremark').val()+ ","
					+ $('#productunit').val()+ "," 
					+ $('#productmodel').val()+ ","
					+ $('#productsize').val()+ "," 
					+ $('#productcp').val()+ "," 
					+ $('#productcd').val();*/
                $datas = explode(",", $value);
                $data['productcode'] = $datas[0];
                $data['productname'] = $datas[1];
                $data['price'] = $datas[2];
                $data['quantity'] = $datas[3];
                $data['subtotal'] = $datas[4];
                $data['remark'] = $datas[5];
                $data['productunit'] = $datas[6];
                $data['productmodel'] = $datas[7];
                $data['productsize'] = $datas[8];
                $data['productcp'] = $datas[9];
                $data['productcd'] = $datas[10];
                $data['changeid'] = $scid;
                // $ret2 = $scd->execute ( "UPDATE stock_product SET
                // productstock=productstock-$datas[3] WHERE
                // productcode='$datas[0]'" );
                $ret2 = $scd->add($data);
                $ret = $ret && $ret2;
            }
        }
        
        if ($ret) {
            $sc->commit();
        } else {
            $sc->rollback();
        }
        $this->redirect("stockChange");
    }

    function stockAllocate()
    {
        $this->assign('allocatecode', getStockAllocateCode());
        $this->display('stockAllocate');
    }

    function addStockAllocate()
    {
        $sc = M('stock_change');
        $scd = M('stock_change_detail');
        try {
            $sc->startTrans();
            // 主表
            $data = $sc->create();
            $scid = $sc->add($data);
            // 明細
            $details = $_POST['detail'];
            if (! empty($details)) {
                foreach ($details as $key => $value) {
                    $datas = explode(",", $value);
                    $data['productcode'] = $datas[0];
                    $data['productname'] = $datas[1];
                    $data['price'] = $datas[2];
                    $data['quantity'] = $datas[3];
                    $data['subtotal'] = $datas[4];
                    $data['remark'] = $datas[5];
                    $data['productunit'] = $datas[6];
                    $data['productmodel'] = $datas[7];
                    $data['productsize'] = $datas[8];
                    $data['productcp'] = $datas[9];
                    $data['productcd'] = $datas[10];
                    $data['changeid'] = $scid;
                    $scd->add($data);
                }
            }
            $sc->commit();
        } catch (Exception $e) {
            $sc->rollback();
        }
        $this->redirect("stockChange");
    }

    function setData()
    {
        $id = $_GET['id'];
        $sc = M('stock_change');
        // $sql = "SELECT * FROM stock_change id=$id";
        $data = $sc->find($id);
        $this->assign('sc', $data);
        $objid = $data['objid'];
        if ($data['objtype'] == '客戶') {
            $sql = "select  id,companyname `name` from client where id=$objid";
        } else {
            
            $sql = "select id,mname `name` from stock_manufacturers where id=$objid";
        }
        $obj = $sc->query($sql);
        $this->assign("obj", $obj[0]);
        $spd = M('stock_change_detail');
        $datas = $spd->where('changeid= ' . $id)->select();
        $this->assign('scd', $datas);
    }

    function stockInView()
    {
        $this->setData();
        $this->display();
    }

    function stockOutView()
    {
        $this->setData();
        $this->display();
    }

    function stockAllocateView()
    {
        $this->setData();
        $this->display();
    }

    function stockInCheckPage()
    {
        $this->setData();
        $this->display('stockInCheck');
    }

    function stockOutCheckPage()
    {
        $this->setData();
        $this->display('stockOutCheck');
    }

    function stockAllocateCheckPage()
    {
        $this->setData();
        $this->display('stockAllocateCheck');
    }

    function stockChangeCheck()
    {
        $sc = M('stock_change');
        $sc->startTrans();
        $data = $sc->create();
        $data['checkdate'] = date("Y-m-d h:i:s");
        $ret = $sc->save($data);
        if ($data['state'] == '核可') {
            $id = $data['id'];
            $data = $sc->find($id);
            $scd = M('stock_change_detail');
            $datas = $scd->where('changeid= ' . $id)->select();
            $sps = M('stock_product_storage');
            $type = $data['type'];
            // stock_product_storage 和stock_change_detail 关联起来
            if ($type == '入庫') {
                // 查询库存stock_product_storage
                foreach ($datas as $k => $v) {
                    // 查询以前是否有异动信息 如果有库存就取上次的库存加或者减这次的变化量，如果没有库存就为这次的数量
                    // 仓库编号
                    $ccode = $data['inwarehousecode'];
                    // 产品编号
                    $pcode = $v['productcode'];
                    // 公司编号
                    $code = $this->code;
                    $sql = "SELECT * FROM stock_product_storage WHERE stockcode='$ccode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
                    $qData = $sc->query($sql);
                    if (count($qData) > 0) {
                        $iData['storage'] = $qData[0]['storage'] + $v['quantity'];
                    } else {
                        $iData['storage'] = $v['quantity'];
                    }
                    $iData['stockcode'] = $data['inwarehousecode'];
                    $iData['productcode'] = $v['productcode'];
                    $iData['detailid'] = $v['id'];
                    $iData['code'] = $code;
                    $ret = $ret && $sps->add($iData);
                    //
                }
                
                // taketoaccount拋轉會計系統
                if ($data['taketoaccount'] == 1) {
                    $pay = M('account_pay');
                    $payData['indate'] = $data['indate'];
                    $payData['objecttype'] = $data['intype'];
                    $payData['objectname'] = $data['intypename'];
                    $payData['incomemoney'] = $data['totalmoney'];
                    $payData['code'] = $data['code'];
                    $payData['paystate'] = '未兌現';
                    $ret3 = $pay->add($payData);
                    $ret = $ret && $ret3;
                }
            } else 
                if ($type == '出庫') {
                    // 查询库存stock_product_storage
                    foreach ($datas as $k => $v) {
                        // 查询以前是否有异动信息 如果有库存就取上次的库存加或者减这次的变化量，如果没有库存就为这次的数量
                        // 仓库编号
                        $ccode = $data['outwarehousecode'];
                        // 产品编号
                        $pcode = $v['productcode'];
                        // 公司编号
                        $code = $this->code;
                        $sql = "SELECT * FROM stock_product_storage WHERE stockcode='$ccode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
                        $qData = $sc->query($sql);
                        if (count($qData) > 0) {
                            $iData['storage'] = $qData[0]['storage'] - $v['quantity'];
                        } else {
                            $iData['storage'] = 0 - $v['quantity'];
                        }
                        $iData['stockcode'] = $ccode;
                        $iData['productcode'] = $pcode;
                        $iData['detailid'] = $v['id'];
                        $iData['code'] = $code;
                        $ret = $ret && $sps->add($iData);
                    }
                    
                    // taketoaccount拋轉會計系統
                    if ($data['taketoaccount'] == 1) {
                        $in = M('account_income');
                        $inData['indate'] = $data['outdate'];
                        $inData['objecttype'] = $data['outtype'];
                        $inData['objectname'] = $data['outtypename'];
                        $inData['incomemoney'] = $data['totalmoney'];
                        $inData['code'] = $data['code'];
                        $inData['paystate'] = '未兌現';
                        $ret3 = $in->add($inData);
                        $ret = $ret && $ret3;
                    }
                } else {
                    // 查询库存stock_product_storage
                    foreach ($datas as $k => $v) {
                        // 查询以前是否有异动信息 如果有库存就取上次的库存加或者减这次的变化量，如果没有库存就为这次的数量
                        // 调入仓库编号
                        $icode = $data['inwarehousecode'];
                        // 调出仓库编号
                        $ocode = $data['outwarehousecode'];
                        // 产品编号
                        $pcode = $v['productcode'];
                        // 公司编号
                        $code = $this->code;
                        // 调入开始
                        /**
                         * *************************
                         */
                        $sql = "SELECT * FROM stock_product_storage WHERE stockcode='$icode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
                        
                        $qData = $sc->query($sql);
                        if (count($qData) > 0) {
                            $iData['storage'] = $qData[0]['storage'] + $v['quantity'];
                        } else {
                            $iData['storage'] = $v['quantity'];
                        }
                        $iData['stockcode'] = $icode;
                        $iData['productcode'] = $pcode;
                        $iData['detailid'] = $v['id'];
                        $iData['code'] = $code;
                        $ret = $ret && $sps->add($iData);
                        /**
                         * ***********************
                         */
                        // 调出开始
                        /**
                         * *************************
                         */
                        $sql = "SELECT * FROM stock_product_storage WHERE stockcode='$ocode' AND productcode ='$pcode' AND code ='$code' order by id desc limit 1";
                        
                        $qData = $sc->query($sql);
                        if (count($qData) > 0) {
                            $iData['storage'] = $qData[0]['storage'] - $v['quantity'];
                        } else {
                            $iData['storage'] = 0 - $v['quantity'];
                        }
                        $iData['stockcode'] = $ocode;
                        $iData['productcode'] = $pcode;
                        $iData['detailid'] = $v['id'];
                        $iData['code'] = $code;
                        $ret = $ret && $sps->add($iData);
                    /**
                     * ***********************
                     */
                    }
                }
        }
        if ($ret)
            $sc->commit();
        else
            $sc->rollback();
        
        $this->redirect("stockChange");
    }

    function getStock()
    {
        $code = $_POST['code'];
        $stock = M('stock_warehouse');
        $data = $stock->where("stockcode='$code' and stockstate='開啟' ")->find();
        echo json_encode($data['stockname']);
    }

    function stockInType()
    {
        $model = M('stock_in_type');
        import("ORG.Util.Page");
        $where = $this->getWhere();
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('stockInType');
    }

    function addStockInType()
    {
        $type = M('stock_in_type');
        $data = $type->create();
        if (empty($data['id'])) {
            $type->add($data);
        } else {
            $type->save($data);
        }
        $this->stockInType();
    }

    function updateStockInType()
    {
        $type = M('stock_in_type');
        $data = $type->find($_GET['id']);
        $this->assign('intype', $data);
        $this->stockInType();
    }

    function deleteStockInType()
    {
        $stock = M('stock_in_type');
        $stock->delete($_GET['id']);
        $this->stockInType();
    }

    function stockOutType()
    {
        $model = M('stock_out_type');
        import("ORG.Util.Page");
        $where = $this->getWhere();
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('stockOutType');
    }

    function addStockOutType()
    {
        $type = M('stock_out_type');
        $data = $type->create();
        if (empty($data['id'])) {
            $type->add($data);
        } else {
            $type->save($data);
        }
        $this->stockOutType();
    }

    function updateStockOutType()
    {
        $type = M('stock_out_type');
        $data = $type->find($_GET['id']);
        $this->assign('outtype', $data);
        $this->stockOutType();
    }

    function deleteStockOutType()
    {
        $stock = M('stock_out_type');
        $stock->delete($_GET['id']);
        $this->stockOutType();
    }
    // 盘点
    function stockInventoryAdd()
    {
        $stock = M('stock_warehouse');
        $id = $_GET['stockid'];
        $data = $stock->find($id);
        $this->assign('stock', $data);
        
        $id = $_GET['id'];
        $Inventory = M('stock_inventory');
        $inv = $Inventory->find($id);
        $this->assign('inventory', $inv);
        $stockid = $_GET['stockid'];
        $this->display('stockInventoryAdd');
        $this->display('stockInventoryAdd');
    }

    function stockInventoryList()
    {
        $stock = M('stock_warehouse');
        $id = $_GET['id'];
        $data = $stock->find($id);
        $this->assign('stock', $data);
        import("ORG.Util.Page");
        $Inventory = M('stock_inventory');
        $where = 'stockid=' . $id;
        $count = $Inventory->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $Inventory->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('stockInventoryList');
    }

    function stockInventorySave()
    {
        $Inventory = M('stock_inventory');
        $Inventory->startTrans();
        try {
            $data = $Inventory->create();
            $ret = $Inventory->add($data);
            $this->checkExcept($ret);
            // 保存盘点主表
            
            // 修改仓库状态为关闭
            $stock = M('stock_warehouse');
            $stockData['id'] = $_GET['id'];
            $stockData['stockstate'] = '關閉';
            $ret = $stock->save($stockData);
            $this->checkExcept($ret);
            
            $Inventory->commit();
        } catch (Exception $e) {
            $Inventory->rollback();
        }
        $this->stockInventoryList();
    }

    function stockInventoryView()
    {
        $id = $_GET['id'];
        $Inventory = M('stock_inventory');
        $inv = $Inventory->find($id);
        $this->assign('inventory', $inv);
        $stockid = $_GET['stockid'];
        
        $stock = M('stock_warehouse');
        $data = $stock->find($stockid);
        $this->assign('stock', $data);
        
        $state = $this->getParam('state');
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
        if (! empty($state)) {
            $csql .= " WHERE z.state='$state'";
            $dsql .= " WHERE z.state='$state'";
            $this->assign('state', $state);
        }
        $this->page($csql, $dsql);
        $this->display('stockInventoryView');
    }

    function getProductStorage()
    {
        $code = $_POST['code'];
        $stockcode = $_POST['stockcode'];
        $sql = "SELECT  
		        p.p_id as productcode,
		        p.p_price AS productprice,
			    p.p_name AS productname,
			    p_unit AS productunit,
			    p.p_size AS productsize,
			    p.p_model AS productmodel,
			    p.p_cp AS productcp,p_from AS productcd,
			  store.`storage` 
			FROM
			  saas.`stock_product_storage` store 
			  INNER JOIN hohsin.tb_pro p 
			    ON store.`productcode` = p.`p_id` 
			WHERE store.`stockcode` ='$stockcode'
			  AND store.id = 
			  (SELECT 
			    MAX(id) 
			  FROM
			    saas.`stock_product_storage` 
			  WHERE productcode = '$code' AND `stockcode` = '$stockcode' )";
        $data = $this->execObj($sql);
        echo json_encode($data[0]);
    }

    function stockInventoryDetailSave()
    {
        $inventoryid = $_GET['id'];
        $stockid = $_GET['stockid'];
        $continue = $_POST['continue'];
        $detail = M('stock_inventory_detail');
        $detail->startTrans();
        try {
            if ($continue == 0) {
                // 修改仓库状态为开启
                $stock = M('stock_warehouse');
                $stockData['id'] = $stockid;
                $stockData['stockstate'] = '開啟';
                $ret = $stock->save($stockData);
                $this->checkExcept($ret);
                // 结束盘点填入日期
                $inv = M('stock_inventory');
                $data = $inv->create();
                $data['id'] = $inventoryid;
                $data['enddate'] = date('Y/m/d');
                $data['stockopenhour'] = date('h');
                $data['stockopenminute'] = date('i');
                $ret = $inv->save($data);
                $this->checkExcept($ret);
            }
            $details = $_POST['detail'];
            if (! empty($details)) {
                foreach ($details as $key => $value) {
                    $datas = explode(",", $value);
                    $datadetail['inventoryid'] = $inventoryid;
                    $datadetail['stockid'] = $stockid;
                    $datadetail['productcode'] = $datas[0];
                    $datadetail['productname'] = $datas[1];
                    $datadetail['productprice'] = $datas[2];
                    $datadetail['productstorage'] = $datas[3];
                    $datadetail['productfactquantity'] = $datas[4];
                    $ret = $detail->add($datadetail);
                    $this->checkExcept($ret);
                }
            }
            $detail->commit();
        } catch (Exception $e) {
            $detail->rollback();
        }
        
        $this->stockInventoryView();
    }

    function ImportStockOut()
    {
        // 縣上傳EXCEL
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            
            $files = $up->getUploadFileInfo();
            $path = $files[0]["savename"];
            
            $filename = BASEPATH . "/Public/Uploads/atts/case/" . $path;
            chmod($filename, 777);
            vendor('PHPExcelReader.Reader');
            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding("UTF-8");
            $data->read($filename);
            $total = 0;
            try {
                for ($i = 2; $i <= $data->sheets[0]['numRows'] - 1; $i ++) {
                    if ($i == 2) {
                        $ordercode = $data->sheets[0]['cells'][$i][1];
                        $this->assign("ordercode", $ordercode);
                        $orderuser = $data->sheets[0]['cells'][$i][2];
                        $this->assign("orderuser", $orderuser);
                    }
                    $datas[$i - 2]['productcode'] = $data->sheets[0]['cells'][$i][3];
                    $datas[$i - 2]['productname'] = $data->sheets[0]['cells'][$i][4];
                    $datas[$i - 2]['productprice'] = $data->sheets[0]['cells'][$i][5];
                    $datas[$i - 2]['quantity'] = $data->sheets[0]['cells'][$i][6];
                    $datas[$i - 2]['subtotal'] = $data->sheets[0]['cells'][$i][7];
                    $datas[$i - 2]['remark'] = $data->sheets[0]['cells'][$i][8];
                    $total += $datas[$i - 2]['subtotal'];
                }
                
                $this->assign("list", $datas);
                $this->assign("total", round($total, 0));
                // $this->ShowMessage ( "導入成功!" );
            } catch (Exception $e) {
                // $this->ShowMessage ( "導入失敗!" );
            }
        } else {
            $this->ShowMessage($up->getErrorMsg());
            $this->ShowMessage('上傳文件失敗!');
        }
        
        $this->stockOut();
    }

    function StockTest()
    {
        $id = $_GET['id'];
        $this->assign('id', $id);
        $sw = M('stock_warehouse');
        $data = $sw->find($id);
        $this->assign('name', $data['stockname']);
        $dao = M('stock_test');
        $state = $this->getParam("sstate");
        if (! empty($state))
            $where = " state = '$state' ";
        $this->table_page($dao, $where);
        $this->display('stockTest');
    }

    function StockTestAdd()
    {
        $id = $_GET['id'];
        $this->assign('id', $id);
        $sw = M('stock_warehouse');
        $data = $sw->find($id);
        $this->assign('name', $data['stockname']);
        $this->display('stockTestAdd');
    }

    function StockTestSave()
    {
        $dao = M('stock_test');
        $data = $dao->create();
        $data['nextwarntime'] = empty($_POST['nextwarn']) ? '無' : $data['nextwarntime'];
        $data['nextchecktime'] = empty($_POST['nextcheck']) ? '無' : $data['nextchecktime'];
        if (empty($data['id'])) {
            $dao->add($data);
        } else {
            $dao->save($data);
        }
        $this->StockTest();
    }

    function StockTestCheck()
    {
        $dao = new Model();
        $id = $_GET['testid'];
        $dao->execute("UPDATE stock_test SET state='已检验',lastchecktime='" . date('Y-m-d') . "' WHERE id=$id");
        $this->StockTest();
    }

    function StockTestDetlete()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $dao = M('stock_test');
        $dao->delete($where);
        $this->StockTest();
    }

    function StockPrint()
    {
        $id = $_GET['id'];
        $sc = M('stock_change');
        // $sql = "SELECT * FROM stock_change id=$id";
        $data = $sc->find($id);
        $this->assign('sc', $data);
        $spd = M('stock_change_detail');
        $datas = $spd->where('changeid= ' . $id)->select();
        $this->assign('scd', $datas);
        $totalmoney = $data['totalmoney'];
        $taxmoney = $totalmoney * 0.05;
        $allmoney = $totalmoney + $taxmoney;
        $this->assign('totalmoney', $totalmoney);
        $this->assign('taxmoney', $taxmoney);
        $this->assign('allmoney', $allmoney);
        if ($data['type'] == '調撥') {
            $this->display('PrintAllocate');
        } else {
            
            if ($data['type'] == '入庫') {
                $type = $data['intype'];
                $this->assign('code',$data['incode']);
                $this->assign('typename', $data['intypename']);
                $this->assign('date',$data['indate']);
                $warehousecode=$data['inwarehousecode'];
                $io = M('stock_in_type');
            } else {
                $type = $data['outtype'];
                $io = M('stock_out_type');
                $warehousecode=$data['outwarehousecode'];
                $this->assign('date',$data['outdate']);
                $this->assign('code',$data['outcode']);
                $this->assign('typename', $data['outtypename']);
            }
            $iodata = $io->find($type);
            if ($iodata['type'] == '客戶') {
                 $sql = "SELECT
			  c.*,
			  prov.`name` provName,
			  city.name cityName ,
			  dprov.`name` dprovName,
			  dcity.`name` dcityName
			FROM
			  `client` c
			  INNER JOIN AREA prov
			    ON c.clientprov = prov.id
			  INNER JOIN AREA city
			    ON c.clientcity = city.id
			 
			     INNER JOIN AREA dprov
			    ON c.clientprov = dprov.id
			  INNER JOIN AREA dcity
			    ON c.clientcity = dcity.id
				WHERE c.id =" . $data['objid'];
                $obj = $sc->query($sql);
                $this->assign('obj', $obj[0]);
                $this->display('PrintClient');
            } else   if ($iodata['type'] == '廠商') {
                $sql = "SELECT
			  c.*,
			  prov.`name` provName,
			  city.name cityName ,
			  invoiceprov.`name` invoiceprovName,
			  invoicecity.`name` invoicecityName
			FROM
			  `stock_manufacturers` c
			  INNER JOIN AREA prov
			    ON c.mprov = prov.id
			  INNER JOIN AREA city
			    ON c.mcity = city.id
			 
			     INNER JOIN AREA invoiceprov
			    ON c.invoiceprov = invoiceprov.id
			  INNER JOIN AREA invoicecity
			    ON c.invoicecity = invoicecity.id
				WHERE c.id =" . $data['objid'];
                $obj = $sc->query($sql);
                $this->assign('obj', $obj[0]);
                $this->display('PrintManufacturers');
            } else  if ($iodata['type'] == '倉庫') {
                $warehouse=M('stock_warehouse');
                $wh=$warehouse->where("stockcode='$warehousecode'")->find();
                $this->assign('wh',$wh);
                $this->display('PrintWareHouse');
            }
        }
    }

    function StockOutPrintClient()
    {
        $id = $_GET['id'];
        $sc = M('stock_change');
        // $sql = "SELECT * FROM stock_change id=$id";
        $data = $sc->find($id);
        $this->assign('typename', $data['outtypename']);
        $this->assign('sc', $data);
        $spd = M('stock_change_detail');
        $datas = $spd->where('changeid= ' . $id)->select();
        $this->assign('scd', $datas);
        $sql = "select * from client where id=" . $data['objid'];
        $obj = $sc->query($sql);
        $this->assign('obj', $obj[0]);
        $totalmoney = $data['totalmoney'];
        $taxmoney = $totalmoney * 0.05;
        $allmoney = $totalmoney + $taxmoney;
        $this->assign('totalmoney', $totalmoney);
        $this->assign('taxmoney', $taxmoney);
        $this->assign('allmoney', $allmoney);
        $this->display('StockOutPrintClient');
    }

    function StockOutPrintManufaturer()
    {
        $id = $_GET['id'];
        $sc = M('stock_change');
        // $sql = "SELECT * FROM stock_change id=$id";
        $data = $sc->find($id);
        $this->assign('typename', $data['intypename']);
        $this->assign('sc', $data);
        $spd = M('stock_change_detail');
        $datas = $spd->where('changeid= ' . $id)->select();
        $this->assign('scd', $datas);
        $sql = "SELECT 
			  c.*,
			  prov.`name` provName,
			  city.name cityName ,
			  dprov.`name` dprovName,
			  dcity.`name` dcityName
			FROM
			  `client` c 
			  INNER JOIN AREA prov 
			    ON c.clientprov = prov.id 
			  INNER JOIN AREA city 
			    ON c.clientcity = city.id 
			    
			     INNER JOIN AREA dprov 
			    ON c.clientprov = dprov.id 
			  INNER JOIN AREA dcity 
			    ON c.clientcity = dcity.id 
				WHERE c.id =" . $data['objid'];
        $obj = $sc->query($sql);
        $this->assign('obj', $obj[0]);
        $this->display('StockOutPrintClient');
    }

    function getObjs()
    {
        $objname = $_POST['objname'];
        $objtype = $_POST['objtype'];
        if ($objtype == '廠商') {
            $sql = "select id,mname `name` from stock_manufacturers where mname like '%$objname%' OR mcode ='$objname'";
        } else {
            $sql = "select  id,companyname `name` from client where companyname like '%$objname%' OR clientcode ='$objname'";
        }
        
        $dao = new Model();
        $data = $dao->query($sql);
        
        echo json_encode($data);
    }
}
?>