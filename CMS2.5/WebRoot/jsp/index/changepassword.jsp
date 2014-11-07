<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
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
		<title>修改密码</title>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<!--引入jquery-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<script type="text/javascript">
		function validate()
		{
			if ($.trim($("#password").val()) == "") {
				alert("请填写旧密码");
				return false;
			}
			if ($.trim($("#new_password").val()) == "") {
				alert("请填写新密码");
				return false;
			}
			if ($("#new_password").val().length<6) {
				alert("新密码长度不能小于6位");
				return false;
			}
			if ($.trim($("#confirm_new_password").val()) == "") {
				alert("请填写确认新密码");
				return false;
			}
			
			if ($.trim($("#new_password").val()) != $.trim($("#confirm_new_password").val())) {
				alert("两次输入的密码不一致");
				return false;
			}
			
			
			return true
		}
</script>
	</head>
	<style>
* {margin:0px auto; padding:0}
body{font-family:"微软雅黑", "宋体", Terminal; font-size:16px}
fieldset{list-style:none; border:none; width:90%; text-align:center; margin-top:20px}
li {padding-top:18px; list-style:none; color:#494949; width:90%}
input, textarea{ color:#666;vertical-align:middle;width:100%;padding:3px; font-size:16px}
label {width:100%; text-align:left; display:block;vertical-align:middle; padding-bottom:5px}

.button {font-size:15px; font-weight:bold; margin-top:20px; width:100px; padding:5px;display: inline-block; color:#FFFFFF;border-radius:22px;border-color:#0f6dbb; border-width:1px;background-color:#207cca;background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#2882ce), color-stop(100%,#0c6abc)); cursor:pointer}
.button:hover{background-color:#4499e1;background:-webkit-gradient(linear, left top, left bottom, color-stop(1%,#4499e1), color-stop(99%,#2882ce)); cursor:pointer}
</style>

	<body style="margin: auto;">
	<center>
	<form action="<%=basePath%>UserServiceAction!changePassword.action" method="POST" onsubmit="return validate();">
		<input name="user_name" type="hidden" value="${param.user_name}"/>
		<fieldset>
			<ol>
				<li>
					<label for="Feedback">
						原密码:
					</label>
					<input name="password" id="password"  type="password" />
				</li>
				<li>
					<label for="Feedback">
						新密码:
					</label>
					<input name="new_password" id="new_password" type="password" />
				</li>
				<li>
					<label for="Feedback">
						确认新密码:
					</label>
					<input name="confirm_new_password" id="confirm_new_password"  type="password" />
				</li>
				<c:if test="${error!=null}">
				<li>
					<center><div style="color:red;margin-top: 30px">${error }
					</label></div>
					
				</li>
				</c:if>
			</ol>
		</fieldset>
		
		
		
	
		<fieldset style="margin-top: 30px">
			<button type="submit"  class="button">
				提 交
			</button>
		</fieldset>
		</form>
		</center>
	</body>
</html>
