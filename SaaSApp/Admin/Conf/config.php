 <?php
$config=require './config.inc.php';
$array= array(
	//'配置项'=>'配置值'
	'MODULES'=>'',
	'PAGE_ROLLPAGE'=>10,
	'PAGESIZE'=>20,
	'TMPL_CACHE_ON'=>false,
	'USER_SESSION_KEY'=>'SESSION_USER',
	'MSG_COMM_KEY'=>'MSG_COMM',
	'MSG_WORK_KEY'=>'MSG_WORK',
	'MSG_OTHER_WORK_KEY'=>'MSG_OTHER_WORK',
	'AWOKE_WORK_KEY'=>'AWOKE_WORK',
);
return array_merge($config,$array);
?>