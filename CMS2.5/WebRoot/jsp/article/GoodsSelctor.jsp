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
<title>相当fuck</title>
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
		<script type="text/javascript" src="javascript/lhgdialog/lhgcore.lhgdialog.min.js\?skin=mac"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
			var api = frameElement.api, W = api.opener; // api.opener 为载加lhgdialog.min.js文件的页面的window对象
			var ams=new Array();
			var container;
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
				container = W.$.dialog.data('container');
				W.$(container).find("li").each(function(){
					ams.push($(this).attr("id"));
				});
				window.jqGrid.createJqGridSeparateButton("#list", "#pager", "ArticleMobileAction!getRelatedGoods.action?sectionId=${param.sectionId}&ams="+ams.join(","), "json", headers, columns, 10, "文章列表", undefined, buttons);
				$("#list").setGridWidth(880);
			});
			function ok()
			{
				var tab = $("#list");
				var array = tab.getGridParam("selarrrow");
				if (array) {
					for ( var i = 0; i < array.length; i++) {
						var o = tab.getRowData(array[i]);
						W.$(container).append('<li id="' + o.id + '"><label class="label"></label>' + o.title + '<div style="float:right" ><img src="images/close.png" onclick="$(this).parent().parent().remove();" title="删除" style="cursor:pointer" /></div></li> ');
					}
	
				}
				api.close();
			}

			function queryBySection() {
				var url = "ArticleMobileAction!getRelatedGoods.action";
				var sectionId = $("#section").combotree("getValue");
				if (sectionId != '')
				{
					url = "ArticleMobileAction!getRelatedGoods.action?sectionId=" + sectionId;
					if(ams.length>0) 
					{
						url+="&ams="+ams.join(',');
					}
				}
				else
				{
					if(ams.length>0) 
					{
						url+="?ams="+ams.join(',');
					}
				}
				
				jqGrid.reLoad('#list', url);
			}
		</script>
</head>
<body >
	<div class="sreachdiv">
		<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
			<input id="section" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
			 <input type="button" onclick="queryBySection();" value="筛选" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			 <input type="button" onclick="ok();" value="确定选择" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
		</div>
	</div>
	<table id="list" >
	</table>
	<div id="pager"></div>
</body>
</html>