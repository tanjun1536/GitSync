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
		<script type="text/javascript">
				var section=null;
	$(function() {
		$("#tabs").tabs({
			fx : {
				opacity : 'toggle'
			}
		});
		$('#tabs').bind('tabsselect', function(event, ui) {
			// ui.tab     // 被选中（点击后）的选项卡元素
			// ui.panel   //这个元素包含被选中（点击后）的选项卡的内容
			// ui.index   //返回一个被选中（或点击后）选项卡的索引值（从0开始）
			if(ui.index==0)
			{
				tabIndex=0;
			}
			else if (ui.index == 1) {
			
				tabIndex=1;
			}
			else if (ui.index ==2)
			{
				tabIndex=2;	
			}
			refreshList(section);
		});
		var headers="编号,预览,发布,删除,标题,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'view', 'w':15,'h':true}");
		columns.push("{'n':'distribute', 'w':15}");
		columns.push("{'n':'del', 'w':15}");
		columns.push("{'n':'title','a':'left',w:100}");
		columns.push("{'n':'createDate','w':55}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		buttons.push({"gc":"distribute","showName":"发布","action":"distribute","width":"16px","height":"16px"});
		buttons.push({"gc":"del","showName":"删除","action":"del","width":"16px","height":"16px"});
		//创建Grid
		var headersOnline="编号,预览,下线,标题,时间";
		//创建列
		var columnsOnline = new Array();
		columnsOnline.push("{'n':'id','s':'int','w':10,'h':true}");
		columnsOnline.push("{'n':'view', 'w':15,'h':true}");
		columnsOnline.push("{'n':'offLine', 'w':15}");
		columnsOnline.push("{'n':'title','a':'left',w:100}");
		columnsOnline.push("{'n':'createDate','w':55}");

		//创建操作按钮
		var buttonsOnline=new Array();
		buttonsOnline.push({"gc":"offLine","showName":"下线","action":"offLine","width":"16px","height":"16px"});
		buttonsOnline.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		buttonsOnline.push({"gc":"del","showName":"删除","action":"del","width":"16px","height":"16px"});
		
		var headersOffline="编号,预览,删除,标题,时间";
		//创建列
		var columnsOffline = new Array();
		columnsOffline.push("{'n':'id','s':'int','w':10,'h':true}");
		columnsOffline.push("{'n':'view', 'w':15,'h':true}");
		columnsOffline.push("{'n':'del', 'w':15}");
		columnsOffline.push("{'n':'title','a':'left',w:100}");
		columnsOffline.push("{'n':'createDate','w':55}");
		//创建上线操作按钮
		var buttonsOnline=new Array();
		buttonsOnline.push({"gc":"offLine","showName":"下线","action":"offLine","width":"16px","height":"16px"});
		buttonsOnline.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		//创建下线操作按钮
		var buttonsOffline=new Array();
		buttonsOffline.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		buttonsOffline.push({"gc":"del","showName":"删除","action":"del","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "PadPageLayoutAction!getPrepareDistributePages.action", "json",headers, columns, 10,"等待发布的排版", undefined,buttons);
		window.jqGrid.createJqGridSeparateButton("#gridTableOnline", "#gridPagerOnline", "PadPageLayoutAction!getOnlinePadPages.action", "json",headersOnline, columnsOnline, 10,"已经发布的排版", undefined,buttonsOnline);
		window.jqGrid.createJqGridSeparateButton("#gridTableOffline", "#gridPagerOffline", "PadPageLayoutAction!getOfflinePadPages.action", "json",headersOffline, columnsOffline, 10,"已经下线的排版", undefined,buttonsOffline);
		
	});
	function refreshList(id)
	{
		section=id;
		var url;
		if(tabIndex==0)
		{
			 url='PadPageLayoutAction!getPrepareDistributePages.action?sectionId='+id; 
			jqGrid.reLoad("#gridTable",url);
		}
		else if(tabIndex==1)
		{
			url='PadPageLayoutAction!getOnlinePadPages.action?sectionId='+id; 
			$("#gridTableOnline").setGridWidth($("#gridTable").width());
			jqGrid.reLoad("#gridTableOnline",url);
		}
		else
		{
			 url='PadPageLayoutAction!getOfflinePadPages.action?sectionId='+id;  
			 $("#gridTableOffline").setGridWidth($("#gridTable").width());
			 jqGrid.reLoad("#gridTableOffline",url);
		}
	}
	function getState(cellValue)
	{
		return cellValue==1?'上线':'下线';
	}
	//发布
	function distribute(id) {
		$.ajax({
				type : "POST",
				url : "ArticlePadDistributeAction!distribute.action?layoutId=" + id,
				datatype : "json",
				success : function(msg) {
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('发布出错!');
				}
			});
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
					jqGrid.refresh('#gridTableOnline');
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
		content:'url:<%=basePath%>jsp/layout/PadPageLayoutPreview.jsp?layoutId=' + id,
			max : false,
			min : false,
			width : 800,
			height : 500,
			drag : false,
			resize : false,
			okVal : '发布',
			ok : function() {
				distribute(id);
			},
			cancelVal : '取消',
			cancel : function() {
			}
		});
	}
	function offLine(id) {
		$.ajax({
			type : "POST",
			url : "PadPageLayoutAction!OffLinePadPage.action",
			datatype : "json",
			data : {
				"id" : id
			},
			success : function(msg) {
				jqGrid.refresh('#gridTableOnline');

			},
			error : function(msg) {
				alert(msg);
			}
		});
	}
</script>
	</head>
	<body>
		<div id=tabs>
			<ul>
				<li>
					<a href="#tabs-1">等待发布</a>
				</li>
				<li>
					<a href="#tabs-2">已经发布</a>
				</li>
				<li>
					<a href="#tabs-3">已经下线</a>
				</li>
			</ul>
			<div id=tabs-1>
				<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
					<tr>
						<td valign="top">
							<table id="gridTable">
							</table>
							<div id="gridPager"></div>
						</td>
					</tr>
				</table>
			</div>
			<div id=tabs-2>
				<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
					<tr>
						<td valign="top">
							<table id="gridTableOnline">
							</table>
							<div id="gridPagerOnline"></div>
						</td>
					</tr>
				</table>
			</div>
			<div id=tabs-3>
				<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
					<tr>
						<td valign="top">
							<table id="gridTableOffline">
							</table>
							<div id="gridPagerOffline"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
