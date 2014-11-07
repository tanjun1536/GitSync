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

		<title>操作结果</title>

		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
<style>
* {margin:0px auto; padding:0}
body{font-family:"微软雅黑", "宋体", Terminal; font-size:16px;}
fieldset{list-style:none; border:none; width:90%; text-align:center; margin-top:20px}
li {padding-top:18px; list-style:none; color:#494949; width:90%}
input, textarea{ color:#666;vertical-align:middle;width:100%;padding:3px; font-size:16px}
label {width:100%; text-align:left; display:block;vertical-align:middle; padding-bottom:5px}

.button {font-size:64px; font-weight:bold; margin-top:20px; width:100px; padding:5px;display: inline-block; color:#FFFFFF;border-radius:22px;border-color:#0f6dbb; border-width:1px;background-color:#207cca;background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#2882ce), color-stop(100%,#0c6abc)); cursor:pointer}
.button:hover{background-color:#4499e1;background:-webkit-gradient(linear, left top, left bottom, color-stop(1%,#4499e1), color-stop(99%,#2882ce)); cursor:pointer}
</style>
</style>
	</head>

	<body>
			<fieldset style="margin-top: 30px">
				<button type="button" class="button">
					${ret.msg}
				</button>
			</fieldset>
	</body>
</html>
