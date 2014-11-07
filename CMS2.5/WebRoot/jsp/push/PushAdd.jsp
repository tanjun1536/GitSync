<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
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
<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
<script type="text/javascript"
	src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
<script type="text/javascript">
	function check() {
		
	$.dialog({content : '<div class="lg_label"> <label for="code"> 密 码： </label> <input type="password" id="j_password"  /> </div>',
					ok : function() {
						$.get('PushAction!checkPushPasswrod.action', {
							pwd : $("#j_password", parent.document).val()
						}, function(data) {
// 						alert(data);
							if (data == 'OK') {
// 								alert("#frm");
								$("#frm").submit();
							} else
								alert('推送密码错误!');
						}, 'text');

						return false;
					},
					cancelVal : '关闭',
					cancel : true
				/*为true等价于function(){}*/
				});
	}
</script>
</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	<div class="header_c">当前位置：采编管理 > 推送管理</div>
	<div class="sreachdiv">
		<form enctype="application/x-www-form-urlencoded" id="frm"
			action="PushAction!save.action" method="post">
			<div
				style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<textarea rows="10" cols="250" style="width:98%" id="message"
					name="push.message"></textarea>
				<br />
				<br /> <select name="push.msgId">
					<c:forEach var="item" items="${messages }">
						<option value="${item.id }">${item.title }</option>
					</c:forEach>
				</select><br />
				<br /> <input type="button" value="确认" class="btn" onclick="check();"
					onfocus="this.blur()" onMouseOver="this.className='btn_over'"
					onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</form>
	</div>
</body>
</html>