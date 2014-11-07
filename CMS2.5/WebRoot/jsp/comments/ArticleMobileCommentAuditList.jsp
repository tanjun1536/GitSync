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
		<!-- jquery easyui-->
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script src="javascript/My97DatePicker/WdatePicker.js" type="text/javascript"></script>
		<!--弹出窗口-->
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script type="text/javascript">
	var tree;
	$(function() {
		var headers="编号,审核,分类,标题,焦点,访问,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'audit', 'w':45}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left','w':200}");
		columns.push("{'n':'isHot','w':60,'f':getCellValue}");
		columns.push("{'n':'browseCount', 'w':60}");
		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"audit","showName":"审核","action":"audit","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "ArticleMobileCommentAction!getList.action", "json",headers, columns, 10,"文章列表", undefined,buttons);
	});
	function getCellValue(value)
	{
		return value==true?'是':'否';
	}
	function audit(id)
	{
		fn.openURL('<%=basePath%>jsp/comments/ArticleMobileCommentList.jsp?id=' + id);
	}
</script>
		
	</head>
	<body>
	<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：手机审核管理 > 手机文章评论审核
		</div>
		<div class="clear"></div>
		</header>
		<div class="sreachdiv">
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>