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
		<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<!--引入Grid样式		-->
		<link href="javascript/jquery.jqGrid-4.2.0/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/ui-lightness/jquery-ui-1.8.16.custom.css" />
		<!--		<link rel="stylesheet" href="jquery/jqGrid/css/CRselectBox.css" type="text/css" />-->
		<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
	$(function() {
	//table, pager, url, datatype, headers, columns, pagesize, caption, buttons, srfunction, functions
		window.jqGrid.createJqGrid("#gridTable","#gridPager", "templateAction!getFactor.action?id=${id}", "json", "编号,名称,排序", "{'n':'id','s':'int','w':10}|{'n':'name','s':'string'}|{'n':'orderNumber','s':'int'}", 10,"因素(说明：选择行查看子因素)");
	});
	//因素列表点击事件
	function onRowClick(iRow) {

	}
</script>
		
	</head>
	<body>
		<table id="gridTable">
		</table>
		<div id="gridPager"></div>
	</body>
</html>
