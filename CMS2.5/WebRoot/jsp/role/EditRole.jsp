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
		$(function(){
			<c:if test="${role.section ne null}">
				$("#section\\.parent\\.id").combotree('setValue', ${role.section.id});
			</c:if>
		});
		
		$(function(){
			$('#tt').tree({
				checkbox: true,
				onCheck:function(node){
					$("#menuIds").empty();
					var nodes = $(this).tree('getChecked');
					for(var i=0; i<nodes.length; i++){
						$("<input name=\"menus\" type=\"hidden\" value=\"" + nodes[i].id +"\" />").appendTo("#menuIds"); 
					}
				},
				onClick:function(node){
					$(this).tree('toggle', node.target);
				},
				onContextMenu: function(e, node){
					e.preventDefault();
					$('#tt').tree('select', node.target);
				}
			});
		});
	</script>
  </head>
  
  <body>
    <center>
			<form name="form1" enctype="multipart/form-data" action="RoleAction!updateRole.action" method="post">
				<input type="hidden" name="role.id" value="${role.id }">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							业务范围:
						</td>
						<td>
							<input id="section.parent.id" name="role.section.id" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
						</td>
					</tr>
					<tr>
						<td>
							角色名称:
						</td>
						<td>
							<input type="text" name="role.name" style="width: 200px" required="true" value="${role.name }">
						</td>
					</tr>
					<tr>
						<td>
							角色级别:
						</td>
						<td>
							<select name="role.type.id" style="width: 200px">
								<c:forEach var="item" items="${dicts}">
									<option value="${item.id }" ${item.id eq role.type.id?"selected":""}>
										${item.name }
									</option>
								</c:forEach>
							</select>
						</td>
					</tr>
					<tr>
						<td valign="top">
							拥有功能:
						</td>
						<td>
							<div id="menuIds">
							</div>
							<ul id="tt" url="MenuAction!getMenuTreeJson.action?menuIds=${menuIds }" animate="true"></ul>
							<!--<c:forEach var="item" items="${menus}">
								<label><input name="menus" type="checkbox" value="${item.id }" ${item.selected?"checked":"" }/>${item.name }</label><br />
							</c:forEach>-->
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" id="btnSave" value="保存">
						</td>
						<td>
							<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/role/RoleList.jsp')" value="返回">
						</td>
					</tr>
				</table>
			</form>
		</center>
  </body>
</html>
