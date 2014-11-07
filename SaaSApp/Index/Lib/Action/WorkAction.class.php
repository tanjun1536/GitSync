<?php
class WorkAction extends BaseAction {
	function index() {
		$sql = "SELECT 
			   w.`id`,
		  w.`code`,
		  w.`date`,
		  w.`remark`,
		  w.`status`,
		  w.`uid`,
		  w.`shour`,
		  w.`sminute`,
		  w.`ehour`,
		  w.`eminute`,
		  w.`overday`,
		  w.`typename`,
		  w.`description`,
		  w.`awoke` ,u.`ucode`,d.`id` depart,IFNULL(t.`name` ,w.typename) `type`
			FROM
			  `work` w 
			  INNER JOIN `user` u 
			    ON u.`id` = w.`uid` 
			   INNER JOIN depart d ON d.`id`=u.`depart`
			   LEFT JOIN `type` t ON t.`id`=w.`type`
			WHERE w.`code` = '$this->code' AND w.uid= $this->id ";
		$key = $this->getParam ( 'key' );
		$date=$this->getParam ( 'date' );
		$sdate = $this->getParam ( 'sdate' );
		$edate = $this->getParam ( 'edate' );
		if (! empty ( $key )) {
			$sql = $sql . " and w.status='" . $key . "'";
			$this->assign ( "key", $key );
		}
		else 
		{
			if($_SERVER['REQUEST_METHOD']=='GET')
			{
				$key='預定工作';
				$sql = $sql . " and w.status='" . $key . "'";
				$this->assign ( "key", $key );
			}
		}
		
		if (! empty ( $sdate )) {
			$sql = $sql . " and w.date>='" . $sdate . "'";
			$this->assign ( "sdate", $sdate );
		}
		if (! empty ( $edate )) {
			$sql = $sql . " and w.date<='" . $edate . " 23:59:59'";
			$this->assign ( "edate", $edate );
		}
		if (! empty ( $date )) {
			$sql = $sql . " and datediff(w.date,'$date')= 0" ;
		}
		$sql .= " ORDER BY w.date desc ";
		
		$this->onesql_page($sql);
// 		$list = $model->query ( $sql );
// 		$count = count ( $list );
// 		$p = $this->getPage ( $count );
// 		$page = $p->show ();
// 		if ($count > 0) {
// 			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
// 			$list = $model->query ( $sql );
// 		}
		parent::index ();
	}
	function cindex() {
		// 查询列表
		$model = new WorkViewModel ();
		import ( "ORG.Util.Page" );
		$depart = $this->getParam ( "depart" );
		if(empty($depart))
		{
			$depart=$this->getDepart();
		}
		$team = $this->getParam ( "team" );
		$users = $this->getParam ( "users" );
		$status = $this->getParam ( "status" );
		$sdate = $this->getParam ( 'sdate' );
		$edate = $this->getParam ( 'edate' );
		$sql = "SELECT 
			  w.* ,u.`ucode`,u.name uname,d.`id` depart,IFNULL(t.`name` ,w.typename) `type`
			FROM
			  `work` w 
			  INNER JOIN `user` u 
			    ON u.`id` = w.`uid` 
			   INNER JOIN depart d ON d.`id`=u.`depart`
			   LEFT JOIN `type` t ON t.`id`=w.`type`
			WHERE w.`code` = '$this->code' ";
		if (! empty ( $depart )) {
			$sql = $sql . " and u.depart='" . $depart . "'";
			$this->assign ( "selectDepart", $depart );
		}
		if (! empty ( $team )) {
			$sql = $sql . " and u.team='" . $team . "'";
			$this->assign ( "selectTeam", $team );
		}
		if (! empty ( $users )) {
			$sql = $sql . " and w.uid='" . $users . "'";
			$this->assign ( "selectUser", $users );
		}
		if (! empty ( $status )) {
			$sql = $sql . " and w.status='" . $status . "'";
			$this->assign ( "selectStatus", $status );
		}
		if (! empty ( $sdate )) {
			$sql = $sql . " and w.date>='" . $sdate . "'";
			$this->assign ( "sdate", $sdate );
		}
		if (! empty ( $edate )) {
			$sql = $sql . " and w.date<='" . $edate . " 23:59:59'";
			$this->assign ( "edate", $edate );
		}
		$sql .= "ORDER by w.date desc";
		$list = $model->query ( $sql );
		$count = count ( $list );
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $model->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
		// 部門
		$depart = new DepartModel ();
		$sql="SELECT DISTINCT * FROM ( SELECT * FROM depart WHERE leader=$this->id 
 UNION ALL SELECT * FROM depart WHERE id=(SELECT depart FROM `user` WHERE id=$this->id)) x";
		$departs = $depart->query($sql);
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function uindex() {
		// 查询列表
		$model = new WorkViewModel ();
		import ( "ORG.Util.Page" );
		$depart = $this->getParam ( "depart" );
		if(empty($depart))
		{
			$depart=$this->getDepart();
		}
		$team = $this->getParam ( "team" );
		if(empty($team))
		{
			$team=$this->getTeamId();
		}
		$users = $this->getParam ( "users" );
		$status = $this->getParam ( "status" );
		$sdate = $this->getParam ( 'sdate' );
		$edate = $this->getParam ( 'edate' );
		$sql = "SELECT 
			  w.* ,u.`ucode`,u.name uname,d.`id` depart,IFNULL(t.`name` ,w.typename) `type`
			FROM
			  `work` w 
			  INNER JOIN `user` u 
			    ON u.`id` = w.`uid` 
			   INNER JOIN depart d ON d.`id`=u.`depart`
			   LEFT JOIN `type` t ON t.`id`=w.`type`
			WHERE w.`code` = '$this->code' ";
		if (! empty ( $depart )) {
			$sql = $sql . " and d.depart='" . $depart . "'";
			$this->assign ( "selectDepart", $depart );
		}
		if (! empty ( $team )) {
			$sql = $sql . " and d.team='" . $team . "'";
			$this->assign ( "selectTeam", $team );
		}
		if (! empty ( $users )) {
			$sql = $sql . " and w.uid='" . $users . "'";
			$this->assign ( "selectUser", $users );
		}
		if (! empty ( $status )) {
			$sql = $sql . " and w.status='" . $status . "'";
			$this->assign ( "selectStatus", $status );
		}
		if (! empty ( $sdate )) {
			$sql = $sql . " and w.date>='" . $sdate . "'";
			$this->assign ( "sdate", $sdate );
		}
		if (! empty ( $edate )) {
			$sql = $sql . " and w.date<='" . $edate . " 23:59:59'";
			$this->assign ( "edate", $edate );
		}
		$sql .= "ORDER by w.id desc";
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
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function add() {
		$typeModel = new TypeModel ();
		$typeList = $typeModel->selectByCode ();
		$phraseModel = new PhraseModel ();
		$phraseList = $phraseModel->selectByCode ();
		$this->assign ( "type", $typeList );
		$this->assign ( "phrase", $phraseList );
		parent::add ();
	}
	function insert() {
		$model = new WorkModel ();
		try {
			$data = $model->create ();
			if (! empty ( $data ['id'] )) {
				$ret = $model->save ( $data );
				$this->checkExcept ( $ret );
			} else {
				$ret = $model->add ( $data );
				$this->checkExcept ( $ret );
			}
			$model->commit ();
		} catch ( Exception $e ) {
			$model->rollback ();
			$this->ShowMessage ( $e->getMessage () );
		}
		$this->index ();
	}
	function changeState() {
		$status = $_POST ['status'];
		$ids = $_POST ["itemcheckbox"];
		$model = new WorkModel ();
		if ($status == '修改工作') {
			$id = $ids [0];
			if (! empty ( $id )) {
				$data = $model->find ( $id );
				$this->assign ( 'work', $data );
				$this->add ();
			}
		} else {
			$where = implode ( ",", $ids );
			$data ['status'] = $status;
			$model->where ( "id in (" . $where . ")" )->save ( $data );
			$this->index ();
		}
	}
	function view() {
		$id = $_GET ['id'];
		$sql="SELECT 
		  w.`id`,
		  w.`code`,
		  w.`date`,
		  w.`remark`,
		  w.`status`,
		  w.`uid`,
		  w.`shour`,
		  w.`sminute`,
		  w.`ehour`,
		  w.`eminute`,
		  w.`overday`,
		  w.`type`,
		  w.`typename`,
		  w.`description`,
		  w.`awoke`,
		  u.`name` uname 
		FROM
		  `work` w 
		  INNER JOIN `user` u 
		    ON w.`uid` = u.`id` 
		WHERE w.id = $id ";
		$model = new Model ();
		$work = $model->query($sql);
		$data ['id'] = $id;
		$data ['awoke'] = 0;
		$model->save ( $data );
		$this->getRemind ();
		$this->assign ( 'work', $work[0] );
		parent::view ();
	}
	function getRemind() {
		$model = new WorkModel ();
		$where = $this->getWhere ();
		$where = $where . " and awoke =1";
		$where = $where . " and uid =" . $this->getId ();
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
		$count = $model->where ( $where )->count ();
		$_SESSION [C ( "AWOKE_WORK_KEY" )] = $count;
	}
}
?>