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
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script type="text/javascript">
			$(function() {
			$("#section").tree({
				checkbox: false,
				url: 'SectionAction!getSections.action',
				onClick:function(node){
					jqGrid.reLoad('#gridTable','SectionFocusMobileDistributeAction!getSectionFocusMobileHasDistribute.action?section='+node.id);
					
				},
				//右键鼠标事件
				onContextMenu: function(e, node){ 
					e.preventDefault();
					$('#section').tree('select', node.target);
				}
		  });
			//创建选项卡
			var headers="编号,上线,下线,分类,标题,焦点,状态";
			//创建列
			var columns = new Array();
			columns.push("{'n':'id','s':'int','w':10,'h':true}");
			columns.push("{'n':'distribute', 'w':45}");
			columns.push("{'n':'view', 'w':45}");
			columns.push("{'n':'section.name', 'w':120,'a':'left'}");
			columns.push("{'n':'title','a':'left',w:200}");
			columns.push("{'n':'isHot','w':60,'f':getCellValue}");
			columns.push("{'n':'state.name'}");
			//创建操作按钮
			var buttons=new Array();
			buttons.push({"gc":"distribute","showName":"上线","action":"display","width":"16px","height":"16px"});
			buttons.push({"gc":"view","showName":"下线","action":"hiddenf","width":"16px","height":"16px"});
			window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "", "json",headers, columns, 10,"手机焦点未发布列表", undefined,buttons);
		});
		function getCellValue(value)
		{
			return value==true?'是':'否';
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
					jqGrid.refresh('#gridTable');
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
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('出错!');
				}
			});
		}
	</script>
		
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
			<tr>
				<td width="150" valign="top">
					<ul id="section"></ul>
				</td>
				<td valign="top">
					<table id="gridTable">
					</table>
					<div id="gridPager"></div>
				</td>
			</tr>
		</table>
	</body>
</html>
