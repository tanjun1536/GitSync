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
		var headers="编号,删除,用户,内容,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'delete', 'w':50}");
		columns.push("{'n':'user.loginName', 'w':120,'a':'left'}");
		columns.push("{'n':'content','a':'left','w':200}");
		columns.push("{'n':'postDate'}");
		//创建Grid
		var buttons=new Array();
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "ArticleMobileCommentAction!getComments.action?id=${param.id}", "json",headers, columns, 10,"文章评论列表", undefined,buttons);
		
		//setTimeout('function(){$("#gridTable").setGridWidth($("body").width()}',1000);
	});
	function del(id) {
		if (confirm("是否删除该记录？")) {
			$.ajax({
				type : "POST",
				url : "ArticleMobileCommentAction!ajaxDelete.action",
				datatype : "json",
				data : {
					'id' : id
				},
				success : function(msg) {
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('删除文章出错!');
				}
			});
		}
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
			当前位置：手机文章管理 > 手机文章评论查看
		</div>
		<div class="clear"></div>
		</header>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>