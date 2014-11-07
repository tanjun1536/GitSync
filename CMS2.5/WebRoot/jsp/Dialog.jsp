<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<link type="text/css" rel="stylesheet" href="css/style.css" />
		<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script type="text/javascript">
		$(function() {
			$("#dialog").click(function(){
				$.dialog({
				id:'preview',
				content:"url:http://www.baidu.com",
				max:false,
				min:false,
				width:'700px',
				height:500,
				drag:false,
				resize:false
				});			
			});
			
		});
</script>
		
	</head>
	<body>
		<input type="button" style="width: 200px; height: 200px" id="dialog" />
	</body>
</html>
