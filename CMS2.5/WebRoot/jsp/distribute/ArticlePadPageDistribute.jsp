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
		<!--弹出窗口-->
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script type="text/javascript">
			$(function() {
		$("#section").tree({
				checkbox: false,
				url: 'SectionAction!getSectionsByType.action?type=1',
				onClick:function(node){
					 $("#tabs").each(function(index) {try { this.contentWindow.refreshList(node.id); } catch (e) { } });
				},
				//右键鼠标事件
				onContextMenu: function(e, node){ 
					e.preventDefault();
					$('#section').tree('select', node.target);
				}
		  });
		
	});
</script>
	</head>
	<body>
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：文章发布管理 > 平板文章整版发布
		</div>
		<div class="clear"></div>
		</header>
		<div class="Imgdiv">
			<div class="ImgdivL">
				<p class="title" style="font-size: 14px; font-weight: bold">
					我的栏目
				</p>
				<div style="padding: 10px">
					<ul id="section"></ul>
				</div>
			</div>
			<div class="ImgdivR">
				<iframe id="tabs" src="jsp/distribute/ArticlePadPageDistributeTabs.jsp" height="1610px" frameborder="0" style="width: 100%;"></iframe>
			</div>
		</div>
	</body>
</html>
