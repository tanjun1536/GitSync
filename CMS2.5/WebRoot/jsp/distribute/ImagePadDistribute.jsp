<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
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
		columns.push("{'n':'edit', 'w':35}");
		columns.push("{'n':'delete', 'w':35}");
		columns.push("{'n':'section.name','s':'string'}");
		columns.push("{'n':'title','s':'string'}");
		columns.push("{'n':'state.name','s':'string'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "SectionFocusAction!getList.action", "json","编号,编辑,删除,栏目,标题,状态", columns, 10, "栏目焦点列表", undefined, buttons);
		//绑定新建按钮点击事件
	});
	//添加
	function add()
	{
		fn.openURL("<%=basePath%>SectionFocusAction!add.action");
	}
	//修改
	function update(id)
	{
		fn.openURL("<%=basePath%>SectionFocusAction!edit.action?focus.id=" + id);
	}
	//删除
	function del(id) {
		if (confirm("是否删除该记录？")) {
			$.ajax({
				type : "POST",
				url : "SectionFocusAction!ajaxDelete.action",
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
	function queryBySection()
	{
		var sectionId=$("#article\\.section\\.id").combotree("getValue");
		if(sectionId=='')return ;
		jqGrid.reLoad('#gridTable','SectionFocusAction!getList.action?focus.section.id='+sectionId);
	}
	function query()
	{
		var searchBy=$("#searchField").val();
		var keyword=$("#searchkey").val();
		var url="SectionFocusAction!getList.action";
			if(keyword!='')
			{
				url+="?searchBy="+searchBy;
				url+="&keyword="+keyword;
			}
		jqGrid.reLoad('#gridTable',url);	
	}
</script>
		
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
			<tr>
				<td valign="top" style="width: 100%; height: 100%;">
					<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
						<tr>
							<td height="20px">
								<input type="button" value="添加" onclick="add();">
								<input id="article.section.id" name="article.section.id" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
								<input type="button"  onclick="queryBySection();" value="筛选" id="post-query-submit">
							</td>
						</tr>
						<tr>
							<td>
								<select name="searchField" id="searchField">
									<option value="title">
										内容标题
									</option>
									<option value="content">
										内容正文
									</option>
								</select>
								<input type="text" value="" id="searchkey" name="searchkey" style="width: 80px" id="search-input">
								<input type="button" onclick="query()" value="搜索">
							</td>
						</tr>
						<tr>
							<td valign="top">
								<table id="gridTable">
								</table>
								<div id="gridPager"></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
