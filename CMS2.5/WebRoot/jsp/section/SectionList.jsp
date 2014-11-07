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
		var headers="编号,编辑,删除,栏目名称,所属分类,适用终端,展示类型,文章数,创建时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'edit', 'w':55}");
		columns.push("{'n':'delete', 'w':55}");
		columns.push("{'n':'name','a':'left',w:300}");
		columns.push("{'n':'sectionType.name', 'w':120}");
		columns.push("{'n':'adapterTerminal.name', 'w':120}");
		columns.push("{'n':'showType.name', 'w':120}");
		columns.push("{'n':'articleCount', 'w':60}");
		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		//创建Grid    
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "SectionAction!getList.action", "json", headers, columns, 10, "频道/栏目列表", undefined,buttons);
	});				 
	function update(id)
	{
		if(id==1){alert('不能修改根节点');return;}
		fn.openURL("<%=basePath%>SectionAction!edit.action?id="+id+"&t="+new Date());
	}
	function del(id) {
		if(id==1){alert('不能删除根节点');return;}
		if (confirm("该操作将删除栏目关联的子栏目及栏目里面的文章,是否继续?")) {
			$.ajax({
				type : "POST",
				url : "SectionAction!ajaxDelete.action",
				datatype : "json",
				data : {
					"id" : id
				},
				success : function(msg) {
					jqGrid.refresh("#gridTable");
				},
				error:function(msg)
				{
					alert(msg);
				}
			});
		}
	}
	function query()
	{
		window.jqGrid.reLoad("#gridTable","SectionAction!getList.action?name="+encodeURIComponent($("#name").val()));
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
						<label for="article.template.id" class="label">
							栏目名称:
						</label>
						<input type="text" name="name" id="name">
					</li>

					<li>
						<input type="button" value="查询" onclick="query()" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
						<input type="button" value="新建" onclick="fn.openURL('<%=basePath%>SectionAction!add.action')" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					</li>
				</ol>
			</div>

		</div>

		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>


	</body>
</html>
