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
		<!-- jquery easyui-->
		<!--弹出窗口-->
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script type="text/javascript">
		var section=null;
		var tabIndex=0;
	
	$(function() {

		//创建选项卡
		$("#tabs").tabs({
			fx : {
				opacity : 'toggle'
			}
		});
		$('#tabs').bind('tabsselect', function(event, ui) {
			// ui.tab     // 被选中（点击后）的选项卡元素
			// ui.panel   //这个元素包含被选中（点击后）的选项卡的内容
			// ui.index   //返回一个被选中（或点击后）选项卡的索引值（从0开始）
			if (ui.index == 0) {
				tabIndex = 0;
			} else if (ui.index == 1) {

				tabIndex = 1;
			} else if (ui.index == 2) {
				tabIndex = 2;
			}
			refreshList(section);
		});
		//等待发布====================================================================================================
		//创建选项卡
		var headers = "编号,发布,分类,标题,焦点,状态";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'distribute', 'w':45}");
		//columns.push("{'n':'view', 'w':45}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left',w:200}");
		columns.push("{'n':'isHot','w':60,'f':getCellValue}");
		columns.push("{'n':'state.name'}");
		//创建操作按钮
		var buttons = new Array();
		buttons.push({"gc" : "distribute","showName" : "发布","action" : "distribute","width" : "16px","height" : "16px"});
		//buttons.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "", "json", headers, columns, 10, "手机焦点待发布列表", undefined, buttons);
		//已经上线====================================================================================================
		//创建选项卡
		var headersOnline = "编号,置顶,下线,分类,标题";
		//创建列
		var columnsOnline = new Array();
		columnsOnline.push("{'n':'id','s':'int','w':10,'h':true}");
		columnsOnline.push("{'n':'toTop', 'w':45}");
		columnsOnline.push("{'n':'view', 'w':45}");
		columnsOnline.push("{'n':'section.name', 'w':120,'a':'left'}");
		columnsOnline.push("{'n':'title','a':'left',w:200}");
		//创建操作按钮
		var buttonsOnline = new Array();
		buttonsOnline.push({"gc" : "toTop","showName" : "置顶","action" : "toTop","width" : "16px","height" : "16px"});
		buttonsOnline.push({"gc" : "view","showName" : "下线","action" : "hiddenf","width" : "16px","height" : "16px"});
		window.jqGrid.createJqGridSeparateButton("#gridTableOnline", "#gridPagerOnline", "", "json", headersOnline, columnsOnline, 10, "手机焦点已发布列表", undefined, buttonsOnline);
		//已经下线====================================================================================================
		//创建选项卡
		var headersOffline = "编号,上线,分类,标题";
		//创建列
		var columnsOffline = new Array();
		columnsOffline.push("{'n':'id','s':'int','w':10,'h':true}");
		columnsOffline.push("{'n':'distribute', 'w':45}");
		columnsOffline.push("{'n':'section.name', 'w':120,'a':'left'}");
		columnsOffline.push("{'n':'title','a':'left',w:200}");
		//创建操作按钮
		var buttonsOffline = new Array();
		buttonsOffline.push({"gc" : "distribute","showName" : "上线","action" : "display","width" : "16px","height" : "16px"});
		window.jqGrid.createJqGridSeparateButton("#gridTableOffline", "#gridPagerOnline", "", "json", headersOffline, columnsOffline, 10, "手机焦点下线列表", undefined, buttonsOffline);

	});
	function getCellValue(value) {
		return value == true ? '是' : '否';
	}

	function toTop(id) {
		$.ajax({
			type : "POST",
			url : "SectionFocusMobileDistributeAction!ajaxToTop.action",
			datatype : "json",
			data : {
				"id" : id
			},
			success : function(msg) {
				jqGrid.reLoad("#gridTableOnline", 'SectionFocusMobileDistributeAction!getSectionFocusMobileHasDistribute.action?section=' + section);
			},
			error : function(msg) {
				alert("删除文章失败!");
			}
		});
	}
	//发布
	function distribute(id) {
		$.ajax({
			type : "POST",
			url : "<%=basePath%>SectionFocusMobileDistributeAction!distribute.action",
			datatype : "json",
			data : {
				'id' : id
			},
			success : function(msg) {
				jqGrid.refresh('#gridTable');
			},
			error : function() {
				alert('发布文章出错!');
			}
		});
	}
	function refreshList(id) {
		section = id;
		var url;
		if (tabIndex == 0) {
			url = 'SectionFocusMobileDistributeAction!getSectionFocusMobilePrepareDistribute.action?section=' + id;
			jqGrid.reLoad("#gridTable", url);
		} else if (tabIndex == 1) {
			url = 'SectionFocusMobileDistributeAction!getSectionFocusMobileHasDistribute.action?section=' + id;
			$("#gridTableOnline").setGridWidth($("#gridTable").width());
			jqGrid.reLoad("#gridTableOnline", url);
		} else {
			url = 'SectionFocusMobileDistributeAction!getSectionFocusMobileHasOffline.action?section=' + id;
			$("#gridTableOffline").setGridWidth($("#gridTable").width());
			jqGrid.reLoad("#gridTableOffline", url);
		}
	}
	function display(id){
			$.ajax({
				type : "POST",
				url : "<%=basePath%>SectionFocusMobileDistributeAction!display.action",
				datatype : "json",
				data : {
					'id' : id
				},
				success : function(msg) {
					var url = 'SectionFocusMobileDistributeAction!getSectionFocusMobilePrepareDistribute.action?section=' + section;
					jqGrid.reLoad("#gridTable", url);
					 url = 'SectionFocusMobileDistributeAction!getSectionFocusMobileHasOffline.action?section=' + section;
					jqGrid.reLoad("#gridTableOffline", url);
				},
				error : function() {
					alert('出错!');
				}
			});
		}
		function hiddenf(id){
			$.ajax({
				type : "POST",
				url : "<%=basePath%>SectionFocusMobileDistributeAction!hidden.action",
				datatype : "json",
				data : {
					'id' : id
				},
				success : function(msg) {
					var url = 'SectionFocusMobileDistributeAction!getSectionFocusMobileHasDistribute.action?section=' + section;
					jqGrid.reLoad("#gridTableOnline", url);
				},
				error : function() {
					alert('出错!');
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
