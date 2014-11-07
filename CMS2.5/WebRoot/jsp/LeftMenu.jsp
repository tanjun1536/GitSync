<%@page import="com.gang.comms.SpringContextUtil"%>
<%@page import="com.gang.service.system.SystemService"%>
<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>" target="mainFrame">
		<link type="text/css" rel="stylesheet" href="css/style.css" />
		<style type="text/css">
body {
	margin: 0;
	font-family: "宋体";
	/*background: #ededed;*/
	font-size: 12px
}

a:link {
	color: #036;
	text-decoration: none
}

a:visited {
	color: #036;
	text-decoration: none
}

a:hover {
	text-decoration: underline
}

#menuTop {
	height: 25px;
	background-image: url(images/left_top.jpg);
	background-repeat: repeat-x;
}

#menu {
	list-style:none;
	line-height:24px;
	color:white;
	margin-top:2px;
	width:180px;
}

#menu .dh {
	background-image:url(images/left_menu_head.jpg);
	height:25px;
	background-repeat:repeat-x;
	display:block;
	color:#003366;
	font-weight:bold;
	
	
	margin-left:-40px	
}
#menu .dd {
	list-style:none;
	margin-left:-20px;
	}
</style>
		
	</head>
	<body>
		<div id="menuTop"></div>
		<ul id="menu">
			<%
				SystemService sevices = (SystemService) SpringContextUtil.getBean("SystemService");
			%>
			<%=sevices.getSystemMenu(sevices.getRoleIds(session))%>
		</ul>
	</body>
</html>
