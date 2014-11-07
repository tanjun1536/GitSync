<?php
class IndexAction extends Action {
	public function index() {
		$username = $_POST ['username'];
		$password = $_POST ['pwd'];
		if (! empty ( $username )) {
			$user = new UserModel ();
			$data = $user->getByUsername ( $username );
			if (! empty ( $data ) && $data ['password'] == $password && $data ['isonduty']==1) {
				//设置默认样式
				$_SESSION['style']='blue';
				
				$_SESSION [C ( "USER_SESSION_KEY" )] = $data;
				// 查詢信息
				$this->getMsg ( $data );
				// 查詢提醒
				$this->getRemind ( $data );
				// 查询交办
				$this->getWorkMsg ( $data );
				// 查询菜单
				$this->getUserMenu ( $data );
				$this->redirect('Msg/index' );
			} else
				$this->display ();
		} else
			$this->display ();
	}
	public function logout() {
		unset( $_SESSION ["exts"] );
		unset(  $_SESSION ["LeftMenu"] );
		unset( $_SESSION ["TopMenu"] );
		unset( $_SESSION ["CaseMenu"] );
		unset ( $_SESSION [C ( "USER_SESSION_KEY" )] );
		unset ( $_SESSION [C ( "MSG_COMM_KEY" )] );
		unset ( $_SESSION [C ( "MSG_WORK_KEY" )] );
		unset ( $_SESSION ["Menu"] );
		$this->display ( 'index' );
	}
	public function mainPage() {
		$this->display ( 'work_list' );
	}
	function getMsg($data) {
		$model = new MsgModel ();
		$code=$data ['code'];
		$id=$data ['id'];
		$sql = "SELECT COUNT(*) as C FROM (SELECT
		m.id,IFNULL(mr.readerid,0) isread
		FROM
		msg m LEFT JOIN msgreader mr ON m.`id`=mr.`msgid` AND mr.`readerid`=$id
		WHERE INSTR(
				CONCAT(',', m.receiversid, ','),
				CONCAT(',', $id, ',')
		) > 0 AND m.code = $code) z WHERE z.isread =0";
		$count = $model->query($sql);
		$_SESSION [C ( "MSG_COMM_KEY" )] = $count[0]['C'];
		$x=$_SESSION [C ( "MSG_COMM_KEY" )];
		
	}
	function getRemind($data) {
		$model = new WorkModel ();
		$where = "code='" . $data ['code'] . "'";
		$where = $where . " and awoke =1";
		$where = $where . " and uid =" . $data ['id'];
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
	function getWorkMsg($data) {
		$model = new MsgworkModel ();
		$where = "code='" . $data ['code'] . "'";
		$where = $where . " and issenderread =0";
		$where = $where . " and senderid =" . $data ['id'];
		$count = $model->where ( $where )->count ();
		$_SESSION ["MSG_MINE_WORK"] = $count;
		$where = "code='" . $data ['code'] . "'";
		$where = $where . " and isreceiverread =0";
		$where = $where . " and receiverid =" . $data ['id'];
		$count = $model->where ( $where )->count ();
		$_SESSION ["MSG_OTHER_WORK"] = $count;
	}
	function getUserMenu($data) {
		$M = new Model ();
		$roleId = $data ['role'];
		$sql = "SELECT m.id,m.`name`,m.`parent_id`,m.`link`,m.`image`,m.`target`,rm.`ext` FROM menu m INNER JOIN role_menu rm ON m.`id`=rm.`mid` WHERE m.parent_id is NULL and pos=1 and rm.`rid`=$roleId";
		$data = $M->query ( $sql );
		foreach ( $data as $key => $value ) {
			$pid = $value ['id'];
			$sql = "SELECT m.id,m.`name`,m.`parent_id`,m.`link`,m.`image`,m.`target`,rm.`ext` FROM menu m INNER JOIN role_menu rm ON m.`id`=rm.`mid` WHERE m.parent_id=$pid and rm.`rid`=$roleId order by ordernumber,id";
			$data [$key] ['children'] = $M->query ( $sql );
		}
		$_SESSION ["LeftMenu"] = $data;
		$this->assign ( "LeftMenu", $_SESSION ["LeftMenu"] );
		
		$sql = "SELECT m.id,m.`name`,m.`parent_id`,m.`link`,m.`image`,m.`target`,rm.`ext` FROM menu m INNER JOIN role_menu rm ON m.`id`=rm.`mid` WHERE m.parent_id is NULL and pos=0 and rm.`rid`=$roleId";
		$data = $M->query ( $sql );
		foreach ( $data as $key => $value ) {
			$pid = $value ['id'];
			$sql = "SELECT m.id,m.`name`,m.`parent_id`,m.`link`,m.`image`,m.`target`,rm.`ext` FROM menu m INNER JOIN role_menu rm ON m.`id`=rm.`mid` WHERE m.parent_id=$pid and rm.`rid`=$roleId order by ordernumber,id";
			$data [$key] ['children'] = $M->query ( $sql );
		}
		$_SESSION ["TopMenu"] = $data;
		$this->assign ( "TopMenu", $_SESSION ["TopMenu"] );
		$sql = "SELECT m.id,m.`name`,m.`parent_id`,m.`link`,m.`image`,m.`target`,rm.`ext` FROM menu m INNER JOIN role_menu rm ON m.`id`=rm.`mid` WHERE m.parent_id is NULL and (pos=2 OR m.name='專案管理') and rm.`rid`=$roleId";
		$data = $M->query ( $sql );
		foreach ( $data as $key => $value ) {
			$pid = $value ['id'];
			$sql = "SELECT m.id,m.`name`,m.`parent_id`,m.`link`,m.`image`,m.`target`,rm.`ext` FROM menu m INNER JOIN role_menu rm ON m.`id`=rm.`mid` WHERE m.parent_id=$pid and rm.`rid`=$roleId order by ordernumber,id";
			$data [$key] ['children'] = $M->query ( $sql );
		}
		$_SESSION ["CaseMenu"] = $data;
		$this->assign ( "CaseMenu", $_SESSION ["CaseMenu"] );
		// print_r($_SESSION["Menu"]);
	}
	function ChangeStyle()
	{
		$style=$_GET['style'];
		$_SESSION['style']=$style;
		$url=$_SERVER['HTTP_REFERER'] ;
		$url=substr($url, strpos($url, ".php/")+4);
		$this->redirect($url);
	}
}
?>