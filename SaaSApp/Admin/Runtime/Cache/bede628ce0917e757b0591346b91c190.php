<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業管理系統 後台管理</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/basic.css" />
</head>

<body>
	<div class="login">
		<div class="top">
			<div class="top_logo">
				<h1>物業管理系統 後台管理</h1>
			</div>
		</div>
		<form id="form1" name="form1" method="post" action="__URL__/login">
			<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<th width="74" align="right" scope="row">帳 號</th>
					<td width="226"><input type="text" name="username" style="width: 200px" /></td>
				</tr>
				<tr>
					<th align="right" scope="row">密 碼</th>
					<td><input type="password" name="pwd" style="width: 200px" /></td>
				</tr>
				<tr>
					<th scope="row">&nbsp;</th>
					<td><input type="submit" name="Submit" value="登 入" /></td>
				</tr>
			</table>
		</form>
		<div class="foot">台灣達奈股份有限公司 版權所有</div>
	</div>
</body>
</html>