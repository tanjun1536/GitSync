<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<base href="<%=basePath%>">

		<title>用户注册</title>

		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<!--引入jquery-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<script type="text/javascript">
	function validate() {
		if ($.trim($("#username").val()) == "") {
			//alert("请填写用户名");
			return false;
		}
		if ($.trim($("#password").val()) == "") {
			//alert("请填写密码");
			return false;
		}
		if ($.trim($("#nickname").val()) == "") {
			//alert("请填写昵称");
			return false;
		}
//		if ($.trim($("#rpassword").val()) == "") {
//			alert("请填写确认密码");
//			return false;
//		}
//		if ($.trim($("#rpassword").val()) != $.trim($("#password").val())) {
//			alert("确认密码和密码不相同");
//			return false;
//		}
//		if ($.trim($("#emial").val()) == "") {
//			alert("请填写邮箱地址");
//			return false;
//		}
		return true;
	}

	function regist() {
		if (!validator()) {
			return;
		}
		var username = $.trim($("#username").val());
		var password = $.trim($("#password").val());
		var nickname = $.trim($("#nickname").val());
		$.ajax({
			url : 'FrontUserAction!register.action',
			type : 'post',
			dataType : 'json',
			data : {
				t : (new Date()).valueOf(),
				"user.loginName" : username,
				"user.loginPassword" : password,
				"user.nickName" : nickname
			},
			timeout : 30000,
			async : true,//使用同步
			beforeSend : function() {
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {

			},
			success : function(res) {
				alert(res.msg);
			},
			complete : function(XMLHttpRequest, textStatus) {
				//this; // 调用本次AJAX请求时传递的options参数
			}
		});
	}
</script>
<style>
* {margin:0px auto; padding:0}
body{font-family:"微软雅黑", "宋体", Terminal; font-size:16px;}
fieldset{list-style:none; border:none; width:90%; text-align:center; margin-top:20px}
li {padding-top:18px; list-style:none; color:#494949; width:90%}
input, textarea{ color:#666;vertical-align:middle;width:60%;padding:3px; font-size:16px}
label {width:100%; text-align:left; display:block;vertical-align:middle; padding-bottom:5px}

.button {font-size:15px; font-weight:bold; margin-top:20px; width:100px; padding:5px;display: inline-block; color:#FFFFFF;border-radius:22px;border-color:#0f6dbb; border-width:1px;background-color:#207cca;background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#2882ce), color-stop(100%,#0c6abc)); cursor:pointer}
.button:hover{background-color:#4499e1;background:-webkit-gradient(linear, left top, left bottom, color-stop(1%,#4499e1), color-stop(99%,#2882ce)); cursor:pointer}
</style>
</style>
	</head>

	<body>
		<form action="FrontUserAction!register.action" method="POST" onsubmit="return validate();">
			<input name="user.userType" type="hidden" value="phone"/>
			<fieldset>
				<ol>
					<li>
						<label for="username">
							帐号:
						</label>
						<input id="username" name="user.loginName" type="text" placeholder="请输入用户名" />
					</li>
					<li>
						<label for="nickname">
							昵称:
						</label>
						<input id="nickname" name="user.nickName" type="text" placeholder="6-12个字符" />
					</li>
					<li>
						<label for="password">
							密码:
						</label>
						<input id="password" name="user.loginPassword" type="password" />
					</li>
				</ol>
			</fieldset>

			<fieldset style="margin-top: 30px">
				<button type="submit"  class="button">
					马上注册
				</button>
			</fieldset>
		</form>
	</body>
</html>
