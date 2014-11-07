<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/login.css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript">
	$(function() {
        
//         $('#username').val('admin');
//         $('#pwd').val('123');

		$('#username').trigger('focus');
		//$('#login').click();
	});
</script>
</head>

<body>
	<div class="login">
		<form id="form1" name="form1" method="post" action="__URL__/index">
			<table border="0" cellspacing="10" cellpadding="0">
				<tr>
					<td width="202" height="26"><label>帳 號 <input name="username" id="username" type="text" tabindex="1" style="width: 150px" />
					</label></td>
					<td width="68" rowspan="2"><input type="submit" id="login" style="background: url('__PUBLIC__/images/btn_login.jpg'); width: 68px; height: 59px; border: 0; cursor: pointer;" value="" /></td>
				</tr>
				<tr>
					<td height="24"><label> 密 碼 <input name="pwd" id="pwd" type="password" tabindex="2" style="width: 150px" />
					</label></td>
				</tr>
			</table>
			<label></label>
		</form>
	</div>
	<div align="center">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>
</body>
</html>