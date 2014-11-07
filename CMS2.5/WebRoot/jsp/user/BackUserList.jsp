<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="generator" content="HTML Tidy, see www.w3.org">
	<base href="<%=basePath%>">
	<!--引入jquery	-->
	<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
	<!--引入Grid样式		-->
	<link href="javascript/jquery.jqGrid-4.2.0/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
	<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
	<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
	<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
			<!-- jquery easyui-->
	<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
	<script src="javascript/jqGrid.js" type="text/javascript"></script>
	<script src="javascript/base.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			//创建列
			var columns = new Array();
			columns.push("{'n':'id','s':'int','w':10,'h':true}");
			columns.push("{'n':'disabled','s':'int','w':10,'h':true}");
			columns.push("{'n':'edit', 'w':25}");
			columns.push("{'n':'delete', 'w':25}");
			columns.push("{'n':'name','s':'string','f':getName}");
			columns.push("{'n':'loginName','s':'string'}");
			columns.push("{'n':'department.fullName','s':'string'}");
				//创建操作按钮
			var buttons=new Array();
			buttons.push({"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
			buttons.push({"textFormatter":setButtonNameDel,"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
			//创建Grid
			window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "BackUserAction!getBackUserList.action", "json", "编号,'',编辑,删除,用户名称,登录名,所属部门", columns, 10, "系统用户列表", undefined,buttons);
		});
		function getName(cellvalue, options, rowObject)
		{
			return rowObject.disabled?cellvalue+'(已停用)':cellvalue;
		}
		function setButtonNameDel(data,button)
		{
			var state=data["disabled"];
			if(state=="true")
			{
				button.showName='启用';
			}
			else
			{
				button.showName='停用';
			}
			return button;
		}
		function update(id){
			fn.openURL('<%=basePath%>BackUserAction!edit.action?id=' + id)
		}
		function del(id){
			fn.openURL('<%=basePath%>BackUserAction!changeUserState.action?id=' + id)
		}
		
		function batchDel(){
			var ids = window.jqGrid.getSelected("#gridTable");
			if($.trim(ids) == ""){
				alert("请先选择");
				return;
			}
			fn.openURL('<%=basePath%>BackUserAction!deleteList.action?ids=' + ids);
		}
		function queryByDepartId()
		{
			var departId=$("#depart\\.parent\\.id").combotree("getValue");
			if(departId=='') return;
			jqGrid.reLoad('#gridTable','BackUserAction!getBackUserList.action?user.department.id=' + departId);
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
			当前位置：系统管理> 系统用户管理
		</div>
		<div class="clear"></div>
		</header>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input type="button" value="新建" onclick="fn.openURL('<%=basePath%>BackUserAction!add.action')"  class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="批量删除" onclick="batchDel()"  class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input id="depart.parent.id" name="depart.parent.id" class="easyui-combotree" url="DepartmentAction!getDepartmentTreeJSON.action" style="width: 200px;"  class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button"  onclick="queryByDepartId();" value="筛选" id="post-query-submit"  class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager">
			</div>
		</div>
	</body>
</html>