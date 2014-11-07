<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<base href="<%=basePath%>">

		<title>文章评论列表</title>

		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
		<meta http-equiv="description" content="This is my page">
		<style>
* {margin:0px auto; padding:0}
body{font-family:"微软雅黑", "宋体", Terminal; font-size:64px;}
fieldset{list-style:none; border:none; width:90%; text-align:left; margin-top:20px}
li {padding-top:24px; list-style:none; color:#494949; width:90%;border-bottom:1px dashed #fff;table-layout:fixed; word-break:break-all; overflow:hidden}
li p {text-align:right; color:#666; padding:20px 0; font-size:56px; border-bottom:1px dashed #999}
input, textarea{ color:#666;vertical-align:middle;width:100%;padding:12px; font-size:56px}
label {width:100%; text-align:left; display:block;vertical-align:middle; padding-bottom:5px}
.button {font-size:64px; font-weight:bold; margin-top:40px; padding:18px;display: inline-block; color:#FFFFFF;border-radius:12px;border-color:#0f6dbb; border-width:1px;background-color:#207cca;background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#2882ce), color-stop(100%,#0c6abc)); cursor:pointer}
.button:hover{background-color:#4499e1;background:-webkit-gradient(linear, left top, left bottom, color-stop(1%,#4499e1), color-stop(99%,#2882ce)); cursor:pointer}

.pages {padding-top:40px; font-size:56px;text-align:right}
.pages span { margin-left:10px}
.pages span a {text-decoration:none; color:#758597}
.pages span a:hover{text-decoration:underline; color:#ca3609;}
</style>
	</head>

	<body style="margin-top:20px">
		<fieldset>
			<ol>
				<c:forEach items="${requestScope.gpr.rows}" var="comment">
					<li>
						<b>${pageScope.comment.user.name }:</b>${pageScope.comment.content }
						<p>
							${pageScope.comment.postDate }
						</p>
					</li>
				</c:forEach>
			</ol>
			<c:choose>
				<c:when test="${requestScope.gpr.page eq 1}">上页</c:when>
				<c:otherwise>
					<a href="ArticlePadCommentAction!comments.action?id=${param.id }&page=${requestScope.gpr.page-1 }&rows=${param.rows }&userId=${param.userId }">上页</a>
				</c:otherwise>
			</c:choose>
			<c:choose>
				<c:when test="${requestScope.gpr.total eq requestScope.gpr.page}">下页</c:when>
				<c:otherwise>
					<a href="ArticlePadCommentAction!comments.action?id=${param.id }&page=${requestScope.gpr.page+1 }&rows=${param.rows }&userId=${param.userId }">下页</a>
				</c:otherwise>
			</c:choose>
		</fieldset>
		<fieldset style="margin-top: 40px">
			<form action="ArticlePadCommentAction!save.action?id=${param.id }&page=1&rows=${param.rows }&userId=${param.userId }" method="post">
				<input type="hidden" name="comment.user.id" value="${param.userId }">
				<input type="hidden" name="comment.article.id" value="${param.id }">
				<label>
					<b>参与评论:</b>
				</label>
				<textarea name="comment.content" placeholder="请输入您的评论……"></textarea>
				<br />
				<button type=submit class="button">
					提交
				</button>
			</form>
		</fieldset>
		<fieldset style="position: fixed; bottom: 5px; right: -10px">
			<img src="images/nc_fb.png" width="193" height="29">
		</fieldset>

	</body>
</html>
