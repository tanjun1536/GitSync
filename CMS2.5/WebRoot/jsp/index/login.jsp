<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
	String sCode = "";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<base href="<%=basePath%>">
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/login.css" />
<!--引入jquery	-->
<script type="text/javascript"
	src="javascript/jquery/js/jquery-1.7.min.js"></script>
<script type="text/javascript">
	$(function() {
		if (window != top)
			top.location.href = location.href;
		//$("#loginForm").submit();
	});

	function closetip() {
		$("#tip").css("display", "none");
	}
</script>
<title>移动城市内容发布管理平台</title>
</head>

<body
	style="background: url(images/login_01.png) repeat-x; height: 100%; width: 100%">
	<div id="box">

		<div class="login">
			<form id="loginForm" method="post" action="LoginAction.action">
				<div class="lg_label">
					<label for="name"> 用户名： </label> <input type="text"
						name="j_username" id="txtUserName"  />
				</div>
				<div class="lg_label">
					<label for="code"> 密 码： </label> <input type="password"
						name="j_password" id="code"  />
				</div>
				<div class="lg_btn">
					<input type="submit" value=" " class="btn" onfocus="this.blur()"
						onMouseOver="this.className='btn_over'"
						onmousedown="this.className='btn_down'"
						onMouseOut="this.className='btn'" />
				</div>
			</form>
			<div id="tip" class="tip" ${F eq 1?'style="display: block"
				':'style="display: none"'}>
				<div
					style="position: absolute; top: -1px; right: -4px; cursor: pointer">
					<img src="images/login_06.png" width="13" onclick="closetip()"
						height="13">
				</div>
				<p class="tip_atr">密码或者用户名错误！</p>
				<p class="tpi_ass">
					<a href="#">忘记密码？</a>
				</p>
			</div>
		</div>


	</div>
</body>
</html>
