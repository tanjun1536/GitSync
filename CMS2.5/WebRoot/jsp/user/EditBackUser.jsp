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
	<script type="text/javascript">
		$(function() {
			<c:if test="${user.department ne null}">
				$("#depart\\.parent\\.id").combotree('setValue', ${user.department.id});
			</c:if>
		});
	</script>
  </head>
  
  <body>
			<form name="form1" enctype="multipart/form-data" action="BackUserAction!updateBackUser.action" method="post">
				<input type="hidden" name="user.id" value="${user.id }">
				<div class="formdiv">

				<ol>
					<li>
						<label class="label">
							所属部门:
						</label>
						<input id="depart.parent.id" name="user.department.id" class="easyui-combotree" url="DepartmentAction!getDepartmentTreeJSON.action" style="width: 200px;">  
					</li>
					<li>
						<label class="label">
								用户名称:
						</label>
						<input type="text" name="user.name" style="width: 200px" required="true" value="${user.name }">
					</li>
					<li>
						<label class="label">
							用户登录名:
						</label>
					<input type="text" name="user.loginName" style="width: 200px" required="true" value="${user.loginName }">
					</li>
					<li>
						<label class="label">
							用户密码:
						</label>
						<input type="password" name="user.loginPassword" style="width: 200px" required="true" value="${user.loginPassword }">
					</li>
					<li>
						<label class="label">
							拥有角色:
						</label>
						<c:forEach var="item" items="${roles}">
								<c:choose>
									<c:when test="${item.selected==true }">
									<label><input name="roles" type="checkbox" checked="checked" value="${item.id }" />${item.name }</label><br />
									</c:when>
									<c:otherwise><label><input name="roles" type="checkbox" value="${item.id }" />${item.name }</label><br /></c:otherwise>
								</c:choose>
							</c:forEach>
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="fn.openURL('<%=basePath%>jsp/user/BackUserList.jsp')"  class="btn" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/role/RoleList.jsp')" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
			</form>
  </body>
</html>
