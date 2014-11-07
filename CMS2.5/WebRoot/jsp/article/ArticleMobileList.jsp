<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@page import="com.gang.entity.log.StateLog"%>
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
<script type="text/javascript"
	src="javascript/jquery/js/jquery-1.7.min.js"></script>
<!--引入Grid样式		-->
<link href="javascript/jquery.jqGrid-4.2.0/css/ui.jqgrid.css"
	rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js"
	type="text/javascript"></script>
<script
	src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js"
	type="text/javascript"></script>
<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js"
	type="text/javascript"></script>
<!-- jquery easyui-->
<link rel="stylesheet" type="text/css"
	href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
<script type="text/javascript"
	src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
<script src="javascript/jqGrid.js" type="text/javascript"></script>
<script src="javascript/base.js" type="text/javascript"></script>
<script src="javascript/My97DatePicker/WdatePicker.js"
	type="text/javascript"></script>
<!--弹出窗口-->
<script type="text/javascript"
	src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
<script type="text/javascript">
	var tree;
	$(function() {
		var headers="编号,预览,编辑,删除,日志,评论,分类,状态,标题,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','w':40,'h':false}");
		columns.push("{'n':'view', 'w':50,'h':true}");
		columns.push("{'n':'edit', 'w':50}");
		columns.push("{'n':'delete', 'w':50}");
		columns.push("{'n':'log', 'w':50}");
		columns.push("{'n':'comment', 'w':50}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'state.name'}");
		columns.push("{'n':'title','a':'left','w':200}");
		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons=new Array();
		//buttons.push({"gc":"view","showName":"预览","tip":"预览文章效果","action":"view","width":"16px","height":"16px"});
		//buttons.push({"extor":"contentTemplate.entityName","textFormatter":setButtonName,"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
		buttons.push({"textFormatter":setButtonName,"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
		buttons.push({"textFormatter":setButtonNameDel,"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		buttons.push({"gc":"log","showName":"日志","tip":"日志","action":"showlog","width":"16px","height":"16px"});
		buttons.push({"gc":"comment","showName":"评论","tip":"查看评论","action":"showcomment","width":"16px","height":"16px"});
		
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "ArticleMobileAction!getList.action", "json",headers, columns, 10,"文章列表", undefined,buttons);
		
		getStates();
		
	});
	function getStates()
	{
		$.ajax({
				type : "POST",
				url : "ArticleMobileAction!getState.action",
				datatype : "json",
				success : function(data) {
					var json = eval(data);
					$.each(json, function(k) {
						$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) +"</option>").appendTo('#state');
					});
				},
				error : function() {
					alert('获取文章状态列表出错!');
				}
			});
	}
	function setButtonName(data,button)
	{
		var state=data["state.name"];
		if(state=='退回'||state=='编辑')
		{
			//button.showName="编辑";
			//button.disabled=false;
		}
		else
		{
			button.showName="查看";
			//button.disabled=true;
		}
		return button;
	}
	function setButtonNameDel(data,button)
	{
		var state=data["state.name"];
		if(state=='上线')
		{
			button.disabled=true;
		}
		else
		{
			button.disabled=false;
		}
		return button;
	}
	function getCellValue(value)
	{
		return value==true?'是':'否';
	}
	function padZero(str, length) {
	    var strLen = str.toString().length;
	    return length > strLen ? new Array(length - strLen + 1).join("0") + str : str;
	}
	function queryBySection()
	{
		var url="ArticleMobileAction!getList.action";
		var where="";
		var sectionId=$("#article\\.section\\.id").combotree("getValue");
		if(sectionId!='')where+="?section.id="+sectionId ;
		var state=$("#state").val();
		if(state!='') if(where.indexOf("?")>-1) 
		where+="&state.id="+state ;
		else 
		where+="?state.id="+state ;
		//$('#cc').combotree('getValue')
		jqGrid.reLoad('#gridTable',url+where);
	}
	function query()
	{
		var startDate=$("#startdate").val();
		var endDate=$("#enddate").val();
		var searchBy=$("#searchField").val();
		var keyword=$("#searchkey").val();
		var url="ArticleMobileAction!getList.action?startDate="+startDate;
			url+="&endDate="+endDate;
			if(keyword!='')
			{
				url+="&searchBy="+searchBy;
				url+="&keyword="+encodeURI(keyword);
			}
		jqGrid.reLoad('#gridTable',url);	
	}
	//添加
	function addAtricle()
	{
		fn.openURL("<%=basePath%>ArticleMobileAction!add.action");
	}
	//修改
	function update(id) {
		fn.openURL("<%=basePath%>ArticleMobileAction!edit.action?id=" + id);
	}
	//删除
	function del(id) {
		if (confirm("是否删除该记录？")) {
			$.ajax({
				type : "POST",
				url : "ArticleMobileAction!delete.action",
				datatype : "json",
				data : {
					'id' : id
				},
				success : function(msg) {
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('删除文章出错!');
				}
			});
		}
	}
	//删除
	function batchdel() {
		var ids = window.jqGrid.getSelected("#gridTable");
		if (ids == '') {
			alert("请选择要删除的文章");
			return;
		}
		if (confirm("确认要删除选择的文章吗？")) {
			$.ajax({
				type : "POST",
				url : "ArticleMobileAction!ajaxBatchDelete.action",
				datatype : "json",
				data : {
					'ids' : ids
				},
				success : function(msg) {
					jqGrid.refresh('#gridTable');
				},
				error : function() {
					alert('删除文章出错!');
				}
			});
		}
	}
	function view(id) {
		$.dialog({
		id:'preview',
		content:"url:<%=basePath%>jsp/article/ArticlePreview.jsp?type=mobile&articleId="+id,
		max:false,
		min:false,
		width:'700px',
		height:500,
		drag:false,
		resize:false
		});			
	}
	function showcomment(id) {
		$.dialog({
		id:'preview',
		content:"url:<%=basePath%>jsp/comments/ViewArticleMobileCommentList.jsp?id="+id,
		max:false,
		min:false,
		width:'700px',
		height:500,
		drag:false,
		resize:false
		});			
	}
	function showlog(id){
		fn.openURL("<%=basePath%>jsp/log/StateLogList.jsp?type=<%=StateLog.Mobile_Article%>&dataId=" + id);
	}
</script>
</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	</header>
	<div class="header_c">当前位置：采编管理 > 手机文章列表</div>
	<div class="sreachdiv">
		<div
			style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
			<input type="button" onclick="addAtricle();" value="新建" class="btn"
				onfocus="this.blur()" onMouseOver="this.className='btn_over'"
				onMouseOut="this.className='btn'" style="vertical-align: top" /> <input
				id="article.section.id" name="article.section.id" type="hidden"
				class="easyui-combotree"
				url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
			<select name="state" id="state">
				<option value="">所有状态</option>
			</select> <input type="button" onclick="queryBySection();" value="筛选"
				class="btn" onfocus="this.blur()"
				onMouseOver="this.className='btn_over'"
				onMouseOut="this.className='btn'" style="vertical-align: top" /> <input
				type="button" onclick="javascript:batchdel();" id="doaction"
				name="doaction" value="批量删除" class="btn" onfocus="this.blur()"
				onMouseOver="this.className='btn_over'"
				onMouseOut="this.className='btn'" style="vertical-align: top" />
		</div>
		<ol>
			<li><label class="label"> 开始时间: </label> <input type="text"
				id="startdate" class="Wdate" onfocus="WdatePicker()" /></li>
			<li><label class="label"> 结束时间: </label> <input type="text"
				id="enddate" class="Wdate" onfocus="WdatePicker()" /></li>

			<li><select name="searchField" id="searchField">
					<option value="title">内容标题</option>
					<option value="content">内容正文</option>
					<option value="source">内容来源</option>
					<option value="sender">创建人</option>
			</select> <input type="text" value="" id="searchkey" name="searchkey"
				style="width: 80px" id="search-input"> <label class="label">
					<input type="button" onclick="query()" value="搜索" class="btnSmall"
					onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'"
					onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
			</label></li>
		</ol>
	</div>
	<div>
		<table id="gridTable">
		</table>
		<div id="gridPager"></div>
	</div>
</body>
</html>
