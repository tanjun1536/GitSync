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
		<script type="text/javascript">
	var tree;
	$(function() {
		var headers="编号,历史,审核,分类,标题,状态";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'history', 'w':35}");
		columns.push("{'n':'audit', 'w':35}");
		//columns.push("{'n':'back', 'w':35}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left',w:200}");
		columns.push("{'n':'state.name'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"history","showName":"历史","action":"history","width":"16px","height":"16px"});
		buttons.push({"gc":"audit","showName":"审核","action":"next","width":"16px","height":"16px"});
		//buttons.push({"gc":"back","showName":"驳回","action":"reject","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "PadSectionFocusAuditAction!getList.action?state=${param.state}", "json",headers, columns, 10,"审核列表", undefined,buttons);
		//绑定新建按钮点击事件
		
	});
	//审核下一步
	function next(id) {
		/*if (confirm("是否通过审核？")) {
			fn.openURL('PadSectionFocusAuditAction!auditNext.action?id=' + id + "&state=${param.state}");
		}*/
		fn.openURL('<%=basePath%>PadSectionFocusAuditAction!audit.action?id=' + id);
	}
	//删除
	function reject(id) {
		if (confirm("是否要驳回？")) {
			fn.openURL("<%=basePath%>PadSectionFocusAuditAction!toReject.action?id=" + id + "&state=${param.state}");
		}
	}
	function history(id){
		fn.openURL("<%=basePath%>PadFocusAuditHistory.action?id=" + id + "&state=${param.state}");
	}
</script>
		
	</head>
	<body>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：平板审核管理 > 平板栏目焦点审核
		</div>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>
