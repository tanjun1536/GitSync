<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@page import="com.gang.entity.log.StateLog"%>
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
		<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
		<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
	$(function() {
		var headers="编号,用户,状态,类别,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'user.name', 'w':120,'a':'left'}");
		columns.push("{'n':'stateName',w:60}");
		columns.push("{'n':'logType', 'w':60, 'f':getCellValue}");
		columns.push("{'n':'date','a':'left',w:200}");
		//创建Grid
		window.jqGrid.createJqGridNoCheckbox("#gridTable", "#gridPager", "StateLogAction!getList.action?type=${param.type}&dataId=${param.dataId}", "json",headers, columns, 10,"日志列表","", undefined, "");
	});
	function getCellValue(value)
	{
		switch(value){
			case <%=StateLog.Mobile_Article%>: return "手机文章";
			case <%=StateLog.Pad_Article%>: return "平板文章";
			default: return "未知";
		}
	}
</script>
		
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
			<tr>
				<td height="20px">
				</td>
			</tr>
			<tr>
				<td valign="top">
					<table id="gridTable">
					</table>
					<div id="gridPager"></div>
				</td>
			</tr>
		</table>

	</body>
</html>
