<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="generator" content="HTML Tidy, see www.w3.org">
	<base href="<%=basePath%>">
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
	<script src="javascript/base.js" type="text/javascript"></script>
  </head>
  
  <body>
    <center>
			<form name="form1" enctype="multipart/form-data" action="DepartmentAction!updateDepartment.action" method="post">
				<input type="hidden" name="depart.id" value="${depart.id }">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							上级部门:
						</td>
						<td>
							<label>${depart.parent eq null?"系统根目录":depart.parent.fullName}</label>
						</td>
					</tr>
					<tr>
						<td>
							部门名称:
						</td>
						<td>
							<input type="text" name="depart.name" style="width: 200px" required="true" value="${depart.name}">
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" id="btnSave" value="保存">
						</td>
						<td>
							<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/department/DepartmentList.jsp')" value="返回">
						</td>
					</tr>
				</table>
			</form>
		</center>
  </body>
</html>
