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
		var headers="编号,用户,内容,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'user.name', 'w':120,'a':'left'}");
		columns.push("{'n':'content','a':'left','w':200}");
		columns.push("{'n':'postDate'}");
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "ArticlePadCommentAction!auditcomments.action?id=${param.id}", "json",headers, columns, 10,"文章评论列表", undefined,[]);
	});
	function pass(){
		var ids = window.jqGrid.getSelected("#gridTable");
		if($.trim(ids) == ""){
			alert("请先选择");
			return;
		}
		fn.openURL('<%=basePath%>ArticlePadCommentAction!pass.action?ids=' + ids);
	}
	function nopass(){
		var ids = window.jqGrid.getSelected("#gridTable");
		if($.trim(ids) == ""){
			alert("请先选择");
			return;
		}
		fn.openURL('<%=basePath%>ArticlePadCommentAction!nopass.action?ids=' + ids);
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
			当前位置：平板审核管理 > 平板文章评论审核
		</div>
		<div class="clear"></div>
		</header>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC;">
				<input type="button" onclick="pass()" value="通过" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				<input type="button" onclick="nopass()" value="不通过" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>