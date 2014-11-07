<?php
include_once 'phpconsole/i.php';

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
function formatDate($date) {
	if ($date == "0000-00-00 00:00:00")
		return "";
	return date ( 'Y/m/d', strtotime ( $date ) );
}
function multiByDigit($d, $t) {
	return $d * $t;
}
function getWeek($d) {
	$weekarray = array ("日", "一", "二", "三", "四", "五", "六" );
	echo $weekarray [date ( "w", strtotime ( $d ) )];
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
	if($dayOfWeek==0)$dayOfWeek=7;
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
		if ($dayOfDate == $startDay || (($dayOfDate>$startDay) && ($dayOfDate - $startDay < $costday)))
			return 'Y';
	} else if ($t == 'Q') {
		if (($monthOfDate == $startMonth || ($monthOfDate>$startMonth && ($monthOfDate-$startMonth)%3==0 )) 
				&& ($dayOfDate == $startDay 
						|| (($dayOfDate>$startDay) 
								&& ($dayOfDate - $startDay < $costday))))
			return 'Y';
	}
	else if ( $t == 'H') {
		if (($monthOfDate == $startMonth || ($monthOfDate>$startMonth && ($monthOfDate-$startMonth)%6==0 )) 
				&& ($dayOfDate == $startDay
						|| (($dayOfDate>$startDay)
								&& ($dayOfDate - $startDay < $costday))))
			return 'Y';
	}
	else if ( $t == 'Y') {
		if ($monthOfDate == $startMonth
				&& ($dayOfDate == $startDay
						|| (($dayOfDate>$startDay)
								&& ($dayOfDate - $startDay < $costday))))
			return 'Y';
	}
	return '&nbsp;';
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
?>