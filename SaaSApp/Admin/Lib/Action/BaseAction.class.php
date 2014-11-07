<?php
include_once 'BasePath.php';
define('ATTCHEMENT_PATH_HEADIMAGE', './Public/Uploads/');
define('ATTCHEMENT_PATH_MEETFILE', './Public/Uploads/atts/meet/');
define('ATTCHEMENT_PATH_ELECFILE', './Public/Uploads/atts/elec/');
define('ATTCHEMENT_PATH_FORMFILE', './Public/Uploads/atts/form/');
define('ATTCHEMENT_PATH_MSGFILE', './Public/Uploads/atts/msg/');
define('ATTCHEMENT_PATH_CONTRACTFILE', './Public/Uploads/atts/contract/');
define('ATTCHEMENT_PATH_NEWSFILE', './Public/Uploads/atts/news/');
define('ATTCHEMENT_PATH_ZZFILE', './Public/Uploads/atts/zz/');
define('ATTCHEMENT_PATH_CASEFILE', './Public/Uploads/atts/case/');
define('ATTCHEMENT_PATH_PRODUCT', './Public/Uploads/atts/product/');
class BaseAction extends Action {
    static $SUCCESS = 1;
    static $FAIL = 0;
    //记录用户Session
    function getSession($key) {
        return $_SESSION[$key];
    }
    function setSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    function setUser($user) {
        $this -> setSession(C("USER_SESSION_KEY"), $user);
    }

    function getUser() {
        return $this -> getSession(C("USER_SESSION_KEY"));
    }

    function getCode() {
        return $_SESSION[C("USER_SESSION_KEY")]["code"];
    }
    
    function getUCode() {
    	return $_SESSION[C("USER_SESSION_KEY")]["ucode"];
    }
    function getImage() {
    	return $_SESSION[C("USER_SESSION_KEY")]["userimage"];
    }
    function getDepart() {
    	return $_SESSION[C("USER_SESSION_KEY")]["depart"];
    }
    function getTeamId() {
    	return $_SESSION[C("USER_SESSION_KEY")]["team"];
    }
    function getId() {
        return $_SESSION[C("USER_SESSION_KEY")]["id"];
    }

    function getName() {
        return $_SESSION[C("USER_SESSION_KEY")]["name"];
    }
    
    function _initialize() {

        $data = $this -> getUser();
        if (empty($data)) {
            $this -> redirect("Index/index");
        }
        header('Content-Type:text/html;charset=utf-8');

        if (empty($_POST[C('TOKEN_NAME')]))
            unset($_SESSION[C('TOKEN_NAME')]);
        //else println("AAAAAAAAAAAAAA");
    }

    function index() {
        //$this->assign ( "user", $this->getUser () );
        $this -> display('index');
    }

    function add() {
        //$this->assign ( "user", $this->getUser () );
        $this -> display('add');
    }

    function edit() {
        //$this->assign ( "user", $this->getUser () );
        $this -> display();
    }

    function view() {
        //$this->assign ( "user", $this->getUser () );
        $this -> display();
    }
    function deleteByModelName($model) {
    	$ids = $_POST ["itemcheckbox"];
    	$where = implode ( ",", $ids );
    	$model =M($model);
    	$model->delete ( $where );
    	$this->index ();
    }
    function getDeparts()
    {
    	$depart = new DepartModel ();
    	$departs = $depart->selectByCode ();
    	$this->assign ( "departs", $departs );
    }
    function getPage($count) {
        $p = new Page($count, C("PAGESIZE"));
        $p -> setConfig('prev', '上一頁');
        $p -> setConfig('next', '下一頁');
        $p -> setConfig('first', '第一頁');
        $p -> setConfig('last', '最後一頁');
        //$p->setConfig("theme", " %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end% ");
        $p -> setConfig("theme", "%totalRow% %header% %upPage%   %linkPage%  %downPage% ");
        return $p;
    }

    function getWhere() {
        return " code='" . $this -> getCode() . "' ";
    }
    function getWhereWithTable($table) {
    	return $table.".code='" . $this -> getCode() . "' ";
    }
    public function getCity() {
        $pid = $_POST["pid"];
        $city = new Model('area');
        $citys = $city -> where("pid=" . $pid) -> select();
        echo json_encode($citys);
    }

    public function getTeam() {
        $pid = $_POST["pid"];
        $team = new Model('team');
        $teams = $team -> where("depart=" . $pid) -> select();
        echo json_encode($teams);
    }

    public function getPeopleByDepart() {
        $id = $_POST["id"];
        $user = new UserModel();
        if (empty($id))
            $users = $user -> selectByCode();
        else
            $users = $user -> where("depart=" . $id) -> select();
        echo json_encode($users);
    }
    public function download($path, $filename) {
        import('ORG.Net.Http');
        Http::download($path, $filename);
    }
    function down() {
    	$name = $_GET ['name'];
    	$this->download (  $name, $name );
    
    }
    function zipdown() {
    	$zip = new PHPZip ();
    	$paths = array ();
    	$name = $_GET ['names'];
    	$names = explode ( ",", $name );
    	$i = 0;
    	foreach ( $names as $key => $value ) {
    		$paths [$i] = ATTCHEMENT_PATH_MEETFILE . $value;
    		$i ++;
    	}
    	$zip->createZip ( $paths, "all.zip", true );
    }
    function doAjaxFileUpload()
    {
    	import ( "ORG.Net.UploadFile" );
    	$back="";
    	$up = new UploadFile ();
    	$up->savePath = ATTCHEMENT_PATH_ZZFILE;
    	$up->saveRule=time ();
    	if ($up->upload ()) {
    		$file = $up->getUploadFileInfo ();
    		$back = $file [0] ["savename"];
    	}
    	echo ATTCHEMENT_PATH_ZZFILE.$back;
    }
    function getParameter()
    {
    	$cond='';
    	foreach ($_POST as $k=>$v)
    	{
    		if($k=='__hash__') continue;
    		if($v=='搜尋') continue;
    		if(empty($v))continue;
    		$cond.= "$k=".urlencode($v)."&"; 
    	}
    	return $cond;
    }
	function getParam($key) {
		return empty ( $_POST [$key] ) ? $_GET [$key] :  $_POST [$key];
	}
}
?>