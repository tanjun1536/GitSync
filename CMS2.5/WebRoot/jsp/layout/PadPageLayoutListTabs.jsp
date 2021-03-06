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
		<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
		<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<!--弹出窗口-->
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<!-- jquery easyui-->
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script type="text/javascript">
	var section=null;
		$(function() {
		var headers="编号,预览,编辑,删除,标题,时间,状态";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'view', 'w':15}");
		columns.push("{'n':'edit', 'w':15}");
		columns.push("{'n':'del', 'w':15}");
		columns.push("{'n':'title','a':'left',w:100}");
		columns.push("{'n':'createDate','w':55}");
		columns.push("{'n':'state','w':40,f:getState}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		buttons.push({"gc":"edit","showName":"编辑","action":"edit","width":"16px","height":"16px"});
		buttons.push({"gc":"del","showName":"删除","action":"del","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "PadPageLayoutAction!getList.action?section=${param.section}", "json",headers, columns, 10,"iPad文章列表版面管理", undefined,buttons);
		
	});

	function refreshList(id) {
		section = id;
		var url = 'PadPageLayoutAction!getList.action?section=' + id;
		jqGrid.reLoad("#gridTable", url);
	}
	function getState(cellValue) {
		if (cellValue == 0)
			return '编辑';
		else
			return cellValue == -1 ? '下线' : '发布';
	}
	function add() {
		if (section == null) {
			alert("请选择栏目");
			return;
		}
		fn.openParentURL('<%=basePath%>PadPageLayoutAction!add.action?section='+section);
	}
	function edit(id)
	{
		fn.openParentURL('<%=basePath%>PadPageLayoutAction!edit.action?id='+id);
	}
	function del(id)
	{
		if (confirm("是否删除该记录？")) {
			$.ajax({
				type : "POST",
				url : "PadPageLayoutAction!ajaxDelete.action",
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
	//发布
	function view(id) {
		$.dialog({
		id:'preview', 
		content:'url:<%=basePath%>jsp/layout/PadPageLayoutPreview.jsp?layoutId=' + id,
			max : false,
			min : false,
			width : 800,
			height : 500,
			drag : true,
			resize : false
		});
	}
</script>
	</head>
	<body>
		<table id="gridTable">
		</table>
		<div id="gridPager"></div>
	</body>
</html>
