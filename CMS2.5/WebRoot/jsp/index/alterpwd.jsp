<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
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
		<title>i南充内容发布管理平台dddd</title>
		<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<!-- jquery easyui-->
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
		function changePwd()
		{
			if($("#pwd").val()=='')
			{
				alert('请输入新的密码!');
				return ;
			}
			if($("#pwd").val()!=$("#pwdconfirm").val())
			{
				alert('两次输入的密码必须一样子!');
				return ;
			}
			$.ajax({
					type : "POST",
					url : "BackUserAction!alterPwd.action",
					datatype : "json",
					data : {
						'pwd' : $("#pwd").val()
					},
					success : function(msg) {
						alert('密码修改成功!');
					},
					error : function() {
						alert('修改密码出错!');
					}
				});
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
			当前位置：修改密码
		</div>
		<div class="clear"></div>
		</header>
		<input type="hidden" value="${article.id }" name="article.id">
		<div class="formdiv">
			<ol>
				<li>
					<label for="pwd" class="label">
						新密码：
					</label>
					<input id="pwd" type="password" size="60" required>
				</li>
				<li>
					<label for="pwd" class="label">
						重复新密码：
					</label>
					<input id="pwdconfirm" type="password" size="60" required>
				</li>
			</ol>
			<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
				<input type="button" value="保存" class="btn" onclick="changePwd()" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
	</body>
</html>
