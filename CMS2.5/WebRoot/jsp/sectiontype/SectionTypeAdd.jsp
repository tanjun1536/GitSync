<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="generator" content="HTML Tidy, see www.w3.org">
<base href="<%=basePath%>">
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	<div class="header_c">当前位置：系统管理 > 添加/编辑栏目类型</div>
	<div class="clear"></div>
	</header>
	<form name="form1" enctype="multipart/form-data" action="SectionTypeAction!save.action" method="post">
		<input type="hidden" name="sectionType.id"  value="${sectionType.id }">

		<div class="formdiv">

			<ol>
				<li><label class="label"> 栏目类型名称: </label> <input type="text" name="sectionType.name" style="width: 200px" value="${sectionType.name }" required="true">
				</li>
			</ol>
			<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
				<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" /> <input type="button" value="返回" onclick="fn.openURL('<%=basePath%>jsp/section/SectionList.jsp')" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
	</form>
</body>
</html>
