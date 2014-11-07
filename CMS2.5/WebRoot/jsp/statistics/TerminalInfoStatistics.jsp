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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base href="<%=basePath%>">
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--引入jquery	-->
<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="javascript/jscharts/sources/jscharts_mb.js"></script>
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
	var tabIndex=0;
	$(function() {
	
		//创建选项卡
		$("#tabs").tabs({
			fx : {
				opacity : 'toggle'
			}
		});
		$('#tabs').bind('tabsselect', function(event, ui) {
			// ui.tab     // 被选中（点击后）的选项卡元素
			// ui.panel   //这个元素包含被选中（点击后）的选项卡的内容
			// ui.index   //返回一个被选中（或点击后）选项卡的索引值（从0开始）
			if(ui.index==0)
			{
				tabIndex=0;
			}
			else if (ui.index == 1) {
			
				tabIndex=1;
			}
		});
		var headers="编号,终端类型,操作系统,设备编号,最后使用帐号,最后使用时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'unit'}");
		columns.push("{'n':'value'}");
		columns.push("{'n':'value'}");
		columns.push("{'n':'value'}");
		columns.push("{'n':'value'}");
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable", undefined, "", "json",headers, columns, 10,"客户端分布", undefined,undefined);
		
	});
</script>

</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	<div class="header_c">当前位置：统计分析管理 > 终端信息统计</div>
	<div class="clear"></div>
	</header>
	<div id=tabs>
		<ul>
			<li><a href="#tabs-1">表格展示</a></li>
			<li><a href="#tabs-2">图表展示</a></li>
		</ul>
		<div id=tabs-1>
			<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
				<tr>
					<td valign="top">
						<table id="gridTable">
						</table>
				</tr>
			</table>
		</div>
		<div id=tabs-2>
			<div id="graph">Loading graph...</div>
		</div>
	</div>

	<script type="text/javascript">
		$.ajax({
			type : "POST",
			url : "",
			datatype : "json",
			success : function(data) {
				var json = eval(data);
				//var myData = new Array([ '北美', 69 ], [ 'Australia/Oceania', 54 ], [ '欧盟', 40 ], [ 'Latin America', 20 ], [ 'Asia', 12 ], [ 'Middle East', 10 ], [ '亚洲', 4 ], [ 'World average', 18 ]);
				var myData = new Array(json);
				//var colors = ['#C40000', '#750303', '#F9ECA2'];
				var myChart = new JSChart('graph', 'pie');
				myChart.patchMbString();
				myChart.setFontFamily("微软雅黑");
				myChart.setDataArray(json);
				//myChart.colorizePie(colors);
				myChart.setTitle('客户端分布统计分析');
				myChart.setTitleColor('#8E8E8E');
				myChart.setPieUnitsFontSize(12);
				myChart.setTitleFontSize(11);
				myChart.setTextPaddingTop(30);
				myChart.setPieUnitsColor('#8F8F8F');
				myChart.setPieValuesColor('#6E6E6E');
				myChart.setPieUnitsFontSize(10);
				myChart.setPieUnitsOffset(20);
				myChart.setSize(616, 321);
				myChart.setPiePosition(308, 190);
				myChart.setPieRadius(85);
				myChart.setBackgroundImage('images/chart_bg.jpg');
				myChart.draw();
			},
			error : function() {
				// alert('获取数据出错!');
			}
		});
	</script>
</body>
</html>