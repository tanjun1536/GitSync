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
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<!-- jquery easyui-->
		<!--弹出窗口-->
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script type="text/javascript">
		$(function() {
			//创建选项卡
			$("#tabs").tabs();
			loadMobileImg();
			loadPadImg();
		});
		
		function loadMobileImg(){
			$.ajax({
			    url: 'PictureAction!getMobileNew.action',
			    type: 'post',
			    dataType: 'json',
			    data:{t:(new Date()).valueOf()},
			    timeout: 30000,
			    async: false,//使用同步
			    beforeSend: function(){},
			    error: function(XMLHttpRequest, textStatus, errorThrown){
			    	
			    },
			    success: function(data){
			    	if(data != null)
			    		$("#mobileImg").attr("src", data.path);
			    },
			    complete: function (XMLHttpRequest, textStatus) {
					//this; // 调用本次AJAX请求时传递的options参数
				}
			});
		}
		function loadPadImg(){
			$.ajax({
			    url: 'PictureAction!getPadNew.action',
			    type: 'post',
			    dataType: 'json',
			    data:{t:(new Date()).valueOf()},
			    timeout: 30000,
			    async: false,//使用同步
			    beforeSend: function(){},
			    error: function(XMLHttpRequest, textStatus, errorThrown){
			    	
			    },
			    success: function(data){
			    	if(data != null)
			    		$("#padImg").attr("src", data.path);
			    },
			    complete: function (XMLHttpRequest, textStatus) {
					//this; // 调用本次AJAX请求时传递的options参数
				}
			});
		}
		
		function slectImg(callback){
			SelImg.show(callback);
		}
		
		function onMobileSelected(img){
			$("#mobileImg").attr("src", img.path);
		}
		function onPadSelected(img){
			$("#padImg").attr("src", img.path);
		}
		
		function saveMobile(){
			var path = $("#mobileImg").attr("src");
			$.ajax({
			    url: 'PictureAction!saveMobile.action',
			    type: 'post',
			    dataType: 'text',
			    data:{t:(new Date()).valueOf(), "picture.path":path},
			    timeout: 30000,
			    async: false,//使用同步
			    beforeSend: function(){},
			    error: function(XMLHttpRequest, textStatus, errorThrown){
			    	
			    },
			    success: function(data){
			    	if(data == "1")
			    		alert("保存成功");
			    },
			    complete: function (XMLHttpRequest, textStatus) {
					//this; // 调用本次AJAX请求时传递的options参数
				}
			});
		}
		function savePad(){
			var path = $("#padImg").attr("src");
			$.ajax({
			    url: 'PictureAction!savePad.action',
			    type: 'post',
			    dataType: 'text',
			    data:{t:(new Date()).valueOf(), "picture.path":path},
			    timeout: 30000,
			    async: false,//使用同步
			    beforeSend: function(){},
			    error: function(XMLHttpRequest, textStatus, errorThrown){
			    	
			    },
			    success: function(data){
			    	if(data == "1")
			    		alert("保存成功");
			    },
			    complete: function (XMLHttpRequest, textStatus) {
					//this; // 调用本次AJAX请求时传递的options参数
				}
			});
		}
		</script>
		
	</head>
	<body>
		<ul id="section"></ul>
		<div id=tabs>
			<ul>
				<li>
					<a href="#tabs-1">手机启动动画</a>
				</li>
				<li>
					<a href="#tabs-2">平板启动动画</a>
				</li>
			</ul>
			<div id=tabs-1>
				<img id="mobileImg" />
				<button type="button" onclick="slectImg('onMobileSelected')">选择图片</button>
				<button type="button" onclick="saveMobile()">保存</button>
			</div>
			<div id=tabs-2>
				<img id="padImg"/>
				<button type="button" onclick="slectImg('onPadSelected')">选择图片</button>
				<button type="button" onclick="savePad()">保存</button>
			</div>
		</div>
	</body>
</html>