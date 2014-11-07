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
	$(function() {
	
//		$("#section").tree({
//				checkbox: false,
//				url: 'SectionAction!getSections.action',
//				onClick:function(node){
//					section=node.id;
//					jqGrid.reLoad('#gridTable','ArticleMobileDistributeAction!getArticleMobilePrepareDistribute.action?section='+section);
//					
//				},
//				//右键鼠标事件
//				onContextMenu: function(e, node){ 
//					e.preventDefault();
//					$('#section').tree('select', node.target);
//				}
//		  });
		//创建选项卡
		$("#tabs").tabs();
		var headers="编号,发布,预览,分类,标题,焦点,访问,时间,状态";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'distribute', 'w':45}");
		columns.push("{'n':'view', 'w':45}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left',w:200}");
		columns.push("{'n':'isHot','w':60,'f':getCellValue}");
		columns.push("{'n':'browseCount', 'w':60}");
		columns.push("{'n':'createDate'}");
		columns.push("{'n':'state.name'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"distribute","showName":"发布","action":"distribute","width":"16px","height":"16px"});
		buttons.push({"gc":"view","showName":"预览","action":"view","width":"16px","height":"16px"});
		//创建列
		var columnsImage = new Array();
		columnsImage.push("{'n':'id','s':'int','w':10,'h':true}");
		columnsImage.push("{'n':'distributeImage', 'w':45}");
		columnsImage.push("{'n':'viewImage', 'w':45}");
		columnsImage.push("{'n':'section.name', 'w':120,'a':'left'}");
		columnsImage.push("{'n':'title','a':'left',w:200}");
		columnsImage.push("{'n':'isHot','w':60,'f':getCellValue}");
		columnsImage.push("{'n':'browseCount', 'w':60}");
		columnsImage.push("{'n':'createDate'}");
		columnsImage.push("{'n':'state.name'}");
		//创建操作按钮
		var buttonsImage=new Array();
		buttonsImage.push({"gc":"distributeImage","showName":"发布","action":"distributeImage","width":"16px","height":"16px"});
		buttonsImage.push({"gc":"viewImage","showName":"预览","action":"viewImage","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "ArticleMobileDistributeAction!getArticleMobilePrepareDistribute.action", "json",headers, columns, 10,"手机图文文章发布", undefined,buttons);
		window.jqGrid.createJqGridSeparateButton("#gridTableImage", "#gridPagerImage", "ArticleMobileDistributeAction!getMobileImageContentPrepareDistribute.action", "json",headers, columnsImage, 10,"手机图片文章发布", undefined,buttonsImage);
		
	});
	function getCellValue(value)
	{
		return value==true?'是':'否';
	}
	//发布
	function distribute(id) {
		$.ajax({
				type : "POST",
				url : "<%=basePath%>ArticleMobileDistributeAction!distribute.action",
				datatype : "json",
				data : {
					'id' : id,'type':'mobile'
				},
				success : function(msg) {
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('发布文章出错!');
				}
			});
	}
	function view(id) {
		$.dialog({
		id:'preview',
		content:'url:<%=basePath%>jsp/article/ArticlePreview.jsp?type=mobile&articleId=' + id,
			max : false,
			min : false,
			width : '700px',
			height : 500,
			drag : false,
			resize : false
		});
	}
	//发布
	function distributeImage(id) {
		$.ajax({
				type : "POST",
				url : "<%=basePath%>ArticleMobileDistributeAction!distribute.action",
				datatype : "json",
				data : {
					'id' : id,'type':'mobileImage'
				},
				success : function(msg) {
					jqGrid.refresh('#gridTableImage');
				},
				error : function() {
					alert('发布文章出错!');
				}
			});
	}
	function viewImage(id) {
		$.dialog({
		id:'preview',
		content:'url:<%=basePath%>jsp/article/ArticlePreview.jsp?type=mobileImage&articleId=' + id,
			max : false,
			min : false,
			width : '700px',
			height : 500,
			drag : false,
			resize : false
		});
	}
</script>
		
	</head>
	<body>
		<ul id="section"></ul>
		<div id=tabs>
			<ul>
				<li>
					<a href="#tabs-1">图文文章</a>
				</li>
				<li>
					<a href="#tabs-2">图片文章</a>
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
							<table id="gridTableImage">
							</table>
							<div id="gridPagerImage"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>


	</body>
</html>
