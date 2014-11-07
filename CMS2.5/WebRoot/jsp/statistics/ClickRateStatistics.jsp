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
<script type="text/javascript"
	src="javascript/jquery/js/jquery-1.7.min.js"></script>
<script type="text/javascript"
	src="javascript/jscharts/sources/jscharts_mb.js"></script>
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
<script src="javascript/My97DatePicker/WdatePicker.js"
	type="text/javascript"></script>
<script src="javascript/jqGrid.js" type="text/javascript"></script>
<script src="javascript/base.js" type="text/javascript"></script>
<script src="javascript/Week.js" type="text/javascript"></script>
<script type="text/javascript">
	var tabIndex = 0;
	var currentId=null;
	var type='chanel';
	$(function() {
		$("#type").change(function(){
			type=$(this).val();
		});
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
			if (ui.index == 0) {
				tabIndex = 0;
			} else if (ui.index == 1) {
				
				tabIndex = 1;
				chart();
			}
		});
		$("a[href='#tabs-2']").hide();
		//创建Grid
		var headers = "编号," + $("#type option:selected").text() + ",数量";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'link'}");
		columns.push("{'n':'value'}");
		var Title = $("#type option:selected").text() + "点击率统计(点击类型查看详细)";
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable",
				"#gridPager", undefined, "json", headers, columns, 10, Title,
				undefined, undefined);
		$("#year").change(function(){
			$("#month").empty()
			.append($('<option value="">全部</option>'))
			.append($('<option value="1">1月</option>'))
			.append($('<option value="2">2月</option>'))
			.append($('<option value="3">3月</option>'))
			.append($('<option value="4">4月</option>'))
			.append($('<option value="5">5月</option>'))
			.append($('<option value="6">6月</option>'))
			.append($('<option value="7">7月</option>'))
			.append($('<option value="8">8月</option>'))
			.append($('<option value="9">9月</option>'))
			.append($('<option value="10">10月</option>'))
			.append($('<option value="11">11月</option>'))
			.append($('<option value="12">12月</option>'));
			$("#week").empty().append($('<option value="">全部</option>'));
		});	
		$("#month").change(function(){
		
			 var year =$("#year").val();
			 var month=$(this).val();
			 if(month!='')
			 {
			 	month=parseInt(month)-1;
			 }
			 var weeks = Week.GetWeeks(year, month);
			 $("#week").empty().append($('<option value="">全部</option>'));
            $.each(weeks,function (index) {
                $("#week").append($('<option value="'+weeks[index].Start.format("yyyy-MM-dd")+','+weeks[index].End.format("yyyy-MM-dd")+'">'+weeks[index].toString()+'</option>'));
            });
		});

	});
	function query()
	{
		if(currentId) detail(currentId);
		else list();
	}
	function list() {
		currentId=null;
		$("a[href='#tabs-2']").hide();
		$("#container").empty().append('<table id="gridTable"></table><div id="gridPager"></div>');
		var headers = "编号," + $("#type option:selected").text() + ",数量";
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'link'}");
		columns.push("{'n':'value'}");
		var Title = $("#type option:selected").text() + "点击率统计(点击类型查看详细)";
		var url = 'StatisticsAction!getClickRateByType.action?type='
				+ $("#type").val()+'&startDate='+$("#startdate").val()+'&endDate='+$("#enddate").val();
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable",
				"#gridPager", url, "json", headers, columns, 10, Title, undefined,
				undefined);
	}
	function detail(id) {
		currentId=id;
		$("a[href='#tabs-2']").show();
		$("#container").empty().append(
				'<table id="gridTable"></table><div id="gridPager"></div>');

		var headers = "编号,名称,用户昵称,设备类型,点击时间,激活码";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'title'}");
		columns.push("{'n':'userName'}");
		columns.push("{'n':'deviceType'}");
		columns.push("{'n':'clickDateTime'}");
		columns.push("{'n':'activeKey'}");
		var Title = $("#type option:selected").text() + "点击详细列表<a href=\"javascript:void()\" onclick=\"list()\" >[返回统计列表]</a>";
		var url = 'StatisticsAction!getClickRateByTypeDetail.action?type='+ $("#type").val()+'&id='+id+'&startDate='+$("#startdate").val()+'&endDate='+$("#enddate").val();;
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable",
				"#gridPager", url, "json", headers, columns, 10, Title,
				undefined, undefined);

	}
	function chart()
	{
		$.ajax({
			type : "POST",
			url : "StatisticsAction!getClickRateByTypeChart.action?type="+type+"&id="+currentId+"&year="+$("#year").val()+"&month="+$("#month").val()+"&week="+$("#week").val()+"&day="+$("#day").val(),
			datatype : "json",
			success : function(data) {
				if(!data) return ;
				data=eval("("+data+")");
			    var json=eval(data.json);
				if(!json) return;
				var myChart = new JSChart('graph', 'line');
				myChart.patchMbString();
				myChart.setFontFamily("微软雅黑");
				myChart.setDataArray(json);
				myChart.setAxisNameFontSize(10);
				myChart.setAxisNameX('时间');
				myChart.setAxisNameY('访问次数');
				myChart.setAxisNameColor('#787878');
				myChart.setAxisValuesNumberX(1);
				myChart.setAxisValuesNumberY(1);
				myChart.setAxisValuesColor('#38a4d9');
				myChart.setAxisColor('#38a4d9');
				myChart.setLineColor('#C71112');
				myChart.setTitle('点击率统计('+data.vol+')');
				myChart.setTitleColor('#383838');
				myChart.setGraphExtend(true);
				myChart.setGridColor('#38a4d9');
				myChart.setSize(1016, 621);
				myChart.setAxisPaddingLeft(80);
				myChart.setAxisPaddingRight(140);
				myChart.setAxisPaddingTop(60);
				myChart.setAxisPaddingBottom(45);
				myChart.setTextPaddingLeft(55);
				myChart.setTextPaddingBottom(12);
				myChart.setBackgroundImage('chart_bg.jpg');
				myChart.draw();
			},
			error : function() {
				alert('获取数据出错!');
			}
		});
	}
</script>

</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	<div class="header_c">当前位置：统计分析管理 > 点击率统计</div>
	<div class="clear"></div>
	</header>
	<div id=tabs>
		<ul>
			<li><a href="#tabs-1">表格展示</a></li>
			<li><a href="#tabs-2">图表展示</a></li>
		</ul>
		<div id=tabs-1>
			<div class="sreachdiv">
				<div
					style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
					<label class="label"> 分类选择： </label> <select id="type">
						<option value="chanel">频道</option>
						<option value="section">栏目</option>
						<option value="article">文章</option>
						<option value="focus">焦点</option>
					</select> <label class="label"> 开始时间: </label> <input type="text"
						id="startdate" class="Wdate" onfocus="WdatePicker()" /> <label
						class="label"> 结束时间: </label> <input type="text" id="enddate"
						class="Wdate" onfocus="WdatePicker()" /> <input type="button"
						onclick="query();" value="统计" class="btn" onfocus="this.blur()"
						onMouseOver="this.className='btn_over'"
						onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
			<table cellpadding="0" cellspacing="0" border="0"
				style="width: 100%; height: 100%;">
				<tr>
					<td valign="top" id="container">
						<table id="gridTable">
						</table>
						<div id="gridPager"></div>
						</td>
				</tr>
			</table>
		</div>
		<div id=tabs-2>
		<div class="sreachdiv">
				<div
					style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
					<label class="label"> 年： </label> <select id="year">
						<option value="2012">2012年</option>
						<option value="2013">2013年</option>
						<option value="2014">2014年</option>
						<option value="2015">2015年</option>
						<option value="2016">2016年</option>
						<option value="2017">2017年</option>
					</select>  月: <select id="month">
						<option value="">全部</option>
						<option value="1">1月</option>
						<option value="2">2月</option>
						<option value="3">3月</option>
						<option value="4">4月</option>
						<option value="5">5月</option>
						<option value="6">6月</option>
						<option value="7">7月</option>
						<option value="8">8月</option>
						<option value="9">9月</option>
						<option value="10">10月</option>
						<option value="11">11月</option>
						<option value="12">12月</option>
					</select> 
					周：<select id="week">
						<option value="">全部</option>
					</select>
					  日: <select id="day">
						<option value="">全部</option>
						<option value="1">1号</option>
						<option value="2">2号</option>
						<option value="3">3号</option>
						<option value="4">4号</option>
						<option value="5">5号</option>
						<option value="6">6号</option>
						<option value="7">7号</option>
						<option value="8">8号</option>
						<option value="9">9号</option>
						<option value="10">10号</option>
						<option value="11">11号</option>
						<option value="12">12号</option>
						<option value="13">13号</option>
						<option value="14">14号</option>
						<option value="15">15号</option>
						<option value="16">16号</option>
						<option value="17">17号</option>
						<option value="18">18号</option>
						<option value="19">19号</option>
						<option value="20">20号</option>
						<option value="21">21号</option>
						<option value="22">22号</option>
						<option value="23">23号</option>
						<option value="24">24号</option>
						<option value="25">25号</option>
						<option value="26">26号</option>
						<option value="27">27号</option>
						<option value="28">28号</option>
						<option value="29">29号</option>
						<option value="30">30号</option>
						<option value="31">31号</option>
					</select> 
					
					
					 <input type="button"
						onclick="chart();" value="统计" class="btn" onfocus="this.blur()"
						onMouseOver="this.className='btn_over'"
						onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
			<div id="graph">Loading graph...</div>
		</div>
	</div>

</body>
</html>