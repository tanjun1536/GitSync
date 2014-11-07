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
		<title>密码修改</title>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<script>
		window.onload=function(){window.top.location.href='http://ictiy:userpasswordchanged';};
		</script>
	</head>
	<style>
* {margin:0px auto; padding:0}
body{font-family:"微软雅黑", "宋体", Terminal; font-size:18px}
</style>

	<body>
	<br />
	<br />
	<br />
		<center>
		密码修改成功
		</center>
	</body>
</html>
