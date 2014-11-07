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
				<script src="javascript/jqGrid2.0.js" type="text/javascript"></script>
				<script src="javascript/base.js" type="text/javascript"></script>
				<script src="javascript/My97DatePicker/WdatePicker.js" type="text/javascript"></script>
				<!--弹出窗口-->
				<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
				<script type="text/javascript">
	$(function() {
		var headers="编号,删除,标题";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','w':40,'h':false}");
		columns.push("{'n':'delete', 'w':40}");
		columns.push("{'n':'title','a':'left','w':200}");
// 		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "MessageAction!getArticleList.action?msgId=${param.id}", "json",headers, columns, 10,"文章列表", undefined,buttons);
	});
	function padZero(str, length) {
	    var strLen = str.toString().length;
	    return length > strLen ? new Array(length - strLen + 1).join("0") + str : str;
	}
	//添加
	function addArticle()
	{		
			$.dialog.data('fn',function(datas){
				$.each(datas,function(){
					this.delete='<input type="button" value="删除" title="删除此行数据" width="16px" height="16px" onclick="del('+this.id+')">';
					jqGrid.addRow("#gridTable",this); 
				});
			}); 
			$.dialog({content : "url:jsp/message/ArticleSelector.jsp",width: '900px', height: '500px',title:"选择文章",
					cancelVal : '关闭',
					cancel : true
				/*为true等价于function(){}*/
				});
	}
	function edit(id)
	{
		fn.openURL("MessageAction!edit.action?id="+id);
	}
	//删除
	function del(id) {
		jqGrid.deleteRow("#gridTable",id); 
	}
	function sure()
	{
		var datas=jqGrid.getSelectedRowsData('#gridTable');
		var grid=$('#gridTable');
		var datas = grid.getDataIDs();
		if(datas.length==0 )
		{
			alert('请添加文章!');
			return false;
		}
		
		var titles= [];
		for(var i=0;i<datas.length;i++)
		{
			var data=grid.getRowData(datas[i]);
			$("#form1").append('<input name="message.articles['+i+'].id" value="'+data.id+'" type="hidden" />');
			if(i<3)
			{
				titles.push(data.title);
			}
		}
		$("#form1").append('<input name="message.title" value="'+titles.join()+'" type="hidden" />');
		return true;
	}
</script>
	</head>
	<body>
		<form enctype="application/x-www-form-urlencoded" id="form1" action="MessageAction!save.action" method="post" onsubmit="return sure()">
		<input type="hidden" name="message.id" id="id" value="${param.id}" />
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 消息管理
		</div>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input type="button" onclick="addArticle();" value="添加文章" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input type="submit"  value="完成" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		</form>
	</body>
</html>
