<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
	response.setHeader("Pragma", "No-cache");
	response.setHeader("Cache-Control", "no-cache");
	response.setDateHeader("Expires", 0);
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="generator" content="HTML Tidy, see www.w3.org">
<base href="<%=basePath%>">
<!--引入jquery	-->
<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
<!-- jquery easyui-->
<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
<script src="javascript/base.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/xheditor-1.1.13/xheditor-1.1.13-zh-cn.min.js"></script>
<link href="css/xheditor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
<!-- include jQuery + carouFredSel plugin -->
<script type="text/javascript" language="javascript" src="javascript/carouFredSel-6.1.0/jquery.carouFredSel-6.1.0-packed.js"></script>
<!-- optionally include helper plugins -->
<script type="text/javascript" language="javascript" src="javascript/carouFredSel-6.1.0/helper-plugins/jquery.mousewheel.min.js"></script>
<script type="text/javascript" language="javascript" src="javascript/carouFredSel-6.1.0/helper-plugins/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" language="javascript" src="javascript/carouFredSel-6.1.0/helper-plugins/jquery.ba-throttle-debounce.min.js"></script>
<link href="css/group.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	var videosGroups=eval('${videos}');
	var imagesGroups=eval('${images}');
	var script='${script}';
		$(function(){
				$.getScript(script).done(function(script, textStatus) {
					initCheck();
				}).fail(function(jqxhr, settings, exception) {
					alert(script+":加载失败!"+exception);
				});
			});
			var urls = ["ArticleAuditAction!auditNext.action", "ArticleAuditAction!reject.action"];
			function onSubmit(){
				if($("#r").attr("checked") == "checked"){
					$("#auditForm").attr("action", urls[0]);
				}
				else{
					$("#auditForm").attr("action", urls[1]);
				}
				return confirm("是否要提交？");
			}
			
			function changeState(){
				if($("#r").attr("checked") == "checked"){
					$("#reason").val("");
					$("#reason").attr("readonly", true);
				}
				else{
					$("#reason").attr("readonly", false);
				}
			}
		</script>

</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	<div class="header_c">当前位置：手机审核管理 > 内容审核</div>
	<div class="clear"></div>
	</header>
	<form id="auditForm" method="post" onsubmit="return onSubmit()">
		<input type="hidden" value="${content.id }" name="article.id">
		<div class="formdiv">
			<ol>
				${HTML}
				<li><label for="r" class="label"> 审核状态： </label> <label>通过<input id="r" type="radio" name="r" checked="checked" onclick="changeState()" /> </label> <label>驳回<input type="radio" name="r" onclick="changeState()" /> </label></li>
				<li><label for="r" class="label"> 退回原因: </label> <textarea id="reason" type="text" name="reason" readonly="readonly" style="width: 570px" required></textarea></li>
			</ol>
			<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
				<input type="submit" value="提交" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" /> <input type="button" value="返回" onclick="window.fn.openURL('jsp/article/ArticleMobileList.jsp');" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
	</form>
</body>
</html>
