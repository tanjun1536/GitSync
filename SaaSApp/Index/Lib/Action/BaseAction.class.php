<?php
include_once 'BasePath.php';
define ( 'ATTCHEMENT_PATH_HEADIMAGE', './Public/Uploads/' );
define ( 'ATTCHEMENT_PATH_MEETFILE', './Public/Uploads/atts/meet/' );
define ( 'ATTCHEMENT_PATH_ELECFILE', './Public/Uploads/atts/elec/' );
define ( 'ATTCHEMENT_PATH_FORMFILE', './Public/Uploads/atts/form/' );
define ( 'ATTCHEMENT_PATH_MSGFILE', './Public/Uploads/atts/msg/' );
define ( 'ATTCHEMENT_PATH_CONTRACTFILE', './Public/Uploads/atts/contract/' );
define ( 'ATTCHEMENT_PATH_NEWSFILE', './Public/Uploads/atts/news/' );
define ( 'ATTCHEMENT_PATH_ZZFILE', './Public/Uploads/atts/zz/' );
define ( 'ATTCHEMENT_PATH_CASEFILE', './Public/Uploads/atts/case/' );
define ( 'ATTCHEMENT_PATH_PRODUCT', './Public/Uploads/atts/product/' );
define ( 'ATTCHEMENT_PATH_ACCEPT', './Public/Uploads/atts/accept/' );
class BaseAction extends Action {
	static $SUCCESS = 1;
	static $FAIL = 0;
	// 记录用户Session
	protected $code = '';
	protected $id = '';
	function getSession($key) {
		return $_SESSION [$key];
	}
	function setSession($key, $value) {
		$_SESSION [$key] = $value;
	}
	function setUser($user) {
		$this->setSession ( C ( "USER_SESSION_KEY" ), $user );
	}
	function getUser() {
		return $this->getSession ( C ( "USER_SESSION_KEY" ) );
	}
	function getCode() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["code"];
	}
	function getUCode() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["ucode"];
	}
	function getImage() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["userimage"];
	}
	function getDepart() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["depart"];
	}
	function getTeamId() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["team"];
	}
	function getId() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["id"];
	}
	function getName() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["name"];
	}
	function _initialize() {
		$data = $this->getUser ();
		if (empty ( $data )) {
			$this->redirect ( "Index/index" );
		}
		$this->setMenuData ( $data ['role'] );
		$this->code = $data ['code'];
		$this->id = $data ['id'];
		header ( 'Content-Type:text/html;charset=utf-8' );
		$this->assign ( "LeftMenu", $_SESSION ["LeftMenu"] );
		$this->assign ( "TopMenu", $_SESSION ["TopMenu"] );
		$this->assign ( "CaseMenu", $_SESSION ["CaseMenu"] );
		if (empty ( $_POST [C ( 'TOKEN_NAME' )] ))
			unset ( $_SESSION [C ( 'TOKEN_NAME' )] );
		// else println("AAAAAAAAAAAAAA");
	}
	function setMenuData($role) {
		$url_this = $_SERVER ['PHP_SELF'];
		$pos = strpos ( $url_this, "Index.php" );
		if ($pos === false)
			$pos = strpos ( $url_this, "index.php" );
		$url = substr ( $url_this, $pos + 9 );
		$url = "__APP__" . $url;
		if (strcmp ( $url, "__APP__/Case/index" ) == 0) {
			$url = "__APP__/Case/view";
		}
		$exts = $_SESSION ['exts'];
		if ($exts == null) {
			$exts = $this->getExts ( $role );
			$_SESSION ['exts'] = $exts;
		}
		
		foreach ( $exts as $key => $val ) {
			if (strcmp ( $url, $val ['link'] ) == 0) {
				$this->assign ( "ext", $val ['ext'] );
				break;
			}
		}
	}
	/**
	 *
	 * @param
	 *        	role
	 */
	private function getExts($role) {
		$sql = "SELECT 
			  rm.*,
			  m.`link` 
			FROM
			  `menu` m 
			  INNER JOIN `role_menu` rm 
			    ON m.`id` = rm.`mid` 
			WHERE rm.`rid` = $role 
			  AND m.`ext` IS NOT NULL ";
		$menu = new Model ();
		$exts = $menu->query ( $sql );
		
		return $exts;
	}
	function index() {
		// $this->assign ( "user", $this->getUser () );
		$this->display ( 'index' );
	}
	function add() {
		// $this->assign ( "user", $this->getUser () );
		$this->display ( 'add' );
	}
	function edit() {
		// $this->assign ( "user", $this->getUser () );
		$this->display ();
	}
	function view() {
		// $this->assign ( "user", $this->getUser () );
		$this->display ();
	}
	function deleteByModelName($model) {
		$ids = $_POST ["itemcheckbox"];
		$where = implode ( ",", $ids );
		$model = M ( $model );
		$model->delete ( $where );
		$this->index ();
	}
	function getDeparts() {
		$depart = new DepartModel ();
		$departs = $depart->selectByCode ();
		$this->assign ( "departs", $departs );
	}
	function getPage($count) {
		$p = new Page ( $count, C ( "PAGESIZE" ) );
		$p->setConfig ( 'prev', '上一頁' );
		$p->setConfig ( 'next', '下一頁' );
		$p->setConfig ( 'first', '第一頁' );
		$p->setConfig ( 'last', '最後一頁' );
		// $p->setConfig("theme", " %totalRow% %header% %nowPage%/%totalPage% 页
		// %upPage% %downPage% %first% %prePage% %linkPage% %nextPage% %end% ");
		$p->setConfig ( "theme", "%totalRow% %header%  %prePage% %upPage%   %linkPage%  %downPage% %nextPage% " );
		return $p;
	}
	function getWhere() {
		return " `code`='" . $this->getCode () . "' ";
	}
	function getWhereWithTable($table) {
		return $table . ".code='" . $this->getCode () . "' ";
	}
	public function getCity() {
		$pid = $_POST ["pid"];
		$city = new Model ( 'area' );
		$citys = $city->where ( "pid=" . $pid )->select ();
		echo json_encode ( $citys );
	}
	public function getTeam() {
		$pid = $_POST ["pid"];
		$team = new Model ( 'team' );
		$teams = $team->where ( "depart=" . $pid )->select ();
		echo json_encode ( $teams );
	}
	public function getPeopleByTeam() {
		$id = $_POST ["id"];
		$user = new UserModel ();
		if (empty ( $id ))
			$users = $user->selectByCode ();
		else
			$users = $user->where ( "team=" . $id )->select ();
		echo json_encode ( $users );
	}
	public function getPeopleByTeamAndCase() {
		$id = $_POST ["id"];
		$sql = "SELECT u.* FROM `user` u INNER JOIN `case_member` c ON u.`id`=c.`memberid`  WHERE u.team=$id and c.`case`=" . $_SESSION ['case'];
		$user = new UserModel ();
		$users = $user->query ( $sql );
		echo json_encode ( $users );
	}
	public function getPeopleByDepart() {
		$id = $_POST ["id"];
		$user = new UserModel ();
		if (empty ( $id ))
			$users = $user->selectByCode ();
		else
			$users = $user->where ( "depart=" . $id )->select ();
		echo json_encode ( $users );
	}
	public function download($path, $filename) {
		import ( 'ORG.Net.Http' );
		Http::download ( $path, $filename );
	}
	function down() {
		$name = $_GET ['name'];
		$this->download ( $name, $name );
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
	function doAjaxFileUpload() {
		import ( "ORG.Net.UploadFile" );
		$back = "";
		$up = new UploadFile ();
		$up->savePath = ATTCHEMENT_PATH_ZZFILE;
		$up->saveRule = time ();
		if ($up->upload ()) {
			$file = $up->getUploadFileInfo ();
			$back = $file [0] ["savename"];
		}
		echo ATTCHEMENT_PATH_ZZFILE . $back;
	}
	function getParameter() {
		$cond = '';
		foreach ( $_POST as $k => $v ) {
			if ($k == '__hash__')
				continue;
			if ($v == '搜尋')
				continue;
			if (empty ( $v ))
				continue;
			$cond .= "$k=" . urlencode ( $v ) . "&";
		}
		return $cond;
	}
	function getParam($key) {
		return empty ( $_POST [$key] ) ? $_GET [$key] : $_POST [$key];
	}
	function table_page($dao, $where) {
		import ( "ORG.Util.Page" );
		$count = $dao->where ( $where )->count ();
		$p = $this->getPage ( $count );
		$page = $p->show ();
		$list = $dao->where ( $where )->order ( 'id desc' )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
	}
	function onesql_page($sql) {
		import ( "ORG.Util.Page" );
		$dao=new Model();
		$count = $dao->query ("SELECT COUNT(*) FROM ($sql) Temp" );
		$count = $count [0] ['COUNT(*)'];
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $dao->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
	}
	function page($csql, $dsql) {
		import ( "ORG.Util.Page" );
		$dao = new Model ();
		$count = $dao->query ( $csql );
		$count = $count [0] ['COUNT(*)'];
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$dsql = $dsql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $dao->query ( $dsql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
	}
	function shopping_page($csql, $dsql) {
		import ( "ORG.Util.Page" );
		$dao=new Model();
		$dao->db(1,C('shop_db'));
		$count = $dao->query ( $csql );
		$count = $count [0] ['COUNT(*)'];
		$p = $this->getPage ( $count );
		$page = $p->show ();
		if ($count > 0) {
			$dsql = $dsql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $dao->query ( $dsql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
	}
	function shop_page($sql) {
		import ( "ORG.Util.Page" );
		$dao=new Model();
		$dao->db(1,C('shop_db'));
		$count = $dao->query ("SELECT COUNT(*) FROM ($sql) Temp" );
		$count = $count [0] ['COUNT(*)'];
		$p = $this->getPage ( $count );
		$p->parameter .= "&" . $this->getParameter ();
		$page = $p->show ();
		if ($count > 0) {
			$sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
			$list = $dao->query ( $sql );
		}
		$this->assign ( "list", $list );
		$this->assign ( "page", $page );
	}
	function execObj($sql) {
		$dao = new Model ();
		return $dao->query ( $sql );
	}
	function checkExcept($ret) {
		if ($ret === false)
			throw new Exception ( 'a db exception occured ', '100' );
	}
	function Test() {
		vendor ( 'Excel.PHPExcel' );
		try {
			// $objPHPExcel = PHPExcel_IOFactory::load ( $filename );
			$objPHPExcel = PHPExcel_IOFactory::load ( "d:/abc.xls" );
		} catch ( Exception $e ) {
			$this->ShowMessage ( $e->getMessage () );
		}
		
		$rows = $objPHPExcel->getSheet ( 0 )->getRowDimensions ();
		spl_autoload_register ( array (
				'Think',
				'autoload' 
		) );
		
		for($i = 1; $i < count ( $rows ); $i ++) {
			$db = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 0, $i )->getValue ();
			$lc = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 1, $i )->getValue ();
			$qy = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 2, $i )->getValue ();
			$sbbh = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 3, $i )->getValue ();
			$zlb = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 4, $i )->getValue ();
			$zilb = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 5, $i )->getValue ();
			$sbmc = $objPHPExcel->getSheet ( 0 )->getCellByColumnAndRow ( 6, $i )->getValue ();
			$case = $_SESSION ['case'];
			$uid = $this->id;
		}
	}
	function export($title, $headers, $data) {
		vendor ( 'Excel.PHPExcel' );
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel ();
		
		// Set document properties
		// $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		// ->setLastModifiedBy("Maarten Balliauw")
		// ->setTitle("Office 2007 XLSX Test Document")
		// ->setSubject("Office 2007 XLSX Test Document")
		// ->setDescription("Test document for Office 2007 XLSX, generated using
		// PHP classes.")
		// ->setKeywords("office 2007 openxml php")
		// ->setCategory("Test result file");
		
		$headerkeys = array (
				'A',
				'B',
				'C',
				'D',
				'E',
				'F',
				'G',
				'H',
				'I',
				'J',
				'K',
				'L',
				'M',
				'N',
				'O',
				'P',
				'Q',
				'R',
				'S',
				'T',
				'U',
				'V',
				'W',
				'X',
				'Y',
				'Z' 
		);
		// Add Header data
		$headercolumns = explode ( ',', $headers );
		spl_autoload_register ( array (
				'Think',
				'autoload' 
		) );
		$sheet = $objPHPExcel->setActiveSheetIndex ( 0 );
		foreach ( $headercolumns as $key => $value ) {
			$sheet->setCellValue ( $headerkeys [$key] . '1', $value );
		}
		// Add Data
		for($i = 0; $i < count ( $data ); $i ++) {
			$h = 0;
			foreach ( $data [$i] as $k => $v ) {
				$p = $headerkeys [$h] . ($i + 2);
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $p, $v );
				$h ++;
			}
		}
		// $objPHPExcel->setActiveSheetIndex(0)
		// ->setCellValue('A1', 'Hello')
		// ->setCellValue('B2', 'world!')
		// ->setCellValue('C1', 'Hello')
		// ->setCellValue('D2', 'world!');
		
		// Miscellaneous glyphs, UTF-8
		// $objPHPExcel->setActiveSheetIndex(0)
		// ->setCellValue('A4', 'Miscellaneous glyphs')
		// ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet ()->setTitle ( $title );
		
		// Set active sheet index to the first sheet, so Excel opens this as the
		// first sheet
		$objPHPExcel->setActiveSheetIndex ( 0 );
		// very beautiful
		ob_end_clean ();
		ob_start ();
		// Redirect output to a client’s web browser (Excel5)
		$ua = $_SERVER ["HTTP_USER_AGENT"];
		
		$filename = $title;
		$encoded_filename = urlencode ( $filename );
		$encoded_filename = str_replace ( "+", "%20", $encoded_filename );
		// header ( 'Content-Type: application/octet-stream' );
		header ( 'Content-Type: application/vnd.ms-excel;charset=utf-8' );
		if (preg_match ( "/MSIE/", $ua )) {
			header ( 'Content-Disposition: attachment; filename="' . $encoded_filename . '"' );
		} else if (preg_match ( "/Firefox/", $ua )) {
			header ( 'Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"' );
		} else {
			header ( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		}
		// header ( 'Content-Disposition: attachment;filename="' . $title .
		// '.xls"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		$objWriter->save ( 'php://output' );
		exit ();
	}
	function send() {
		if ($this->send_email ( array (
				"tanjun1536@139.com",
				"lai5216@yahoo.com.tw",
				"ernie@tdnet.com.tw" 
		), "测试邮件发送", "测试机邮件asdfasdfads" )) {
			echo "S";
		} else {
			echo "E";
		}
	}
	function send_email($tos, $subject, $body, $atts = null) {
		vendor ( "PHPMailer.class#phpmailer" );
		try {
			$mail = new PHPMailer ( true ); // New instance, with exceptions
			                                // enabled
			$mail->CharSet = "utf-8";
			$mail->SMTPDebug = false;
			
			// $body = file_get_contents ( 'contents.html' );
			$body = preg_replace ( '/\\\\/', '', $body ); // Strip
			                                              // backslashes
			
			$mail->IsSMTP (); // tell the class to use SMTP
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->Port = 25; // set the SMTP server port
			$mail->Host = "mail.24hours.com.tw"; // SMTP server
			$mail->Username = "test@24hours.com.tw"; // SMTP server username
			$mail->Password = "test"; // SMTP server password
			$mail->Timeout = 1000; // $mail->IsSendmail(); // tell the class
			                       // to use Sendmail
			                       
			// $mail->AddReplyTo ( $to, $name );
			
			$mail->From = "test@24hours.com.tw";
			$mail->FromName = "物業管理系統";
			foreach ( $tos as $to ) {
				$mail->AddAddress ( $to, $to );
			}
			
			$mail->Subject = $subject;
			
			// $mail->AltBody = "To view the message, please use an HTML
			// compatible email viewer!"; // optional, comment out and test
			$mail->WordWrap = 80; // set word wrap
			
			$mail->MsgHTML ( $body );
			
			$mail->IsHTML ( true ); // s7end as HTML
			if (! empty ( $atts )) {
				foreach ( $atts as $att ) {
					$mail->AddAttachment ( $att );
				}
			}
			$mail->Send ();
			// echo 'Message has been sent.';
			return true;
		} catch ( phpmailerException $e ) {
			// echo $e->errorMessage ();
			return false;
		}
	}
	function GetReqId() {
		return $_GET ['id'];
	}
	function GetProvince() {
		$province = new Model ( 'area' );
		$provinces = $province->where ( "pid=0" )->select ();
		$this->assign ( "provinces", $provinces );
	}
	function ShowMessage($msg) {
		echo "<script type='text/javascript' >alert('$msg')</script>";
	}
	function queryProduct() {
		$name = $_POST ['name'];
		
		$sql = "select * from stock_product where productname like '%$name%'";
		
		$m = new Model ();
		
		$data = $m->query ( $sql );
		
		echo json_encode ( $data );
	}
	function UpLoadFile($path, &$data) {
		import ( "ORG.Net.UploadFile" );
		$up = new UploadFile ();
		$up->savePath = $path;
		$up->saveRule = 'uniqid';
		$up->uploadReplace = true;
		if ($up->upload ()) {
			$paths = "";
			$files = $up->getUploadFileInfo ();
			for($i = 0; $i <= count ( $files ); $i ++) {
				$paths = $paths . $files [$i] ["savename"];
				if ($i < count ( $files ) - 1)
					$paths = $paths . ",";
			}
			$data ['atts'] = $paths;
		}
	}
	/**
	 *
	 * @param
	 *        	list
	 * @param
	 *        	headers
	 * @param
	 *        	row
	 */
	public function cvsDown($list, $headers, $downName) {
	
		// ob_end_clean ();
		// ob_start ();
		// header("Pragma: public");
		header ( 'Content-Type: application/vnd.ms-excel;charset=big5' );
		header ( 'Cache-Control: max-age=0' );
		$ua = $_SERVER ["HTTP_USER_AGENT"];
		$encoded_filename = urlencode ( $downName );
		$encoded_filename = str_replace ( "+", "%20", $encoded_filename );
		if (preg_match ( "/MSIE/", $ua )) {
			header ( 'Content-Disposition: attachment; filename="' . $encoded_filename . '.csv"' );
		} else if (preg_match ( "/Firefox/", $ua )) {
			header ( 'Content-Disposition: attachment; filename*="utf8\'\'' . $downName . '.csv"' );
		} else {
			header ( 'Content-Disposition: attachment; filename="' . $downName . '.csv"' );
		}
		// header('Content-Encoding: none');
		// header("Content-Transfer-Encoding: binary" );
	
		// PHP文件句柄，php://output 表示直接输出到浏览器
		$fp = fopen ( 'php://output', 'a' );
	
		// 输出Excel列头信息
		$head = explode ( ",", $headers );
		foreach ( $head as $i => $v ) {
			// CSV的Excel支持GBK编码，一定要转换，否则乱码
			// $head [$i] = iconv ( 'utf-8', 'gbk', $v );
		}
	
		// 写入列头
		fputcsv ( $fp, $head );
	
		// 计数器
		$cnt = 0;
		// 每隔$limit行，刷新一下输出buffer，节约资源
		$limit = 100000;
	
		// 逐行取出数据，节约内存
		foreach ( $list as $row ) {
			$cnt ++;
			if ($limit == $cnt) { // 刷新一下输出buffer，防止由于数据过多造成问题
				ob_flush ();
				flush ();
				$cnt = 0;
			}
			// foreach ( $row as $i => $v ) {
			// $row [$i] = iconv ( 'utf-8', 'gbk', $v );
			// }
			fputcsv ( $fp, $row );
		}
	
		// $this->export ( $title, $headers, $list );
	}

}
?>