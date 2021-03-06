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
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<!--引入Grid样式		-->
		<link href="javascript/jquery.jqGrid-4.2.0/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
		<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
	var api = frameElement.api, W = api.opener;
	$(function() {
		//生成树
		$("#section").combotree();
		var headers = "编号,标题,创建时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'title','a':'left',w:300}");
		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons = new Array();
		//创建Grid    
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#list", "#pager", "ArticlePadAction!getPadArt.action?sectionId=${param.sectionId}", "json", headers, columns, 10, "文章列表", onSelected, buttons);
	});
	function onSelected(id) {
		var tObj = W.$.dialog.data('selectedItem');
		tObj.id = this.getCell(id, "id");
		tObj.title = this.getCell(id, "title");
	}
	function queryBySection() {
		var url = "ArticlePadAction!getPadArt.action";
		var sectionId = $("#section").combotree("getValue");
		if (sectionId != '')
			url = "ArticlePadAction!getPadArt.action?sectionId=" + sectionId;
		jqGrid.reLoad('#list', url);
	}
</script>
	</head>
	<body>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input id="section" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
				<input type="button" onclick="queryBySection();" value="筛选" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		<table id="list" style="width: 100%; height: 100%;">
		</table>
		<div id="pager"></div>
	</body>
</html>