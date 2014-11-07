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
	<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css">
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
	<script src="javascript/base.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			$("#section\\.parent\\.id");//.combotree('setValue', 35);
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
  <header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：系统管理> 添加/修改系统角色
		</div>
		<div class="clear"></div>
		</header>
		<form name="form1" enctype="multipart/form-data" action="RoleAction!addRole.action" method="post">
			<div class="formdiv">

				<ol>
					<li>
						<label class="label">
							业务范围:
						</label>
						<input id="section.parent.id" name="role.section.id" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
					</li>
					<li>
						<label class="label">
							角色名称:
						</label>
						<input type="text" name="role.name" style="width: 200px" required="true">
					</li>
					<li>
						<label class="label">
							角色级别:
						</label>
						<select name="role.type.id" style="width: 200px">
							<c:forEach var="item" items="${dicts}">
								<option value="${item.id }">
									${item.name }
								</option>
							</c:forEach>
						</select>
					</li>
					<li>
						<label class="label">
							拥有功能:
						</label>
						<ul id="tt" url="MenuAction!getMenuTreeJson.action" animate="true"></ul>
						<div id="menuIds">
						</div>
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" class="btn" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/role/RoleList.jsp')" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>

		</form>
	</body>
</html>
