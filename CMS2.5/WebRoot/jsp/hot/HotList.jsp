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
		var headers="编号,删除,排序,标题,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','w':40,'h':false}");
		columns.push("{'n':'delete', 'w':40}");
		columns.push("{'n':'order', 'w':40}");
// 		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left','w':200}");
		columns.push("{'n':'createDate'}");
		//创建操作按钮
		var buttons=new Array();
		buttons.push({"gc":"delete","showName":"删除","tip":"删除此行数据","action":"del","width":"16px","height":"16px"});
		buttons.push({"gc":"order","showName":"排序","tip":"改变序号","action":"changeOrder","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridSeparateButton("#gridTable", "#gridPager", "HotAction!getList.action", "json",headers, columns, 10,"文章列表", undefined,buttons);
	});
	function padZero(str, length) {
	    var strLen = str.toString().length;
	    return length > strLen ? new Array(length - strLen + 1).join("0") + str : str;
	}
	//添加
	function addAtricle()
	{
		fn.openURL("<%=basePath%>jsp/hot/HotAdd.jsp");
	}
	function changeOrder(id)
	{
		$.dialog.prompt('请输入序号', 
		    function(val){ 
		    	var ord=parseInt(val);
		    	if(isNaN(ord))
		    	{
		    		$.dialog.tips('请输入数字'); 
		    	}
		    	else
		    	{
		    		$.post('HotAction!ChangeOrder.action',{id:id,order:ord}, function(){
		    			jqGrid.refresh('#gridTable');
		    		},'json');
		    	}
		    
		    }
		);
	}
	//删除
	function del(id) {
		if (confirm("是否删除该记录？")) {
			$.ajax({
				type : "POST",
				url : "HotAction!ajaxDelete.action",
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
</script>
	</head>
	<body>
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 热点管理
		</div>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input type="button" onclick="addAtricle();" value="添加文章" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>
