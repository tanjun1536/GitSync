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
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
</script>
		
	</head>
	<body>
		<center>
			<form name="form1" enctype="multipart/form-data" action="SectionFocusAction!save.action" method="post">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							栏目:
						</td>
						<td>
							<input id="section.parent.id" name="focus.section.id" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;"/>
						</td>
					</tr>
					<tr>
						<td>
							关联文章:
						</td>
						<td>
							<select name="focus.article.id">
								<option value="-1">不关联文章</option>
								<c:forEach var="article" items="${as}">
									<option value="${article.id }">${article.title }</option>
								</c:forEach>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							标题:
						</td>
						<td>
							<input type="text" name="focus.title" style="width: 200px" required="true"/>
						</td>
					</tr>
					<tr>
						<td>
							内容:
						</td>
						<td>
							<textarea name="focus.content" onpropertychange="if(value.length>200) value=value.substr(0,200)"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							焦点链接:
						</td>
						<td>
							<input type="text" name="focus.focusLink" style="width: 200px" required="true"/>
						</td>
					</tr>
					<tr>
						<td>
							焦点图片:
						</td>
						<td>
							<input type="file" name="focusImage" style="width: 200px">
						</td>
					</tr>
					<tr>
						<td>
							排列顺序:
						</td>
						<td>
							<input type="text" name="focus.orderNumber" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" id="btnSave" value="保存">
						</td>
						<td>
							<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/section/SectionFocusList.jsp')" value="返回">
						</td>
					</tr>
				</table>
			</form>
		</center>
	</body>
</html>
