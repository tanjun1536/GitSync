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
		var headers="编号,删除,反馈内容,反馈时间,联系方式,客户端类型";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'delete', 'w':50}");
		columns.push("{'n':'content'}");
		columns.push("{'n':'createDate', 'w':60}");
		columns.push("{'n':'linkmethod', 'w':60}");
		columns.push("{'n':'clientType', 'w':60}");
		
		var buttons=new Array();
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "FeedBackAction!getList.action", "json",headers, columns, 10,"用户反馈列表", undefined,buttons);
		
		
	});
	//添加
	function addAtricle()
	{
		fn.openURL("<%=basePath%>ArticleMobileAction!add.action");
	}
	//修改
	function update(id) {
		fn.openURL("<%=basePath%>ArticleMobileAction!edit.action?id=" + id);
	}
	//删除
	function del(id) {
		if (confirm("是否删除该记录？")) {
			$.ajax({
				type : "POST",
				url : "FeedBackAction!ajaxDelete.action",
				datatype : "json",
				data : {
					'id' : id
				},
				success : function(msg) {
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('删除出错!');
				}
			});
		}
	}
	//删除
	function batchdel() {
		var ids = window.jqGrid.getSelected("#gridTable");
		if (ids == '') {
			alert("请选择要删除的文章");
			return;
		}
		if (confirm("确认要删除选择的文章吗？")) {
			$.ajax({
				type : "POST",
				url : "ArticleMobileAction!ajaxBatchDelete.action",
				datatype : "json",
				data : {
					'ids' : ids
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
	function view(id) {
		$.dialog({
		id:'preview',
		content:"url:<%=basePath%>jsp/article/ArticlePreview.jsp?type=mobile&articleId="+id,
		max:false,
		min:false,
		width:'700px',
		height:500,
		drag:false,
		resize:false
		});			
	}
	function showlog(id){
		fn.openURL("<%=basePath%>jsp/log/StateLogList.jsp?type=<%=StateLog.Mobile_Article%>&dataId=" + id);
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
			当前位置：系统管理 > 用户反馈管理
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>
