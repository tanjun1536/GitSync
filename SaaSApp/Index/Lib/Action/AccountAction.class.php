<?php
class AccountAction extends BaseAction {
	// -----------------------常用帳號設定---------------------------------
	function accountlist() {
		$acc = M ( 'account_id' );
		$code = $this->getCode ();
		$datas = $acc->where ( "code ='$code' " )->select ();
		$this->assign ( 'list', $datas );
		$this->display ( 'accountList' );
	}
	function addAccountPage() {
	
	}
	function addAccount() {
		$acc = M ( 'account_id' );
		$data = $acc->create ();
		if (empty ( $data ['id'] )) {
			$acc->add ( $data );
		} else {
			$acc->save ( $data );
		}
		$this->accountlist ();
	}
	function editAccount() {
		$acc = M ( 'account_id' );
		$data = $acc->find ( $_GET ['id'] );
		$this->assign ( 'acc', $data );
		$this->accountlist ();
	}
	function deleteAccount() {
		$acc = M ( 'account_id' );
		$acc->delete ( $_GET ['id'] );
		$this->accountlist ();
	}
	// -----------------------科目設定---------------------------------
	
	function subjectChildTypeAddPage() {
		$this->getType ();
		$this->display ( 'subjectChildTypeAdd' );
	}
	function subjectChildTypeAdd() {
		$ct = M ( 'account_subject_child_type' );
		$data = $ct->create ();
		if (empty ( $data ['id'] )) {
			$ct->add ( $data );
		} else {
			$ct->save ( $data );
		}
		$this->subjectTypeList ();
	}
	function editSubjectChildType() {
		$this->getType ();
		$ct = M ( 'account_subject_child_type' );
		$data = $ct->find ( $_GET ['id'] );
		$this->assign ( 'ct', $data );
		$this->display ( 'subjectChildTypeAdd' );
	}
	function deleteSubjectChildType() {
		$ct = M ( 'account_subject_child_type' );
		$ct->delete ( $_GET ['id'] );
		$this->subjectTypeList ();
	}
	function subjectTypeList() {
		$this->getType ();
		$sql = "SELECT 
		  ct.*,mt.`name` AS mname  
			FROM
		  `account_subject_type` mt 
		  INNER JOIN `account_subject_child_type` ct 
		    ON mt.`id` = ct.`type` 
		WHERE ct.`code` = '$this->code' ";
		$stype = $_POST ['stype'];
		if (! empty ( $stype )) {
			$sql .= " AND mt.id=" . $stype;
			$this->assign ( 'type', $stype );
		}
		$type = new Model ();
		$datas = $type->query ( $sql );
		$this->assign ( 'list', $datas );
		$this->display ( 'subjectTypeList' );
	}
	function subjectlist() {
		$this->getType ();
		$sql = "SELECT 
			  sb.*,mt.name as mname ,ct.name as cname 
			FROM
			  `account_subject` sb 
			  INNER JOIN `account_subject_type` mt 
			    ON sb.`mt` = mt.`id` 
			   INNER JOIN `account_subject_child_type` ct
			   ON sb.`ct`=ct.`id`
			  WHERE sb.`code` = '$this->code' ";
		$smt = $_POST ['smt'];
		$sct = $_POST ['sct'];
		if (! empty ( $smt )) {
			$sql .= " AND sb.mt=" . $smt;
			$this->assign ( 'mt', $smt );
		}
		if (! empty ( $sct )) {
			$sql .= " AND sb.ct=" . $sct;
			$this->assign ( 'ct', $sct );
		}
		$type = new Model ();
		$datas = $type->query ( $sql );
		$this->assign ( 'list', $datas );
		$this->display ( 'subjectList' );
	}
	function addSubjectPage() {
		$this->getType ();
		$this->display ( 'subjectAdd' );
	}
	function addSubject() {
		$subject = M ( 'account_subject' );
		$data = $subject->create ();
		if (empty ( $data ['id'] )) {
			$subject->add ( $data );
		} else {
			$subject->save ( $data );
		}
		$this->subjectlist ();
	}
	function editSubject() {
		$subject = M ( 'account_subject' );
		$data = $subject->find ( $_GET ['id'] );
		$this->assign ( 'sub', $data );
		$this->addSubjectPage ();
	}
	function deleteSubject() {
		$subject = M ( 'account_subject' );
		$subject->delete ( $_GET ['id'] );
		$this->subjectlist ();
	}
	// -----------------------收入管理---------------------------------
	function incomelist() {
		$in = M ( 'account_income' );
		$sql = "select * from account_income where code ='$this->code'";
		$sdate = $this->getParam('sdate');
		$edate = $this->getParam('edate');
		$paystate =$this->getParam('spaystate');
		$paymode = $this->getParam('spaymode');
		$objname =$this->getParam('objname');
		if ($sdate)
			$sql .= " and indate> '$sdate'";
		if ($edate)
			$sql .= " and indate<='$edate 23:59:59'";
		if ($paystate)
			$sql .= " and paystate='$paystate'";
		if ($paymode)
			$sql .= " and paymode='$paymode'";
		if ($objname)
			$sql .= " and objectname like '%$objname%'";
		$datas = $in->query ( $sql );
		$this->assign ( 'list', $datas );
		$this->display ( 'incomeList' );
	}
	function addIncomePage() {
		$this->getType ();
		$this->getAccount ();
		$this->getDeparts();
		$this->display ( 'incomeAdd' );
	}
	function addIncome() {
		$in = M ( 'account_income' );
		$data = $in->create ();
		if (empty ( $data ['id'] )) {
			$in->add ( $data );
		} else {
			$in->save ( $data );
		}
		$this->incomelist ();
	}
	function editIncome() {
		
		$in = M ( 'account_income' );
		$data = $in->find ( $_GET ['id'] );
		$this->assign ( 'in', $data );
		$this->getType ();
		$this->getAccount ();
		$this->getDeparts();
		$this->display ( 'incomeEdit' );
	}
	function deleteIncome() {
		$in = M ( 'account_income' );
		$in->delete($_GET['id']);
		$this->redirect("incomelist");
	}
	// -----------------------支付管理---------------------------------
	function paylist() {
		$in = M ( 'account_pay' );
		$sql = "select * from account_pay where code ='$this->code'";
		$sdate = $this->getParam('sdate');
		$edate = $this->getParam('edate');
		$paystate =$this->getParam('spaystate');
		$paymode = $this->getParam('spaymode');
		$objname =$this->getParam('objname');
		if ($sdate)
			$sql .= " and indate> '$sdate'";
		if ($edate)
			$sql .= " and indate<='$edate 23:59:59'";
		if ($paystate)
			$sql .= " and paystate='$paystate'";
		if ($paymode)
			$sql .= " and paymode='$paymode'";
		if ($objname)
			$sql .= " and objectname like '%$objname%'";
		$datas = $in->query ( $sql );
		$this->assign ( 'list', $datas );
		$this->display ( 'payList' );
	}
	function addPayPage() {
		$this->getType ();
		$this->getAccount ();
		$this->getDeparts();
		$this->display ( 'payAdd' );
	}
	function addPay() {
		$in = M ( 'account_pay' );
		$data = $in->create ();
		if (empty ( $data ['id'] )) {
			$in->add ( $data );
		} else {
			$in->save ( $data );
		}
		$this->paylist ();
	}
	function editPay() {
		$in = M ( 'account_pay' );
		$data = $in->find ( $_GET ['id'] );
		$this->assign ( 'in', $data );
		$this->getType ();
		$this->getAccount ();
		$this->getDeparts();
		$this->display ( 'payEdit' );
	}
	function deletePay() {
		$in = M ( 'account_pay' );
		$in->delete($_GET ['id']);
		
		$this->redirect("paylist");
	}
	// -----------------------傳票管理 ---------------------------------
	function billlist() {
		$billcode = $this->getParam ( 'sbillcode' );
		$sdate = $this->getParam ( 'sdate' );
		$edate = $this->getParam ( 'edate' );
		$sql = "SELECT 
		  *,
		  IFNULL(sumjfmoney, 0) AS jfmoney,
		  IFNULL(sumdfmoney, 0) AS dfmoney 
		FROM
		  ( SELECT 
		  *,
		  (SELECT 
		    SUM(jfmoney) 
		  FROM
		    `account_bill_detail` abd 
		  WHERE bill = ab.`id`) AS sumjfmoney,
		  (SELECT 
		    SUM(dfmoney) 
		  FROM
		    `account_bill_detail` abd 
		  WHERE bill = ab.`id`) AS sumdfmoney from `account_bill` ab WHERE code ='$this->code' ";
		$model = M ( 'account_bill' );
		import ( "ORG.Util.Page" );
		if (! empty ( $billcode )) {
			$sql .= " AND billcode like '%$billcode%'";
		}
		if (! empty ( $sdate )) {
			$sql .= " AND billdate > '$sdate'";
		}
		if (! empty ( $edate )) {
			$sql .= " AND billdate < '" . addDay ( $billcode ) . "'";
		}
		$sql .= " ) z";
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
		$this->display ( 'billList' );
	}
	function addBillPage() {
		$this->getAccount ();
		$this->display ( 'billAdd' );
	}
	function addBill() {
		
		$bill = M ( 'account_bill' );
		$billdetail = M ( 'account_bill_detail' );
		try {
			$bill->startTrans ();
			$billdata = $bill->create ();
			$billid = $billdata ['id'];
			if (empty ( $billid )) {
				$billid = $bill->add ( $billdata );
			} else {
				$billid->save ( $billdata );
				// 刪除原來的明細
				$billdetail->execute ( "DELETE FROM account_bill_detail WHERE bill=$billid" );
			}
			
			// 驗貨明細
			$details = $_POST ['billdetail'];
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$datas = explode ( ",", $value );
					$data ['subject'] = $datas [0];
					$data ['object'] = $datas [1];
					$data ['summary'] = $datas [2];
					$data ['jfmoney'] = $datas [3];
					$data ['dfmoney'] = $datas [4];
					$data ['bill'] = $billid;
					$billdetail->add ( $data );
				}
			}
			$bill->commit ();
		} catch ( Exception $e ) {
			$bill->rollback ();
		}
		$this->billlist ();
	}
	function billView() {
		$id = $_GET ['id'];
		$sql = "SELECT 
		  *,
		  IFNULL(sumjfmoney, 0) AS jfmoney,
		  IFNULL(sumdfmoney, 0) AS dfmoney 
		FROM
		  ( SELECT 
		  *,
		  (SELECT 
		    SUM(jfmoney) 
		  FROM
		    `account_bill_detail` abd 
		  WHERE bill = ab.`id`) AS sumjfmoney,
		  (SELECT 
		    SUM(dfmoney) 
		  FROM
		    `account_bill_detail` abd 
		  WHERE bill = ab.`id`) AS sumdfmoney FROM `account_bill` ab) z WHERE id=$id";
		$bill = M ( 'account_bill' );
		$data = $bill->query ( $sql );
		$this->assign ( 'bill', $data [0] );
		$billdetail = M ( 'account_bill_detail' );
		$datas = $billdetail->where ( " bill = " . $id )->select ();
		$this->assign ( 'details', $datas );
		$this->display ( 'billView' );
	}
	function editBill() {
		$this->display ( 'billEdit' );
	}
	function deleteBill() {
		$bill = M ( 'account_bill' );
		$id = $_GET ['id'];
		$bill->execute ( "DELETE FROM account_bill_detail WHERE bill=$id" );
		$bill->delete ( $id );
		$this->billlist ();
	}
	// -----------------------專案管理 ---------------------------------
	function caselist() {
		$this->display ( 'caseList' );
	}
	function addCasePage() {
	
	}
	function addCase() {
	
	}
	function editCase() {
	
	}
	function deleteCase() {
	
	}
	// -----------------------預算管理 ---------------------------------
	function budgetlist() {
		$budget=M("account_budget");
		$date=$this->getParam("sdate");
		$ysm=$this->getParam("ysm");
		$where = $this->getWhere();
		if(!empty($date)) $where.=" AND datediff(createdate ,'$date')=0 ";
		if(!empty($ysm)) $where.=" AND name like '%$ysm%' ";
		$list=$budget->where($where)->select();
		$this->assign('list',$list);
		$this->display ( 'budgetList' );
	}
	function addBudgetPage() {
		$this->getDeparts();
		//$this->getAccount ();
		$this->display ( 'budgetAdd' );
	}
	function addBudget() {
		$budget = M ( 'account_budget' );
		$budgetdetail = M ( 'account_budget_detail' );
		try {
			$budget->startTrans ();
			$budgetdata = $budget->create ();
			$budgetid = $budgetdata ['id'];
			if (empty ( $budgetid )) {
				$budgetid = $budget->add ( $budgetdata );
			} else {
				$budget->save ( $budgetdata );
				// 刪除原來的明細
				$budgetdetail->execute ( "DELETE FROM account_budget_detail WHERE budget=$budgetid" );
			}
			// 明細
			$details = $_POST ['budgetdetail'];
			if (! empty ( $details )) {
				foreach ( $details as $key => $value ) {
					$datas = explode ( ",", $value );
					$data ['subject'] = $datas [0];
					$data ['m1'] = $datas [1];
					$data ['m2'] = $datas [2];
					$data ['m3'] = $datas [3];
					$data ['m4'] = $datas [4];
					$data ['m5'] = $datas [5];
					$data ['m6'] = $datas [6];
					$data ['m7'] = $datas [7];
					$data ['m8'] = $datas [8];
					$data ['m9'] = $datas [9];
					$data ['m10'] = $datas [10];
					$data ['m11'] = $datas [11];
					$data ['m12'] = $datas [12];
					$data ['total'] = $datas [13];
					$data ['budget'] = $budgetid;
					$budgetdetail->add ( $data );
				}
			}
			$budget->commit ();
		} catch ( Exception $e ) {
			$budget->rollback ();
		}
		$this->budgetlist ();
	}
	function editBudget() {
		//$this->getAccount();
		$this->getDeparts();
		$bud=M ( 'account_budget' );
		$id = $_GET ['id'];
		$data=$bud->find($id);
		$this->assign('budget',$data);
		$details=$bud->query("SELECT * FROM account_budget_detail WHERE budget=$id");
		$this->assign('details',$details);
		$this->display('budgetEdit');
	}
	function viewBudget() {
		$bud=M ( 'account_budget' );
		$id = $_GET ['id'];
		$data=$bud->find($id);
		$this->assign('budget',$data);
		$details=$bud->query("SELECT * FROM account_budget_detail WHERE budget=$id");
		$this->assign('details',$details);
		$this->display('budgetView');
	}
	function deleteBudget() {
		$budget = M ( 'account_budget' );
		$id = $_GET ['id'];
		$budget->execute ( "DELETE FROM account_budget_detail WHERE budget=$id" );
		$budget->delete ( $id );
		$this->budgetlist ();
	}
	// -----------------------公共方法 ---------------------------------
	function getType() {
		$mt = M ( 'account_subject_type' );
		$datas = $mt->select ();
		$this->assign ( 'types', $datas );
	}
	function getAccount() {
		$mt = M ( 'account_id' );
		$datas = $mt->where ( "code = '$this->code'" )->select ();
		$this->assign ( 'accs', $datas );
	}
	function getChildType() {
		$ct = M ( 'account_subject_child_type' );
		$type = $_POST ['type'];
		$where = "type= $type  AND code = '$this->code'";
		$datas = $ct->where ( $where )->select ();
		echo json_encode ( $datas );
	}
	function getSubject() {
		$s = M ( 'account_subject' );
		$ct = $_POST ['ct'];
		$where = "ct= $ct  AND code = '$this->code'";
		$datas = $s->where ( $where )->select ();
		echo json_encode ( $datas );
	}
	function getManufacturer() {
		$sql = "select *,mname as name from stock_manufacturers where code ='$this->code' ";
		$s = new Model ();
		$datas = $s->query ( $sql );
		echo json_encode ( $datas );
	}
	function getClient() {
		$sql = "select *,mname as name from stock_manufacturers where code ='$this->code' ";
		$s = new Model ();
		$datas = $s->query ( $sql );
		echo json_encode ( $datas );
	}
	function getCase() {
		$sql = "select * from `case` where code ='$this->code' ";
		$s = new Model ();
		$datas = $s->query ( $sql );
		echo json_encode ( $datas );
	}
}
?>