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
	$(function() {
	   //生成树
		$("#section").combotree();
	
		var headers = "编号,标题,创建时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'title','a':'left','w':300,'f':setImageTitle}");
		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons = new Array();
		//创建Grid    
		window.jqGrid.createJqGridSeparateButton("#list", "#pager", "HotAction!getArticleMobile.action", "json", headers, columns, 10, "文章列表", function(){return false;}, buttons);
	});
	function setImageTitle(cellvalue, options, rowObject){  
		if(rowObject.titleImage)
	    	return "【图】"+cellvalue;  
	   return cellvalue||"";
	};  
	function queryBySection() {
		var url = "HotAction!getArticleMobile.action";
		var sectionId = $("#section").combotree("getValue");
		if (sectionId != '')
			url = "HotAction!getArticleMobile.action?sectionId=" + sectionId;
		jqGrid.reLoad('#list', url );
	}
	function sure()
	{
		var idx=jqGrid.getSelected('#list');
		if(idx==null)
		{
			alert('请选择数据!');
			return false;
		}
		$("#idx").val(idx);
		return true;
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
			当前位置：采编管理 > 热点管理
		</div>
		<div class="sreachdiv">
			<form enctype="application/x-www-form-urlencoded" action="HotAction!save.action" method="post" onsubmit="return sure()">
				<input type="hidden" name="idx" id="idx" />
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input id="section" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
				<input type="button" onclick="queryBySection();" value="筛选" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
		
				<input type="submit"  value="确认" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				
			</div>
			</form>
		</div>
		<table id="list" style="width: 100%; height: 100%;">
		</table>
		<div id="pager"></div>
	</body>
</html>