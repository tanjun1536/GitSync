<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
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
				<link href="css/style.css" rel="stylesheet" type="text/css" />
				<!-- jquery easyui-->
				<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
				<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
				<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
				<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>

				<!--引入Grid样式		-->
				<link href="javascript/jquery.jqGrid-4.2.0/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
				<link href="css/style.css" rel="stylesheet" type="text/css" />
				<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
				<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
				<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
				<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
				<!--弹出窗口-->
				<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
				<script src="javascript/jqGrid.js" type="text/javascript"></script>
				<script src="javascript/base.js" type="text/javascript"></script>
				<script type="text/javascript">
				var section=null;
				var type='mobile';
	$(function() {
		$("#section").tree({
			checkbox : false,
			url : 'SectionAction!getSections.action',
			onClick : function(node) {
				section = node.id;
				if(type=='mobile')
					jqGrid.reLoad('#gridTable', 'ArticleMobileAction!getOnlineArticleMobiles.action?sectionId=' + section);
				else
					jqGrid.reLoad('#gridTableImage', 'ArticleMobileAction!getOnlineArticleImages.action?sectionId=' + section);

			},
			//右键鼠标事件
			onContextMenu : function(e, node) {
				e.preventDefault();
				$('#section').tree('select', node.target);
			}
		});
		//创建选项卡
		$("#tabs").tabs({
			fx : {
				opacity : 'toggle'
			}
		});

		var headers = "编号,上下线,分类,标题,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'onLineFlag', 'w':35}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left',w:200}");
		columns.push("{'n':'createDate'}");

		var buttons = new Array();
		buttons.push({
			"gc" : "onLineFlag",
			"showName" : "上线",
			"action" : "onOffLine",
			"width" : "16px",
			"height" : "16px","textFormatter":setButtonName
		});
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "ArticleMobileAction!getOnlineArticleMobiles.action", "json", headers, columns, 10, "手机图文文章列表", undefined, buttons);

		$('#tabs').bind('tabsselect', function(event, ui) {
			// ui.tab     // 被选中（点击后）的选项卡元素
			// ui.panel   //这个元素包含被选中（点击后）的选项卡的内容
			// ui.index   //返回一个被选中（或点击后）选项卡的索引值（从0开始）
			if (ui.index == 1) {
				$("#gridTableImage").setGridWidth($("#gridTable").width());
				type='mobileImage';
			}
			else
			{
				type='mobile';
			}
		});
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTableImage", "#gridPagerImagePager", "ArticleMobileAction!getOnlineArticleImages.action", "json", headers, columns, 10, "手机图片文章列表", undefined, buttons);

	});
	function setButtonName(data,button)
	{
		var text="上线";
		if(data==1)
			text="下线";
		button.showName=text;
		return button;
	}
	function onOffLine(id)
	{
		$.ajax({
					type : "POST",
					url : "ArticleMobileAction!changeOnLineState.action",
					datatype : "json",
					data : {
						"id" : id,'type':type
					},
					success : function(msg) {
						if(type=='mobile')
							jqGrid.reLoad('#gridTable', 'ArticleMobileAction!getOnlineArticleMobiles.action?section=' + section);
						else
							jqGrid.reLoad('#gridTableImage', 'ArticleMobileAction!getOnlineArticleImages.action?section=' + section);

					},
					error:function(msg)
					{
						alert(msg);
					}
				});
	}
	//发布
	function view() {
	}
</script>
				
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
			<tr>
				<td height="20px" colspan="3">
					<input type="button" value="查询" />
				</td>
			</tr>
			<tr>
				<td width="150" valign="top">
					<ul id="section"></ul>
				</td>
				<td valign="top">
					<div id="tabs">
						<ul>
							<li>
								<a href="#tabs-1">图文文章</a>
							</li>
							<li>
								<a href="#tabs-2">图片文章</a>
							</li>
						</ul>
						<div id="tabs-1">
							<table id="gridTable">
							</table>
							<div id="gridPager"></div>
						</div>
						<div id="tabs-2">
							<table id="gridTableImage">
							</table>
							<div id="gridPagerImagePager"></div>
						</div>
					</div>
				</td>
			</tr>
		</table>


	</body>
</html>





