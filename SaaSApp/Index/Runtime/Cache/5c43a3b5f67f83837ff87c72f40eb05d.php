<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
<style type="text/css">

<!--
body {
	background-color: #FFFFFF;
	background-image: none;
}
h1 {
	font-size: 24px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 10px;
	margin-left: 0px;
	display: block;
	text-align: center;
	width: 695px;
}
.tabThSide {
	background-color: #333333;
}
.tabThSide th {
	background-color: #FFFFFF;
	color: #000000;
}
-->
</style>
</head>
<body>
	<h1><?php echo ($repair["caseName"]); ?>叫修單</h1>
	<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
		<tr>
			<th scope="row">叫修單編號</th>
			<td><?php echo ($repair["repaircode"]); ?></td>
			<th scope="row">叫修時間</th>
			<td><?php echo (date('Y/m/d H:i',strtotime($repair["repairdate"]))); ?></td>
		</tr>
		<tr>
			<th width="100" scope="row">樓層區域</th>
			<td width="287">><?php echo ($repair["bname"]); ?>／<?php echo ($repair["bfname"]); ?>／<?php echo ($repair["aname"]); ?></td>
			<th width="82" scope="row">申請人</th>
			<td width="221"><?php echo ($repair["requestuser"]); ?></td>
		</tr>
		<tr>
			<th scope="row">設備編號</th>
			<td><?php echo ($repair["devicecode"]); ?></td>
			<th scope="row">叫修人</th>
			<td><?php echo ($repair["askuser"]); ?></td>
		</tr>
		<tr>
			<th scope="row">設備名稱</th>
			<td colspan="3"><label><?php echo ($repair["devicename"]); ?></label></td>
		</tr>
		<tr>
			<th scope="row">說明</th>
			<td height="50" colspan="3" valign="top"><?php if(is_array($msgs)): $i = 0; $__LIST__ = $msgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php echo ($item["senduser"]); ?>:<?php echo ($item["msg"]); ?> <br /><?php endforeach; endif; else: echo "" ;endif; ?></td>
		</tr>
		<tr>
      <th scope="row">處理情況</th>
      <td height="75" colspan="3" valign="top"><input type="checkbox" name="checkbox" value="checkbox">
未完工
  <input type="checkbox" name="checkbox2" value="checkbox">
完工</td>
    </tr>
    <tr>
      <th rowspan="2" scope="row">耗材管理</th>
      <td rowspan="2" valign="top"><input type="checkbox" name="checkbox3" value="checkbox">
未領料
  <input type="checkbox" name="checkbox4" value="checkbox">
領料</td>
      <th scope="row">施工人員</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">施工日期</th>
      <td>&nbsp;</td>
    </tr>
</tbody></table>
<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
  <tbody><tr>
    <th width="227" scope="col">業方</th>
    <th width="233" scope="col">現場主管</th>
    <th width="231" scope="col">驗收</th>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td height="40">&nbsp;</td>
    <td height="40">&nbsp;</td>
  </tr>
</tbody></table>


<embed type="application/xl_chrome_plugin" width="0" height="0" style="visibility: hidden;">
</body>
</html>