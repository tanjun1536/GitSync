<?php
include_once 'phpconsole/i.php';
define ( 'STOCK_PURCHASE', 'P' );
define ( 'STOCK_CHECK', 'C' );
define ( 'STOCK_BACK', 'B' );
define ( 'STOCK_STORAGE', 'S' );
define ( 'STOCK_IN', 'I' );
define ( 'STOCK_OUT', 'O' );
define ( 'STOCK_ALLOCATE', 'A' );
function getUserLineCode($code) {
	$user = new Model ( 'User' );
	$data = $user->where ( "code='" . $code . "'" )->max ( 'ucode' );
	if (empty ( $data )) {
		return sprintf ( "%04d", 1 );
	} else {
		return sprintf ( "%04d", $data + 1 );
	}
}
function getCompanyLineCode() {
	$c = M ( 'company' );
	$data = $c->max ( 'code' );
	if (empty ( $data )) {
		return sprintf ( "%04d", 1 );
	} else {
		return sprintf ( "%04d", $data + 1 );
	}
}
function getCaseRepairLineCode($case) {
	$cp = M ( "case_device_repair_linecode" );
	$data = $cp->where ( "`case`= " . $case . " AND date='" . date ( 'Y-m-d' ) . "'" )->find ();
	if (empty ( $data )) {
		$data ['date'] = date ( 'Y-m-d' );
		$data ['case'] = $case;
		$data ['code'] = 1;
		$cp->add ( $data );
	} else {
		$data ['code'] = $data ['code'] + 1;
		$cp->save ( $data );
	}
	if (strlen ( $data ['code'] ) == 1)
		return "B" . date ( "Ymd" ) . "00" . $data ['code'];
	if (strlen ( $data ['code'] ) == 2)
		return "B" . date ( "Ymd" ) . "0" . $data ['code'];
	if (strlen ( $data ['code'] ) == 3)
		return "B" . date ( "Ymd" ) . $data ['code'];
}
function getCaseMaintenanceLineCode($case) {
	$cp = M ( "case_device_maintenance_linecode" );
	$data = $cp->where ( "`case`= " . $case . " AND date='" . date ( 'Y-m-d' ) . "'" )->find ();
	if (empty ( $data )) {
		$data ['date'] = date ( 'Y-m-d' );
		$data ['case'] = $case;
		$data ['code'] = 1;
		$cp->add ( $data );
	} else {
		$data ['code'] = $data ['code'] + 1;
		$cp->save ( $data );
	}
	if (strlen ( $data ['code'] ) == 1)
		return "A" . date ( "Ymd" ) . "00" . $data ['code'];
	if (strlen ( $data ['code'] ) == 2)
		return "A" . date ( "Ymd" ) . "0" . $data ['code'];
	if (strlen ( $data ['code'] ) == 3)
		return "A" . date ( "Ymd" ) . $data ['code'];
}
function getExtion($path) {
	return pathinfo ( $path, PATHINFO_EXTENSION );
}
function getCut($str) {
	if (strlen ( $str ) > 38)
		return csubstr ( $str, 0, 38 ) . "...";
	return $str;
}
function zeroFill($str) {
	if (strlen ( $str ) == 1)
		return "0" . $str;
	return $str;
}
function chinese_split($str) {
	$utf8str = iconv ( "gbk", "utf-8", $str );
	$array = explode ( ',', $utf8str );
	foreach ( $array as $key => $value ) {
		$chinesearray [$key] = iconv ( "utf-8", "gbk", $value );
	}
	return $chinesearray;
}
function formatDate($date, $format = 'Y/m/d') {
	if ($date == "0000-00-00 00:00:00" || $date == null)
		return "";
	return date ( $format, strtotime ( $date ) );
}
function formatStr($str) {
	if ($str == null)
		return "";
	return $str;
}
function multiByDigit($d, $t) {
	return $d * $t;
}
function getWeek($d) {
	$weekarray = array (
			"日",
			"一",
			"二",
			"三",
			"四",
			"五",
			"六" 
	);
	echo $weekarray [date ( "w", strtotime ( $d ) )];
}
function getDay($d) {
	echo date ( "d", strtotime ( $d ) );
}
function addDay($date) {
	return date ( "Y", strtotime ( $date ) ) . "-" . date ( "m", strtotime ( $date ) ) . "-" . (date ( "d", strtotime ( $date ) ) + 1);
}
function getName($s) {
	if ($s == 'D') {
		return '日保養';
	} else if ($s == 'W') {
		return '週保養';
	} else if ($s == 'M') {
		return '月保養';
	} else if ($s == 'Q') {
		return '季保養';
	} else if ($s == 'H') {
		return '半年保養';
	} else if ($s == 'Y') {
		return '年保養';
	}
}
function getNameDetail($ov) {
	$s = $ov ['type'];
	if ($s == 'D') {
		return "日保養- 每隔1天1次 ，保養時間1天";
	} else if ($s == 'W') {
		return "週保養- 每週" . $ov ['startday'] . "， 每隔7天1次 ，保養時間" . $ov ['costday'] . " 天";
	} else if ($s == 'M') {
		return "月保養 - 每月 " . $ov ['startday'] . "日， 每年12次 ，保養時間 " . $ov ['costday'] . " 天";
	} else if ($s == 'Q') {
		return "季保養 - 每年" . $ov ['startmonth'] . "  月 " . $ov ['startday'] . " 日， 每年4次 ，保養時間" . $ov ['costday'] . " 天";
	} else if ($s == 'H') {
		return "半年保養 -每年" . $ov ['startmonth'] . "  月 " . $ov ['startday'] . " 日， 每年2次 ，保養時間" . $ov ['costday'] . "  天";
	} else if ($s == 'Y') {
		return "年保養 - 每年" . $ov ['startmonth'] . "  月" . $ov ['startday'] . " 日， 每年1次 ，保養時間 " . $ov ['costday'] . "  天";
	}
}
function getY($item, $date) {
	$t = $item ['type'];
	$startDay = $item ['startday'];
	$startMonth = $item ['startmonth'];
	$costday = $item ['costday'];
	$dayOfWeek = date ( "w", strtotime ( $date ) );
	if ($dayOfWeek == 0)
		$dayOfWeek = 7;
	$dayOfDate = date ( "j", strtotime ( $date ) );
	$monthOfDate = date ( "n", strtotime ( $date ) );
	if ($t == 'D')
		return 'Y';
	else if ($t == 'W') {
		// 時間等於開始時間或者時間減去開始時間小於costday
		if ($dayOfWeek == $startDay || ($dayOfWeek - $startDay) < $costday)
			return 'Y';
	} else if ($t == 'M') {
		// 時間等於開始時間或者時間減去開始時間小於costday
		if ($dayOfDate == $startDay || (($dayOfDate > $startDay) && ($dayOfDate - $startDay < $costday)))
			return 'Y';
	} else if ($t == 'Q') {
		if (($monthOfDate == $startMonth || ($monthOfDate > $startMonth && ($monthOfDate - $startMonth) % 3 == 0)) && ($dayOfDate == $startDay || (($dayOfDate > $startDay) && ($dayOfDate - $startDay < $costday))))
			return 'Y';
	} else if ($t == 'H') {
		if (($monthOfDate == $startMonth || ($monthOfDate > $startMonth && ($monthOfDate - $startMonth) % 6 == 0)) && ($dayOfDate == $startDay || (($dayOfDate > $startDay) && ($dayOfDate - $startDay < $costday))))
			return 'Y';
	} else if ($t == 'Y') {
		if ($monthOfDate == $startMonth && ($dayOfDate == $startDay || (($dayOfDate > $startDay) && ($dayOfDate - $startDay < $costday))))
			return 'Y';
	}
	return '&nbsp;';
}
function getRepairState($date, $state, $days) {
	if ($state == '申請叫修') {
		if (empty ( $days ))
			return $state;
		$day = 24 * 3600;
		$nowdate = date ( "Y-m-d h:i:s" );
		$diff = strtotime ( $nowdate ) - strtotime ( $date );
		$edays = $diff / $day;
		if ($edays > $days)
			return "<font color='red'>$state</font>";
		else
			return $state;
	} else
		return $state;
}
function csubstr($string, $beginIndex, $length) {
	if (strlen ( $string ) < $length) {
		return substr ( $string, $beginIndex );
	}
	
	$char = ord ( $string [$beginIndex + $length - 1] );
	if ($char >= 224 && $char <= 239) {
		$str = substr ( $string, $beginIndex, $length - 1 );
		return $str;
	}
	
	$char = ord ( $string [$beginIndex + $length - 2] );
	if ($char >= 224 && $char <= 239) {
		$str = substr ( $string, $beginIndex, $length - 2 );
		return $str;
	}
	
	return substr ( $string, $beginIndex, $length );
}
function getStockLineCode($type) {
	$line = M ( "stock_line_code" );
	$data = $line->where ( "`code`= '" . $_SESSION [C ( "USER_SESSION_KEY" )] ["code"] . "' AND date='" . date ( 'Y-m-d' ) . "' AND type='" . $type . "'" )->find ();
	if (empty ( $data )) {
		$data ['date'] = date ( 'Y-m-d' );
		$data ['type'] = $type;
		$data ['line'] = 1;
		$data ['code'] = $_SESSION [C ( "USER_SESSION_KEY" )] ["code"];
		$line->add ( $data );
	} else {
		$data ['line'] = $data ['line'] + 1;
		$line->save ( $data );
	}
	if (strlen ( $data ['line'] ) == 1)
		return $type . date ( "Ymd" ) . "0" . $data ['line'];
	if (strlen ( $data ['line'] ) == 2)
		return $type . date ( "Ymd" ) . $data ['line'];
}
function getStockPurchaseCode() {
	return getStockLineCode ( STOCK_PURCHASE );
}
function getStockCheckCode() {
	return getStockLineCode ( STOCK_CHECK );
}
function getStockBackCode() {
	return getStockLineCode ( STOCK_BACK );
}
function getStockInCode() {
	return getStockLineCode ( STOCK_IN );
}
function getStockOutCode() {
	return getStockLineCode ( STOCK_OUT );
}
function getStockAllocateCode() {
    return getStockLineCode ( STOCK_ALLOCATE );
}
function getStockStorageCode() {
	return getStockLineCode ( STOCK_STORAGE );
}
function check_power($power, $limits) {
	$pos = strpos ( $limits, $power );
	if ($pos === false)
		return 0;
	return 1;
}
function getPriceLineCode($type) {
	$line = M ( "price_linecode" );
	$data = $line->where ( "`code`= '" . $_SESSION [C ( "USER_SESSION_KEY" )] ["code"] . "' AND date='" . date ( 'Y-m-d' ) . "' AND type='" . $type . "'" )->find ();
	if (empty ( $data )) {
		$data ['date'] = date ( 'Y-m-d' );
		$data ['type'] = $type;
		$data ['line'] = 1;
		$data ['code'] = $_SESSION [C ( "USER_SESSION_KEY" )] ["code"];
		$line->add ( $data );
	} else {
		$data ['line'] = $data ['line'] + 1;
		$line->save ( $data );
	}
	if (strlen ( $data ['line'] ) == 1)
		return $type . date ( "Ymd" ) . "0" . $data ['line'];
	if (strlen ( $data ['line'] ) == 2)
		return $type . date ( "Ymd" ) . $data ['line'];
}
function getPriceCustomerLineCode() {
	return getPriceLineCode ( 'Q' );
}
function getPriceBusinessLineCode() {
	return getPriceLineCode ( 'P' );
}
function getDeptName($id) {
	$sql = "SELECT name FROM `depart` where id=$id";
	$dept = M ( 'depart' );
	$data = $dept->query ( $sql );
	return $data [0] ['name'];
}
function getTeamName($id) {
	$sql = "SELECT name FROM `team` where id=$id";
	$dept = M ( 'team' );
	$data = $dept->query ( $sql );
	return $data [0] ['name'];
}
function change_value($data, $k1, $k2) {
	return empty ( $data [$k1] ) ? $data [$k2] : $data [$k1];
}

function dateDiff($start, $end ) {
	$sdate = strtotime ( $start );
	$edate = strtotime ( $end );
	
	$time = $edate - $sdate;
	if ($time >= 0 && $time <= 59) {
		// Seconds
		$timeshift = $time . ' seconds ';
	} elseif ($time >= 60 && $time <= 3599) {
		// Minutes + Seconds
		$pmin = ($edate - $sdate) / 60;
		$premin = explode ( '.', $pmin );
		
		$presec = $pmin - $premin [0];
		$sec = $presec * 60;
		
		$timeshift = $premin [0] . ' min ' . round ( $sec, 0 ) . ' sec ';
	} elseif ($time >= 3600 && $time <= 86399) {
		// Hours + Minutes
		$phour = ($edate - $sdate) / 3600;
		$prehour = explode ( '.', $phour );
		
		$premin = $phour - $prehour [0];
		$min = explode ( '.', $premin * 60 );
		
		$presec = '0.' . $min [1];
		$sec = $presec * 60;
		
		$timeshift = $prehour [0] . ' hrs ' . $min [0] . ' min ' . round ( $sec, 0 ) . ' sec ';
	} elseif ($time >= 86400) {
		// Days + Hours + Minutes
		$pday = ($edate - $sdate) / 86400;
		$preday = explode ( '.', $pday );
		
		$phour = $pday - $preday [0];
		$prehour = explode ( '.', $phour * 24 );
		
		$premin = ($phour * 24) - $prehour [0];
		$min = explode ( '.', $premin * 60 );
		
		$presec = '0.' . $min [1];
		$sec = $presec * 60;
		
		$timeshift = $preday [0] . ' days ' . $prehour [0] . ' hrs ' . $min [0] . ' min ' . round ( $sec, 0 ) . ' sec ';
	}
	return $timeshift;
}

function getProjectPriceLineCode() {
	$line = M ( "project_price_linecode" );
	$data = $line->where ( "`code`= '" . $_SESSION [C ( "USER_SESSION_KEY" )] ["code"] . "' AND date='" . date ( 'Y-m-d' ) . "'" )->find ();
	if (empty ( $data )) {
		$data ['date'] = date ( 'Y-m-d' );
		$data ['line'] = 1;
		$data ['code'] = $_SESSION [C ( "USER_SESSION_KEY" )] ["code"];
		$line->add ( $data );
	} else {
		$data ['line'] = $data ['line'] + 1;
		$line->save ( $data );
	}
	if (strlen ( $data ['line'] ) == 1)
		return 'Q' . date ( "Ymd" ) . "0" . $data ['line'];
	if (strlen ( $data ['line'] ) == 2)
		return 'Q' . date ( "Ymd" ) . $data ['line'];
}
?>