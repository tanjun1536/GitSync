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
//		columns.push("{'n':'up', 'w':35}");
//		columns.push("{'n':'next', 'w':35}");
		columns.push("{'n':'section.name','s':'string'}");
		columns.push("{'n':'title','s':'string'}");
		columns.push("{'n':'state.name','s':'string'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"textFormatter":setButtonName,"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		//buttons.push({"gc":"up","showName":"上移","tip":"上移此行数据","action":"up","width":"16px","height":"16px"});
		//buttons.push({"gc":"next","showName":"下移","tip":"下移此行数据","action":"next","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", "#gridPager", "SectionFocusAction!getList.action", "json","编号,编辑,删除,栏目,标题,状态", columns, 10, "栏目焦点列表", undefined, buttons);
		//绑定新建按钮点击事件
	});
	function setButtonName(data,button)
	{
		var state=data["state.name"];
		if(state=='上线')
		{
			button.showName='查看';
		}
		else
		{
			button.showName='编辑';
		}
		return button;
	}
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
	function up(id){
		fn.openURL("<%=basePath%>SectionFocusAction!setPoistion.action?strategy=-1&id=" + id);
	}
	function next(id){
		fn.openURL("<%=basePath%>SectionFocusAction!setPoistion.action?strategy=1&id=" + id);
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
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 手机栏目焦点发布
		</div>
		<div class="clear"></div>
		</header>

		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input type="button" value="添加" onclick="add();" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				<input id="article.section.id" name="article.section.id" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
					<input type="button" onclick="queryBySection();" value="筛选" id="post-query-submit" onclick="add();" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
			<ol>
				<li>
					<select name="searchField" id="searchField">
						<option value="title">
							内容标题
						</option>
						<option value="content">
							内容正文
						</option>
					</select>
					<input type="text" value="" id="searchkey" name="searchkey" style="width: 80px" id="search-input">
						<input type="button" onclick="query()" value="搜索" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
				</li>
			</ol>
		</div>

		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>
