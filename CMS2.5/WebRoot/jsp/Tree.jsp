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
		<!--引入Grid样式		-->
		<link rel="STYLESHEET" type="text/css" href="javascript/dhtmlxTree/codebase/dhtmlxtree.css">
		<script src="javascript/dhtmlxTree/codebase/dhtmlxcommon.js"></script>
		<script src="javascript/dhtmlxTree/codebase/dhtmlxtree.js"></script>
		<script type="text/javascript">
		$(function() {
	
			var tree = new dhtmlXTreeObject("treeboxbox_tree", "100%", "100%", 0);
			tree.setSkin('dhx_skyblue');
			tree.setImagePath("javascript/dhtmlxTree/codebase/imgs/csh_dhx_skyblue/");
			tree.setXMLAutoLoading("section!getSectionTree.action");
			tree.loadXML("section!getSectionTree.action");
		});
</script>
		
	</head>
	<body>
		<div id="treeboxbox_tree" style="width: 250px; height: 218px; background-color: #f5f5f5; border: 1px solid Silver;; overflow: auto;" />
	</body>
</html>
