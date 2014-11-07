<?php
class UserAction extends BaseAction {
	function index() {
		$key = $_POST ["skey"];
		$depart = $_POST ["sdepart"];
		$team = $_POST ["steam"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$csql = "SELECT COUNT(*) FROM `user` u left JOIN depart d
				ON u.`depart`=d.`id`
				left JOIN team t
				ON u.`team`=t.`id`
						";
		$dsql = "SELECT u.*,d.`name` dname ,t.`name` tname FROM `user` u left JOIN depart d
				ON u.`depart`=d.`id`
				left JOIN team t
				ON u.`team`=t.`id`
						";
		$where = $this->getWhere ();
		if (! empty ( $key )) {
			$where = $where . " and u.name like '%" . $key . "%'";
			$this->assign ( "username", $key );
		}
		if (! empty ( $depart )) {
			$where = $where . " and u.depart = $depart";
			$this->assign ( "depart", $depart );
		}
		if (! empty ( $team )) {
			$where = $where . " and u.team = $team";
			$this->assign ( "team", $team );
		}
		if (strtolower($_SERVER['REQUEST_METHOD'])  == 'post') {
			$_SESSION ['where'] = $where;
		} else {
			$where = $_SESSION ['where'];
		}
		
		$csql .= " WHERE u." . $where;
		$dsql .= " WHERE u." . $where;
		$this->page ( $csql, $dsql );
		$this->getDeparts ();
		parent::index ();
	}
	function add() {
		// 流水號
		$linecode = getUserLineCode ( $this->getCode () );
		$this->assign ( "linecode", $linecode );
		// 城市下來列表
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		// 級別
		$level = new LevelModel ();
		$levels = $level->selectByCode ();
		$this->assign ( "levels", $levels );
		// 權限
		$role = new RoleModel ();
		$roles = $role->selectByCode ();
		$this->assign ( "roles", $roles );
		parent::add ();
	}
	function insert() {
		$user = new UserModel ();
		try {
			$user->startTrans ();
			$data = $user->create ();
			// println($_POST['level']);
			$data ['level'] = implode ( ",", $_POST ['level'] );
			$userId = $user->add ( $data );
			$this->addOthers ( $userId );
			$user->commit ();
			$this->index ();
		} catch ( Exception $e ) {
			$user->rollback ();
		}
	}
	/**
	 *
	 * @param
	 *        	userId
	 */
	private function addOthers($userId) {
		// 添加经历
		$experiences = $_POST ['experience'];
		if (! empty ( $experiences )) {
			foreach ( $experiences as $key => $value ) {
				$datas = explode ( ",", $value );
				$exp = M ( 'experience' );
				$data ['companyname'] = $datas [0];
				$data ['duty'] = $datas [1];
				$data ['sdate'] = $datas [2];
				$data ['edate'] = $datas [3];
				$data ['salary'] = $datas [4];
				$data ['uid'] = $userId;
				$exp->add ( $data );
			}
		}
		// 添加学历
		$educations = $_POST ['education'];
		if (! empty ( $educations )) {
			foreach ( $educations as $key => $value ) {
				$datas = explode ( ",", $value );
				$edu = M ( 'education' );
				$data ['school'] = $datas [0];
				$data ['specialty'] = $datas [1];
				$data ['educational'] = $datas [2];
				$data ['sdate'] = $datas [3];
				$data ['edate'] = $datas [4];
				$data ['status'] = $datas [5];
				$data ['uid'] = $userId;
				$edu->add ( $data );
			}
		}
		// 添加证照
		$certificates = $_POST ['certificate'];
		if (! empty ( $certificates )) {
			foreach ( $certificates as $key => $value ) {
				$datas = explode ( ",", $value );
				$cer = M ( 'certificate' );
				$data ['name'] = $datas [0];
				$data ['date'] = $datas [1];
				$data ['sdate'] = $datas [2];
				$data ['edate'] = $datas [3];
				$data ['atts'] = $datas [4];
				$data ['remark'] = $datas [5];
				$data ['uid'] = $userId;
				$cer->add ( $data );
			}
		}
		// 添加专长
		$skills = $_POST ['skill'];
		if (! empty ( $skills )) {
			foreach ( $skills as $key => $value ) {
				$datas = explode ( ",", $value );
				$skill = M ( 'skill' );
				$data ['name'] = $datas [0];
				$data ['grade'] = $datas [1];
				$data ['remark'] = $datas [2];
				$data ['uid'] = $userId;
				$skill->add ( $data );
			}
		}
		// 添加家庭
		$families = $_POST ['family'];
		if (! empty ( $families )) {
			foreach ( $families as $key => $value ) {
				$datas = explode ( ",", $value );
				$fam = M ( 'family' );
				$data ['name'] = $datas [0];
				$data ['duty'] = $datas [1];
				$data ['birth'] = $datas [2];
				$data ['relation'] = $datas [3];
				$data ['uid'] = $userId;
				$fam->add ( $data );
			}
		}
	}
	function edit() {
		$id = $_GET ["id"];
		if(empty($id))
			$id=$this->getId();
		$user = new UserModel ();
		$data = $user->relation ( true )->find ( $id );
		$this->assign ( "user", $data );
		// 城市下來列表
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		// 級別
		$level = new LevelModel ();
		$levels = $level->selectByCode ();
		$this->assign ( "levels", $levels );
		// 權限
		$role = new RoleModel ();
		$roles = $role->selectByCode ();
		$this->assign ( "roles", $roles );
		parent::edit ();
	}
	function checkUser() {
		$name = $_POST ["username"];
		$user = new UserModel ();
		$cond ['username'] = $name;
		$cond ['code'] = $this->getCode ();
		$data = $user->where ( $cond )->select ();
		if (empty ( $data ))
			echo parent::$SUCCESS;
		else
			echo parent::$FAIL;
	}
	function checkCode() {
		$ucode = $_POST ["ucode"];
		$user = new UserModel ();
		$cond ['ucode'] = $ucode;
		$cond ['code'] = $this->getCode ();
		$data = $user->where ( $cond )->select ();
		if (empty ( $data ))
			echo parent::$SUCCESS;
		else
			echo parent::$FAIL;
	}
	function update() {
		$user = new UserModel ();
		try {
			$user->startTrans ();
			$data = $user->create ();
			import ( "ORG.Net.UploadFile" );
			$up = new UploadFile ();
			$up->savePath = ATTCHEMENT_PATH_HEADIMAGE;
			$up->thumb = true;
			$up->thumbMaxHeight = "100";
			$up->thumbMaxWidth = "100";
			$up->saveRule = time ();
			$up->allowExts = array (
					'jpg',
					'gif',
					'png',
					'jpeg'
			);
			$user = new UserModel ();
			$data = $user->create ();
			if ($up->upload ()) {
				$image = $up->getUploadFileInfo ();
				$data ['userimage'] = $image [0] ["savename"];
			}
			$data ['level'] = implode ( ",", $_POST ['level'] );
			$user->save ( $data );
			$this->deleteOthers ( $user, $data ['id'] );
			$this->addOthers ( $data ['id'] );
			$user->commit ();
			// $url = $_SERVER ['HTTP_REFERER'];
			// $url = substr ( $url, strpos ( $url, ".php/" ) + 4 );
			// $this->redirect ( $url );
			$this->redirect ( 'index' );
		} catch ( Exception $e ) {
			$user->rollback ();
		}
	}
	function delete() {
		$user = new UserModel ();
		$id = $_GET ["id"];
		try {
			$user->startTrans ();
			$this->deleteOthers ( $user, $id );
			
			$user->delete ( $id );
			$user->commit ();
			$this->index ();
		} catch ( Exception $e ) {
			$user->rollback ();
		}
	}
	/**
	 *
	 * @param
	 *        	user
	 */
	private function deleteOthers($user, $id) {
		$user->execute ( "delete from experience where uid=" . $id );
		$user->execute ( "delete from education where uid=" . $id );
		$user->execute ( "delete from skill where uid=" . $id );
		$user->execute ( "delete from certificate where uid=" . $id );
		$user->execute ( "delete from family where uid=" . $id );
	}
	function profile() {
		$id = $this->getId ();
		$user = new UserModel ();
		$data = $user->relation ( true )->find ( $id );
		$this->assign ( "user", $data );
		// 城市下來列表
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
		// 查詢部門
		$depart = M ( 'depart' );
		$dept = $depart->getById ( $data ["depart"] );
		$this->assign ( "departName", $dept ["name"] );
		//是否可以辩解
		$canedit=$_GET['canedit'];
		$this->assign("canedit",$canedit);
		$this->display ( 'profile' );
	}
	function updateProfile() {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_HEADIMAGE;
		$up->thumb = true;
		$up->thumbMaxHeight = "100";
		$up->thumbMaxWidth = "100";
		$up->saveRule = time ();
		$up->allowExts = array (
				'jpg',
				'gif',
				'png',
				'jpeg' 
		);
		$user = new UserModel ();
		$data = $user->create ();
		if ($up->upload ()) {
			$image = $up->getUploadFileInfo ();
			$data ['userimage'] = $image [0] ["savename"];
			$sessionUser = $this->getUser ();
			$sessionUser ['userimage'] = $data ['userimage'];
			$this->setUser ( $sessionUser );
		} else {
			echo $up->getErrorMsg ();
		}
		$user->save ( $data );
		$this->profile ();
	}
	function friend() {
		$depart = $_GET ["depart"];
		$team = $_GET ["team"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		if (! empty ( $depart )) {
			$this->assign ( "depart", $depart );
			$where = $where . " and depart=" . $depart;
		}
		if (! empty ( $team )) {
			$this->assign ( "team", $team );
			$where = $where . " and team=" . $team;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function limit() {
		$role = $_GET ["role"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = $this->getWhere ();
		if (! empty ( $role )) {
			$this->assign ( "R", $role );
			$where = $where . " and role=" . $role;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		// 部門
		$RM = new RoleModel ();
		$roles = $RM->selectByCode ();
		$this->assign ( "roles", $roles );
		$this->display ();
	}
	function friendcheckbox() {
		$selUsers = $_GET ['selUsers'];
		if (! empty ( $selUsers ))
			$this->assign ( "selUsers", $selUsers );
		$depart = $_GET ["depart"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = "";
		if (! empty ( $depart )) {
			$this->assign ( "depart", $depart );
			$where = $where . "  depart=" . $depart;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function usercheckbox() {
		$id = $_GET ['id'];
		if (! empty ( $id ))
			$this->assign ( "id", $id );
		$name = $_GET ['name'];
		if (! empty ( $name ))
			$this->assign ( "name", $name );
		$selUsers = $_GET ['selUsers'];
		if (! empty ( $selUsers ))
			$this->assign ( "selUsers", $selUsers );
		$depart = $_GET ["depart"];
		$team = $_GET ["team"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = "";
		if (! empty ( $depart )) {
			$this->assign ( "depart", $depart );
			$where = $where . "  depart=" . $depart;
		}
		if (! empty ( $team )) {
			$this->assign ( "team", $team );
			$where = $where . " AND team=" . $team;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->select ();
		// $list = $model->where ( $where )->order ( 'id desc' )->limit (
		// $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function friendnocheckbox() {
		$selUsers = $_GET ['selUsers'];
		if (! empty ( $selUsers ))
			$this->assign ( "selUsers", $selUsers );
		$depart = $_GET ["depart"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = "";
		if (! empty ( $depart )) {
			$this->assign ( "depart", $depart );
			$where = $where . "  depart=" . $depart;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		// 部門
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
		$this->display ();
	}
	function friendforlevel() {
		$level = $_GET ["level"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = "";
		if (! empty ( $level )) {
			$where = $where . "  level =" . $level;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ();
	}
	function friendforteam() {
		$team = $_GET ["team"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = "";
		if (! empty ( $team )) {
			$where = $where . "  team =" . $team;
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ();
	}
	function friendforcase() {
		$sql = "select * from user ";
		$ids = $_GET ["ids"];
		$model = new UserModel ();
		import ( "ORG.Util.Page" );
		$where = "";
		if (! empty ( $ids )) {
			$where = $where . "id in (" . $ids . ")";
		}
		$count = $model->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $model->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ();
	}
}
?>