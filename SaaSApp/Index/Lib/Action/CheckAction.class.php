<?php
class CheckAction extends BaseAction {
	function index() {
		$sdate = $this->getParam('sdate');
		$edate = $this->getParam('edate');
		$csql="select COUNT(*) from `check` WHERE ";
		$dsql="select *,TIMEDIFF(downtime,ontime) difftime from `check` WHERE ";
		$where = $this->getWhere ();
		$where = $where . " and uid=" . $this->getId ();
		if (! empty ( $sdate ))
		{
			$where = $where . " and date>='" . $sdate . "'";
			$this->assign("sdate",$sdate);
		}
		if (! empty ( $edate ))
		{
			$where = $where . " and date<='" . $edate . " 23:59:59'";
			$this->assign("edate",$edate);
		}
		$this->page($csql.$where, $dsql.$where." order by id desc ");
		parent::index ();
	}
	function getState($onOrdown) {
		$hour = date ( 'H' );
		$minute = date ( 'i' );
		if ($onOrdown == 'on') // 如果是上班时间必须小于公司设定的开始上班时间
			$sql = "SELECT * FROM company  WHERE CONCAT(onhour,onminute)>'" . $hour . $minute . "' AND code='" . $this->getCode () . "'";
		else // 如果是上班时间必须大于公司设定的开始下班时间
			$sql = "SELECT * FROM company  WHERE CONCAT(downhour,downminute)<'" . $hour . $minute . "' AND code='" . $this->getCode () . "'";
		$model = new Model ();
		
		$data = $model->query ( $sql );
		
		if (count ( $data ) > 0)
			return "正常";
		else
			return "異常";
	}
	function insert() {
		$af = $_POST ['af'];
		$c = new CheckModel ();
		// 判断当天是否有打卡
		$where = "type='" . $_POST ['type'] . "' and DATEDIFF(date,'" . date ( 'Y-m-d' ) . "')=0 and  uid=" . $this->getId ();
		$data = $c->where ( $where )->find ();
		/*
		 * 1、必须先打上班卡 2、打了下班卡可以再打卡 3、主管代打
		 */
		
		if ($data) 		// 如果已经有当天的打卡记录就更新
		{
			// 如果打了上班卡且大了下班
			$down = false;
			$on = false;
			
			if (! empty ( $data ['downtime'] )) {
				$down = true;
			}
			if (! empty ( $data ['ontime'] )) {
				$on = true;
			}
			
			if ($af == 'on') 			// 上班
			{
				if ($down) 				// 如果打了下班卡
				{
					$data = $c->create ();
					$data ['uid'] = $this->getId ();
					$data ['status'] = $this->getState ( $af );
					$data ['ontime'] = date ( 'Y-m-d H:i:s' );
					$c->add ( $data );
				} else {
					$this->ShowMessage ( "沒打下班卡不允許再打上班卡!" );
				}
			} else { // 下班
			         // 如没打上班卡则不行
				if ($on) 				// 打了上班卡
				{
					if (! $down) {
						$data ['status'] = $this->getState ( $af );
						$data ['downtime'] = date ( 'Y-m-d H:i:s' );
						$c->save ( $data );
					} else {
						$this->ShowMessage ( "已經打了下班卡了!" );
					}
				} else {
					$this->ShowMessage ( "没有打上班卡不允許打下班卡!" );
				}
			}
		} else {
			// 还没打卡
			// 先打上班卡
			$data = $c->create ();
			$data ['uid'] = $this->getId ();
			$data ['status'] = $this->getState ( $af );
			if ($af == 'on') 			// 上班
			{
				$data ['ontime'] = date ( 'Y-m-d H:i:s' );
				$c->add ( $data );
			} else { // 下班
				//当当天没有打卡数据的时候就查询最后一次打开，看看最后一次打上班卡的时间和现在的时间相差是否小于24小时。 20130910修改
				$where = "type='" . $_POST ['type'] . "' and id =(select max(id) from `check` where uid=" . $this->getId ().")";
				$data = $c->where ( $where )->find ();
				
				$hours=abs(strtotime(date ( 'Y-m-d H:i:s' ))-strtotime($data['ontime']))/3600;
				
				if($hours<24)
				{
					$data ['status'] = $this->getState ( $af );
					$data ['downtime'] = date ( 'Y-m-d H:i:s' );
					$c->save ( $data );				}
				else
				{
					$this->ShowMessage ( "没有打上班卡不允許打下班卡!" );
				}
			}
		}
		$this->index ();
	}
	function depart() {
		// 导入分页类库
		import ( "ORG.Util.Page" );
		// 根据登录者的id查询部门下的人
		$sql = "SELECT * FROM user WHERE depart=(SELECT depart FROM user WHERE id=" . $this->getId () . ")";
		$model = new Model ();
		$list = $model->query ( $sql );
		$this->assign ( "list", $list );
		// 查询所有部门
		$sql = "select * from depart where `code` = '$this->code'";
		$departs = $model->query ( $sql );
		$this->assign ( "departs", $departs );
		// 查询出勤记录
		$sql = "SELECT c.*,TIMEDIFF(c.downtime,c.ontime) difftime,u.id as userid,u.`name`,u.`ucode` FROM `check` c INNER JOIN `user`  u ON c.`uid`=u.`id` WHERE 1=1 ";
		$sdate = $this->getParam('sdate'); 
		$edate =$this->getParam('edate'); 
		$depart = $this->getParam('depart');
		$team=$this->getParam('team');
		if (! empty ( $sdate ))
		{
			$sql = $sql . " and c.date>='" . $sdate . "'";
			$this->assign("sdate",$sdate);
		}
		if (! empty ( $edate ))
		{
			$sql = $sql . " and c.date<='" . $edate . " 23:59:59'";
			$this->assign("edate",$edate);
		}
		if (! empty ( $depart ))
		{
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		else {
			$depart=$this->getDepart();
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		if (! empty ( $team ))
		{
			$sql = $sql . " and u.team=" . $team;
			$this->assign("team",$team);
		}
		
		$checks = $model->query ( $sql );
		$count = count ( $checks );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " order by c.id desc  limit " . $p->firstRow . ',' . $p->listRows;
			$checks = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $checks );
		$this->display ( 'depart' );
	}
	function exportCheckDepart()
	{
		// 查询出勤记录
		$sql = "SELECT c.type,CONCAT(u.`name`,'(',u.ucode,')') uname,c.`ontime`,c.`downtime`, TIMEDIFF(c.downtime,c.ontime) difftime FROM `check` c INNER JOIN `user`  u ON c.`uid`=u.`id` WHERE 1=1 ";
		$sdate = $_POST ['sdate'];
		$edate = $_POST ['edate'];
		$depart = $_POST ['depart'];
		$team=$_POST['team'];
		if (! empty ( $sdate ))
		{
			$sql = $sql . " and c.date>='" . $sdate . "'";
			$this->assign("sdate",$sdate);
		}
		if (! empty ( $edate ))
		{
			$sql = $sql . " and c.date<='" . $edate . " 23:59:59'";
			$this->assign("edate",$edate);
		}
		if (! empty ( $depart ))
		{
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		else {
			$depart=$this->getDepart();
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		if (! empty ( $team ))
		{
			$sql = $sql . " and u.team=" . $team;
			$this->assign("team",$team);
		}
		$model = new Model ();
		$list = $model->query ( $sql );
		$headers="類型,姓名,上班時間,下班時間,時數";
		$downName="部門出勤";
		$this->cvsDown($list, $headers, $downName);
	}
	function unit() {
		// 导入分页类库
		import ( "ORG.Util.Page" );
		// 根据登录者的id查询部门下的人
		$sql = "SELECT * FROM user WHERE depart=(SELECT depart FROM user WHERE id=" . $this->getId () . ")";
		$model = new Model ();
		$list = $model->query ( $sql );
		$this->assign ( "list", $list );
		// 查询所有部门
		$sql = "select * from depart where `code` = '$this->code'";
		$departs = $model->query ( $sql );
		$this->assign ( "departs", $departs );
		// 查询出勤记录
		$sql = "SELECT c.*,TIMEDIFF(c.downtime,c.ontime) difftime,u.id as userid,u.`name`,u.`ucode` FROM `check` c INNER JOIN `user`  u ON c.`uid`=u.`id` WHERE 1=1 ";
		$sdate = $this->getParam('sdate');
		$edate = $this->getParam('edate');
		$depart =$this->getParam('depart');
		$team=$this->getParam('team');
		if(empty($team))
		{
			$team=$this->getTeamId();
		}
		if (! empty ( $sdate ))
		{
			$sql = $sql . " and c.date>='" . $sdate . "'";
			$this->assign("sdate",$sdate);
		}
		if (! empty ( $edate ))
		{
			$sql = $sql . " and c.date<='" . $edate . " 23:59:59'";
			$this->assign("edate",$edate);
		}
		if (! empty ( $depart ))
		{
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		else {
			$depart=$this->getDepart();
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		if (! empty ( $team ))
		{
			$sql = $sql . " and u.team=" . $team;
			$this->assign("team",$team);
		}
	
		$checks = $model->query ( $sql );
		$count = count ( $checks );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " order by c.id desc  limit " . $p->firstRow . ',' . $p->listRows;
			$checks = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $checks );
		$this->display ( 'unit' );
	}
	function exportCheckUnit()
	{
		// 查询出勤记录
		$sql = "SELECT c.type,CONCAT(u.`name`,'(',u.ucode,')') uname,c.`ontime`,c.`downtime`, TIMEDIFF(c.downtime,c.ontime) difftime FROM `check` c INNER JOIN `user`  u ON c.`uid`=u.`id` WHERE 1=1 ";
		$sdate = $_POST ['sdate'];
		$edate = $_POST ['edate'];
		$depart = $_POST ['depart'];
		$team=$_POST['team'];
		if(empty($team))
		{
			$team=$this->getTeamId();
		}
		if (! empty ( $sdate ))
		{
			$sql = $sql . " and c.date>='" . $sdate . "'";
			$this->assign("sdate",$sdate);
		}
		if (! empty ( $edate ))
		{
			$sql = $sql . " and c.date<='" . $edate . " 23:59:59'";
			$this->assign("edate",$edate);
		}
		if (! empty ( $depart ))
		{
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		else {
			$depart=$this->getDepart();
			$sql = $sql . " and u.depart=" . $depart;
			$this->assign("depart",$depart);
		}
		if (! empty ( $team ))
		{
			$sql = $sql . " and u.team=" . $team;
			$this->assign("team",$team);
		}
		$model = new Model ();
		$list = $model->query ( $sql );
		$headers="類型,姓名,上班時間,下班時間,時數";
		$downName="單位出勤";
		$this->cvsDown($list, $headers, $downName);
	}
	function manageInsert() {
		$af = $_POST ['af'];
		$user = $_POST ['user'];
		$c = new CheckModel ();
		try {
			$c->startTrans ();
			if ($user == 'all') { // 如果是为所有同事打卡
				$sql = "SELECT * FROM USER WHERE depart=(SELECT depart FROM USER WHERE id=" . $this->getId () . ")";
				$model = new Model ();
				$list = $model->query ( $sql );
				foreach ( $list as $key => $value ) {
					$data = $c->where ( "type='" . $_POST ['type'] . "' and DATEDIFF(date,'" . date ( 'Y-m-d' ) . "')=0 and uid=" . $value ['id'] )->find ();
					if ($data) 					// 如果已经有当天的打卡记录就更新
					{
						if ($af == 'on') 						// 上班
						{
							$data ['ontime'] = date ( 'H:i:s' );
						} else { // 下班
							$data ['downtime'] = date ( 'H:i:s' );
						}
						$data ['status'] = $this->getState ( $af );
						$c->save ( $data );
					} else {
						$data = $c->create ();
						$data ['uid'] = $value ['id'];
						if ($af == 'on') 						// 上班
						{
							$data ['ontime'] = date ( 'H:i:s' );
						} else { // 下班
							$data ['downtime'] = date ( 'H:i:s' );
						}
						$data ['status'] = $this->getState ( $af );
						$c->add ( $data );
					}
				}
			} else {
				$data = $c->where ( "type='" . $_POST ['type'] . "' and DATEDIFF(date,'" . date ( 'Y-m-d' ) . "')=0 and uid=" . $user )->find ();
				if ($data) 				// 如果已经有当天的打卡记录就更新
				{
					if ($af == 'on') 					// 上班
					{
						$data ['ontime'] = date ( 'H:i:s' );
					} else { // 下班
						$data ['downtime'] = date ( 'H:i:s' );
					}
					$data ['status'] = $this->getState ( $af );
					$c->save ( $data );
				} else {
					$data = $c->create ();
					$data ['uid'] = $user;
					if ($af == 'on') 					// 上班
					{
						$data ['ontime'] = date ( 'H:i:s' );
					} else { // 下班
						$data ['downtime'] = date ( 'H:i:s' );
					}
					$data ['status'] = $this->getState ( $af );
					$c->add ( $data );
				}
			}
			$c->commit ();
		} catch ( Exception $e ) {
			$c->rollback ();
		}
		$this->manage ();
	}
	function viewperson() {
		$pid = $this->getParam("pid");
		$this->assign("pid",$pid);
		// 导入分页类库
		import ( "ORG.Util.Page" );
		$model = new Model ();
		// 查询出勤记录
		$sql = "SELECT c.*,TIMEDIFF(c.downtime,c.ontime) difftime,u.`name`,u.`ucode` FROM `check` c INNER JOIN `user`  u ON c.`uid`=u.`id` WHERE 1=1 ";
		$sql = $sql . " and u.id=" . $pid;
		$sdate = $this->getParam("sdate");
		$edate = $this->getParam("edate");
		if (! empty ( $sdate ))
		{
			$sql = $sql . " and c.date>='" . $sdate . "'";
			$this->assign("sdate",$sdate);
		}
		if (! empty ( $edate ))
		{
			
			$sql = $sql . " and c.date<='" . $edate . " 23:59:59'";
			$this->assign("edate",$edate);
		}
		
		$checks = $model->query ( $sql );
		$count = count ( $checks );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " order by c.date desc limit " . $p->firstRow . ',' . $p->listRows;
			$checks = $model->query ( $sql );
		}
		$this->assign ( "page", $page );
		$this->assign ( "list", $checks );
		$this->display ();
	}
	function delegate() {
		$team = new Model ( 'team' );
		$teams = $team->where ( "depart=" . $this->getDepart () )->select ();
		$this->assign ( "teams", $teams );
		
		$date = $this->getParam ( 'date' );
		if (empty ( $date )) {
			$date = date ( 'Y-m-d' );
		}
		$this->assign ( 'date', $date );
		$teamid = $this->getParam ( 'team' );
		
		$dsql = "SELECT 
			  '$date' AS 'datetime',
			  u.`id` uid,c.`id` cid,
			  u.`ucode`,
			  u.`name`,
			  c.`ontime`,
			  c.`downtime`,
			  TIMEDIFF(c.downtime,c.ontime) difftime,
			  c.`type`,
			  c.`status`,
			  c.`overday`
			FROM
			  `user` u 
			  LEFT JOIN `check` c 
			    ON u.`id` = c.`uid` 
			    AND DATEDIFF(c.`date`, '$date') = 0 
			WHERE u.depart =" . $this->getDepart ();
		$csql = "SELECT 
			  COUNT(*)
			FROM
			  `user` u 
			  LEFT JOIN `check` c 
			    ON u.`id` = c.`uid` 
			    AND DATEDIFF(c.`date`, '$date') = 0 
			WHERE u.depart =" . $this->getDepart ();
		if (! empty ( $teamid )) {
			$csql .= " and u.team= $teamid";
			$dsql .= " and u.team= $teamid";
			$this->assign ( 'team', $teamid );
		}
		else
		{
			$teamid=$this->getTeamId();
			$csql .= " and u.team= $teamid";
			$dsql .= " and u.team= $teamid";
			$this->assign ( 'team', $teamid );
		}
		$this->page ( $csql, $dsql );
		$this->display ( 'delegate' );
	}
	function addDelegate() {
		$c = M ( 'check' );
		$data = $c->create ();
		$data['code']=$this->getCode();
		$items = $_POST ['checkboxitems'];
		$ontime =date('Y-m-d')." ". $_POST ['onhour'] . ":" . $_POST ['onminute'] . ":00";
		$downtime = date('Y-m-d')." ".$_POST ['downhour'] . ":" . $_POST ['downminute'] . ":00";
		$data ['status'] = '正常';
		$data ['ontime'] = $ontime;
		$data ['downtime'] = $downtime;
		$data ['overday'] = empty ( $_POST ['overday'] ) ? 0 : 1;
		try {
			$c->startTrans ();
			if (! empty ( $items )) {
				foreach ( $items as $v ) {
					$uc = explode ( ',', $v );
					$uid = $uc [0];
					$cid = $uc [1];
					$data ['uid'] = $uid;
					if (empty ( $cid )) 					// 如果checkid為空表示沒有打卡
					{
						$ret = $c->add ( $data );
					} else {
						$data['id']=$cid;
						$ret = $c->save ( $data );
					}
					$this->checkExcept ( $ret );
				}
			}
			$c->commit ();
		} catch ( Exception $e ) {
			$c->rollback ();
			$this->ShowMessage($e->getMessage());
		}
		$this->redirect('delegate');
	}
}
?>