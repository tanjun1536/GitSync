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
		$(function() {
			//创建选项卡
			$("#tabs").tabs();
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
			当前位置：文章发布管理 > 手机焦点发布管理
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
				<iframe id="tabs" src="jsp/distribute/SectionFocusMobileDistributeTabs.jsp" height ="1610px" frameborder="0" style="width: 100%;"></iframe>
			</div>
		</div>
		
		<ul id="section"></ul>
		<div id=tabs>
			<ul>
				<li>
					<a href="#tabs-1">未发布焦点</a>
				</li>
				<li>
					<a href="#tabs-2">已发布焦点</a>
				</li>
			</ul>
			<div id=tabs-1>
			<iframe frameborder="0" width="100%" height="570" src="jsp/distribute/SectionFocusMobileDistributeBefore.jsp"></iframe>
			</div>
			<div id=tabs-2>
			<iframe frameborder="0" width="100%" height="570" src="jsp/distribute/SectionFocusMobileDistributeAfter.jsp"></iframe>
			</div>
		</div>
	</body>
</html>
