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
			$("#depart\\.parent\\.id");//.combotree('setValue', 35);
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
			当前位置：系统管理> 添加/编辑行政部门管理
		</div>
		<div class="clear"></div>
		</header>
		<form name="form1" enctype="multipart/form-data" action="DepartmentAction!addDepartment.action" method="post">
			<div class="formdiv">

				<ol>
					<li>
						<label for="article.template.id" class="label">
							上级部门:
						</label>
						<input id="depart.parent.id" name="depart.parent.id" class="easyui-combotree" url="DepartmentAction!getDepartmentTreeJSON.action" style="width: 200px;">
					</li>
					<li>
						<label for="article.template.id" class="label">
							部门名称:
						</label>
						<input type="text" name="depart.name" style="width: 200px" required="true">
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/department/DepartmentList.jsp')" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
	</body>
</html>
