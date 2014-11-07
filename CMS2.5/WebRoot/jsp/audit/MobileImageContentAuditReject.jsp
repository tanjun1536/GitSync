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
	<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css">
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
	<script src="javascript/base.js" type="text/javascript"></script>
  </head>
  
  <body>
    <center>
			<form name="form1" action="MobileImageContentAuditAction!reject.action" method="post">
				<input name="id" type="hidden" value="${img.id}">
				<input name="state" type="hidden" value="${state}">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							标题:
						</td>
						<td>
							<label>${img.title }</label>
						</td>
					</tr>
					<tr>
						<td>
							退回原因:
						</td>
						<td>
							<textarea type="text" name="reason" style="width: 200px"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" id="btnSave" value="保存">
						</td>
						<td>
							<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/audit/MobileImageContentAuditList.jsp?state=${state}')" value="返回">
						</td>
					</tr>
				</table>
			</form>
		</center>
  </body>
</html>
