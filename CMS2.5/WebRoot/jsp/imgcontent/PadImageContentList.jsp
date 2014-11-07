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
	<!--弹出窗口-->
	<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
	<script type="text/javascript">
		$(function() {
			var headers="编号,预览,编辑,删除,分类,状态,标题,访问,时间";
			//创建列
			var columns = new Array();
			columns.push("{'n':'id','s':'int','w':10,'h':true}");
			columns.push("{'n':'view', 'w':45}");
			columns.push("{'n':'edit', 'w':45}");
			columns.push("{'n':'delete', 'w':45}");
			columns.push("{'n':'section.name', 'w':120,'a':'left'}");
			columns.push("{'n':'state.name'}");
			columns.push("{'n':'title','a':'left',w:200}");
			columns.push("{'n':'browseCount', 'w':60}");
			columns.push("{'n':'createDate'}");
			//创建操作按钮
			var buttons=new Array();
			buttons.push({"gc":"view","showName":"预览","tip":"预览文章效果","action":"view","width":"16px","height":"16px"});
			buttons.push({"gc":"edit","showName":"编辑","tip":"编辑此行数据","action":"update","width":"16px","height":"16px"});
			buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
			//创建Grid
			window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "PadImageContentAction!getList.action", "json", headers, columns, 10, "平板图片内容列表", undefined, buttons);
		});
		
		function update(id){
			fn.openURL('<%=basePath%>PadImageContentAction!edit.action?id=' + id)
		}
		
		function del(id){
			if (confirm("是否删除该记录？")) {
				$.ajax({
					type : "POST",
					url : "PadImageContentAction!ajaxDelete.action",
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
		
		function add()
		{
			fn.openURL('<%=basePath%>PadImageContentAction!add.action');
		}
		
		function queryBySection()
		{
			var url="PadImageContentAction!getList.action";
			var where="";
			var sectionId=$("#section\\.id").combotree("getValue");
			if(sectionId!='')
				where+="?imgContent.section.id="+sectionId ;
			var state=$("#state").val();
			if(state!='') 
				if(where.indexOf("?")>-1) 
					where+="&imgContent.state.id="+state ;
			else 
				where+="?imgContent.state.id="+state ;
			jqGrid.reLoad('#gridTable',url+where);
		}
		
		function query()
		{
			var startDate=$("#B_year").val()+"-"+$("#B_month").val()+"-"+$("#B_date").val();
			var endDate=$("#E_year").val()+"-"+$("#E_month").val()+"-"+$("#E_date").val();
			var searchBy=$("#searchField").val();
			var keyword=$("#searchkey").val();
			var url="PadImageContentAction!getList.action?startDate="+startDate;
				url+="&endDate="+endDate;
				if(keyword!='')
				{
					url+="&searchBy="+searchBy;
					url+="&keyword="+keyword;
				}
			jqGrid.reLoad('#gridTable',url);	
		}
		function view(id) {
			$.dialog({
			id:'preview',
			content:"url:<%=basePath%>jsp/article/ArticlePreview.jsp?type=padImage&articleId="+id,
			max:false,
			min:false,
			width:'700px',
			height:500,
			drag:false,
			resize:false
			});			
	}
	</script>
  </head>

	<body>
		<table cellpadding="0" cellspacing="0" border="0"
			style="width: 100%; height: 100%;">
			<tr>
				<td>
					<input type="button" onclick="add();" value="新建">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="section.id" name="article.section.id" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
					<select name="state" id="state">
						<option value="">
							所有状态
						</option>
						<option value="1">
							文章草稿
						</option>
						<option value="2">
							内容审核
						</option>
						<option value="3">
							发布审核
						</option>
						<option value="4">
							正式发布
						</option>
						<option value="5">
							文章退回
						</option>
					</select>
					<input type="button" onclick="queryBySection();" value="筛选" id="post-query-submit">
					<br>
					<br>
					开始日期：
					<select name="B_year" id="B_year">
						<option value="2014">
							2014
						</option>
						<option value="2013">
							2013
						</option>
						<option value="2012">
							2012
						</option>
						<option value="2011">
							2011
						</option>
						<option value="2010">
							2010
						</option>
						<option value="2009">
							2009
						</option>
						<option value="2008">
							2008
						</option>
						<option value="2007">
							2007
						</option>
						<option value="2006">
							2006
						</option>
						<option value="2005">
							2005
						</option>
						<option value="2004">
							2004
						</option>
						<option value="2003">
							2003
						</option>
					</select>
					年
					<select name="B_month" id="B_month">
						<option value="01">
							01
						</option>
						<option value="02">
							02
						</option>
						<option selected="" value="03">
							03
						</option>
						<option value="04">
							04
						</option>
						<option value="05">
							05
						</option>
						<option value="06">
							06
						</option>
						<option value="07">
							07
						</option>
						<option value="08">
							08
						</option>
						<option value="09">
							09
						</option>
						<option value="10">
							10
						</option>
						<option value="11">
							11
						</option>
						<option value="12">
							12
						</option>
					</select>
					月
					<select name="B_date" id="B_date">
						<option selected="" value="01">
							01
						</option>
						<option value="02">
							02
						</option>
						<option value="03">
							03
						</option>
						<option value="04">
							04
						</option>
						<option value="05">
							05
						</option>
						<option value="06">
							06
						</option>
						<option value="07">
							07
						</option>
						<option value="08">
							08
						</option>
						<option value="09">
							09
						</option>
						<option value="10">
							10
						</option>
						<option value="11">
							11
						</option>
						<option value="12">
							12
						</option>
						<option value="13">
							13
						</option>
						<option value="14">
							14
						</option>
						<option value="15">
							15
						</option>
						<option value="16">
							16
						</option>
						<option value="17">
							17
						</option>
						<option value="18">
							18
						</option>
						<option value="19">
							19
						</option>
						<option value="20">
							20
						</option>
						<option value="21">
							21
						</option>
						<option value="22">
							22
						</option>
						<option value="23">
							23
						</option>
						<option value="24">
							24
						</option>
						<option value="25">
							25
						</option>
						<option value="26">
							26
						</option>
						<option value="27">
							27
						</option>
						<option value="28">
							28
						</option>
						<option value="29">
							29
						</option>
						<option value="30">
							30
						</option>
						<option value="31">
							31
						</option>
					</select>
					日 &nbsp;结束日期：
					<select name="E_year" id="E_year">
						<option value="2014">
							2014
						</option>
						<option value="2013">
							2013
						</option>
						<option value="2012">
							2012
						</option>
						<option value="2011">
							2011
						</option>
						<option value="2010">
							2010
						</option>
						<option value="2009">
							2009
						</option>
						<option value="2008">
							2008
						</option>
						<option value="2007">
							2007
						</option>
						<option value="2006">
							2006
						</option>
						<option value="2005">
							2005
						</option>
						<option value="2004">
							2004
						</option>
						<option value="2003">
							2003
						</option>
					</select>
					年
					<select name="E_month" id="E_month">
						<option value="01">
							01
						</option>
						<option value="02">
							02
						</option>
						<option value="03">
							03
						</option>
						<option value="04">
							04
						</option>
						<option value="05">
							05
						</option>
						<option value="06">
							06
						</option>
						<option value="07">
							07
						</option>
						<option value="08">
							08
						</option>
						<option value="09">
							09
						</option>
						<option value="10">
							10
						</option>
						<option value="11">
							11
						</option>
						<option value="12">
							12
						</option>
					</select>
					月
					<select name="E_date" id="E_date">
						<option value="01">
							01
						</option>
						<option value="02">
							02
						</option>
						<option value="03">
							03
						</option>
						<option value="04">
							04
						</option>
						<option value="05">
							05
						</option>
						<option value="06">
							06
						</option>
						<option value="07">
							07
						</option>
						<option value="08">
							08
						</option>
						<option value="09">
							09
						</option>
						<option value="10">
							10
						</option>
						<option value="11">
							11
						</option>
						<option value="12">
							12
						</option>
						<option value="13">
							13
						</option>
						<option value="14">
							14
						</option>
						<option value="15">
							15
						</option>
						<option value="16">
							16
						</option>
						<option value="17">
							17
						</option>
						<option value="18">
							18
						</option>
						<option value="19">
							19
						</option>
						<option value="20">
							20
						</option>
						<option value="21">
							21
						</option>
						<option value="22">
							22
						</option>
						<option value="23">
							23
						</option>
						<option value="24">
							24
						</option>
						<option value="25">
							25
						</option>
						<option value="26">
							26
						</option>
						<option value="27">
							27
						</option>
						<option value="28">
							28
						</option>
						<option value="29">
							29
						</option>
						<option value="30">
							30
						</option>
						<option value="31">
							31
						</option>
					</select>
					日
					<select name="searchField" id="searchField">
						<option value="title">
							内容标题
						</option>
						<option value="source">
							内容来源
						</option>
						<option value="sender">
							创建人
						</option>
					</select>
					<input type="text" value="" id="searchkey" name="keyword" style="width: 80px" id="search-input">
					<input type="button" onclick="query()" value="搜索">
				</td>
			</tr>
			<tr>
				<td valign="top" style="width: 100%; height: 100%;">
					<table id="gridTable">
					</table>
					<div id="gridPager"></div>
				</td>
			</tr>
		</table>
	</body>
</html>