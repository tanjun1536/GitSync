<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
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
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
	$(function() {
		var headers="编号,编辑,删除,栏目类型名称";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'edit', 'w':55}");
		columns.push("{'n':'delete', 'w':55}");
		columns.push("{'n':'name','a':'center',w:300}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		//创建Grid    
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "SectionTypeAction!getList.action", "json", headers, columns, 10, "频道/栏目列表", undefined,buttons);
	});				 
	function update(id)
	{
		fn.openURL("<%=basePath%>SectionTypeAction!edit.action?id="+id+"&t="+new Date());
	}
	function del(id) {
		if (confirm("是否继续?")) {
			$.ajax({
				type : "POST",
				url : "SectionTypeAction!ajaxDelete.action",
				datatype : "json",
				data : {
					"id" : id
				},
				success : function(msg) {
					if(msg=='OK')
					jqGrid.refresh("#gridTable");
					else
					alert('有栏目引用改类型不能够删除!');
				},
				error:function(msg)
				{
					alert(msg);
				}
			});
		}
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
			当前位置：系统管理> 栏目节点管理
		</div>
		<div class="clear"></div>
		</header>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<ol>
					<li>
						<input type="button" value="新建" onclick="fn.openURL('<%=basePath%>SectionTypeAction!add.action')" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					</li>
				</ol>
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			
		</div>


	</body>
</html>
