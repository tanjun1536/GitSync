<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/basic.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/calendar.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/nav-h.css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
	var mt = "<?php echo ($ov["devicetype"]); ?>";
	var ct = "<?php echo ($ov["devicechildtype"]); ?>";
	var pt="<?php echo ($ov["type"]); ?>";
	var work="<?php echo ($ov["work"]); ?>";
	$(function() {
		$("#devicetype").change(function() {
			getChild();
		});
		if(work)$("#work").val(work);
		if(mt)$("#devicetype").val(mt).trigger("change");
		if(pt){
			$("#startday").val("<?php echo ($ov["startday"]); ?>");
			$("#startmonth").val("<?php echo ($ov["startmonth"]); ?>");
			$("#costday").val("<?php echo ($ov["costday"]); ?>");
			$("input[name=type][value=<?php echo ($ov["type"]); ?>]").attr("checked",true);
			if (pt == 'D') {
				
			} else if (pt == 'W') {
				$("#wstartday").val("<?php echo ($ov["startday"]); ?>");
				$("#wcostday").val("<?php echo ($ov["costday"]); ?>");
			} else if (pt == 'M') {
				$("#mstartday").val("<?php echo ($ov["startday"]); ?>");
				$("#mcostday").val("<?php echo ($ov["costday"]); ?>");
			} else if (pt == 'Q') {
				$("#qmonth").val("<?php echo ($ov["startmonth"]); ?>");
				$("#qstartday").val("<?php echo ($ov["startday"]); ?>");
				$("#qcostday").val("<?php echo ($ov["costday"]); ?>");
			} else if (pt == 'H') {
				$("#hmonth").val("<?php echo ($ov["startmonth"]); ?>");
				$("#hstartday").val("<?php echo ($ov["startday"]); ?>");
				$("#hcostday").val("<?php echo ($ov["costday"]); ?>");
			} else if (pt == 'Y') {
				$("#ymonth").val("<?php echo ($ov["startmonth"]); ?>");
				$("#ystartday").val("<?php echo ($ov["startday"]); ?>");
				$("#ycostday").val("<?php echo ($ov["costday"]); ?>");
			}
		}
	});
	function getChild() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getDeviceChildType",
			data : "id=" + $("#devicetype").val(),
			success : function(data) {
				$("#devicechildtype").empty();
				$("<option value='請選擇'>請選擇</option>").appendTo("#devicechildtype");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#devicechildtype");
				});
				if(mt)$("#devicechildtype").val(ct);
			}
		});

	}
	function check() {
		if (validator.index('devicetype', '請選擇主類別') && validator.index('devicechildtype', '請選擇子類別')&& validator.index('work', '請選擇班別') && validator.empty('name', '請輸入保養週期名稱')) {
			var item = $('input:radio:checked').val();
			if (item == 'D') {
				
			} else if (item == 'W') {
				$("#startday").val($("#wstartday").val());
				$("#costday").val($("#wcostday").val());
			} else if (item == 'M') {
				$("#startday").val($("#mstartday").val());
				$("#costday").val($("#mcostday").val());
			} else if (item == 'Q') {
				$("#startmonth").val($("#qmonth").val());
				$("#startday").val($("#qstartday").val());
				$("#costday").val($("#qcostday").val());
			} else if (item == 'H') {
				$("#startmonth").val($("#hmonth").val());
				$("#startday").val($("#hstartday").val());
				$("#costday").val($("#hcostday").val());
			} else if (item == 'Y') {
				$("#startmonth").val($("#ymonth").val());
				$("#startday").val($("#ystartday").val());
				$("#costday").val($("#ycostday").val());
			}
			return true;
		}
		return false;
	}
</script>
</head>

<body>
	<div class="top">您好，<?php echo $_SESSION["SESSION_USER"]["name"];?> ! 　<a href="__APP__/Index/logout"><strong>登出</strong></a>　<a href="__APP__/Work/index">回首頁</a></div>

	<div class="webPage">
		<div class="sideLeft">
	<div>
		<a href="__APP__/User/profile"> <img src="__PUBLIC__/<?php if(empty($_SESSION['SESSION_USER']['userimage'])) echo 'images/3_03.jpg';  else echo 'Uploads/'.$_SESSION['SESSION_USER']['userimage']; ?>" alt="" width="151" border="0" />
		</a>
	</div>
	<div class="name">
		<a href="__APP__/User/Profile"><?php echo $_SESSION['SESSION_USER']['name'] ?></a>
	</div>
	<div class="menuSide">
		<ul>
			<?php if(is_array($CaseMenu)): $i = 0; $__LIST__ = $CaseMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(empty($item["children"])): ?><li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a></li>
			<?php else: ?>
			
			<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" />
			<?php if(!empty($item["link"])): ?><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a>
			<?php else: ?>
			<?php echo ($item["name"]); ?><?php endif; ?>
				<ul>
					<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><li><a href="<?php echo ($citem["link"]); ?>"><?php echo ($citem["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul></li><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
<!-- 			<li><img src="__PUBLIC__/images/hire_me.png" alt="" width="23" height="23" /><a href="__URL__/index">專案管理</a> -->
<!-- 				<ul> -->
<!-- 					<li><a href="__URL__/view?case=<?php echo $_SESSION["case"];?>">專案內容</a></li> -->
<!-- 					<li><a href="__URL__/team?case=<?php echo $_SESSION["case"];?>">組別設定</a></li> -->
<!-- 					<li><a href="__URL__/work?case=<?php echo $_SESSION["case"];?>">班別設定</a></li> -->
<!-- 					<li><a href="__URL__/member?case=<?php echo $_SESSION["case"];?>">所屬人員</a></li> -->
<!-- 					<li><a href="__URL__/looker?case=<?php echo $_SESSION["case"];?>">查看人員</a></li> -->
<!-- 					<li><a href="__URL__/attendance?case=<?php echo $_SESSION["case"];?>">差勤管理</a></li> -->
<!-- 					<li><a href="__URL__/costanalysis?case=<?php echo $_SESSION["case"];?>">成本分析</a></li> -->
<!-- 					<li><a href="__URL__/file?case=<?php echo $_SESSION["case"];?>">相關文件</a></li> -->
<!-- 					<li><a href="__URL__/moveshift?case=<?php echo $_SESSION["case"];?>">調班管理</a></li> -->
<!-- 				</ul></li> -->
<!-- 			<li><img src="__PUBLIC__/images/database_32.png" alt="" width="23" height="23" />設備管理 -->
<!-- 				<ul> -->
<!-- 					<li><a href="__URL__/deviceIndex?case=<?php echo $_SESSION["case"];?>">設備列表</a></li> -->
<!-- 					<li><a href="__URL__/buildingFloorArea?case=<?php echo $_SESSION["case"];?>">建物區域管理</a></li> -->
<!-- 					<li><a href="__URL__/deviceType?case=<?php echo $_SESSION["case"];?>">類別設定</a></li> -->
<!-- 					<li><a href="__URL__/maintenanceScheduling?case=<?php echo $_SESSION["case"];?>">月保養排程</a></li> -->
<!-- 					<li><a href="__URL__/dayMaintenanceRecord?case=<?php echo $_SESSION["case"];?>">日保養排程</a></li> -->
<!-- 					<li><a href="__URL__/maintenanceOverTime?case=<?php echo $_SESSION["case"];?>">保養週期</a></li> -->
<!-- 				</ul></li> -->
<!-- 			<li><img src="__PUBLIC__/images/screwdriver_32.png" alt="" width="23" height="23" />保養管理 -->
<!-- 				<ul> -->
<!-- 					<li><a href="__URL__/maintenanceRecord?case=<?php echo $_SESSION["case"];?>">保養紀錄</a></li> -->
<!-- 					<li><a href="__URL__/maintenanceRecordDetail?case=<?php echo $_SESSION["case"];?>">保養明細管理</a></li> -->
<!-- 				</ul></li> -->
<!-- 			<li><img src="__PUBLIC__/images/tools_32.png" alt="" width="23" height="23" />維修管理 -->
<!-- 				<ul> -->
<!-- 					<li><a href="__URL__/repair?case=<?php echo $_SESSION["case"];?>">維修列表</a></li> -->
<!-- 					<li><a href="__URL__/addRepair?case=<?php echo $_SESSION["case"];?>">申請叫修</a></li> -->
<!-- 					<li><a href="__URL__/doRepair?case=<?php echo $_SESSION["case"];?>">派工</a></li> -->
<!-- 					<li><a href="__URL__/repairFinish?case=<?php echo $_SESSION["case"];?>">完工回報</a></li> -->
<!-- 					<li><a href="__URL__/delegateRepair?case=<?php echo $_SESSION["case"];?>">委外管理</a></li> -->
<!-- 					<li><a href="__URL__/projectBid?case=<?php echo $_SESSION["case"];?>">工程報價</a></li> -->
<!-- 					<li><a href="__URL__/warnSetting?case=<?php echo $_SESSION["case"];?>">警示設定</a></li> -->
<!-- 				</ul></li> -->
<!-- 			<li><img src="__PUBLIC__/images/statistics.png" alt="" width="23" height="23" />統計資料 -->
<!-- 				<ul> -->
<!-- 					<li><a href="__URL__/statisticsbymonth?case=<?php echo $_SESSION["case"];?>" target="_blank">月叫修數量統計表</a></li> -->
<!-- 					<li><a href="__URL__/statisticsbymonthDetail?case=<?php echo $_SESSION["case"];?>" target="_blank">月叫修明細統計表</a></li> -->
<!-- 					<li><a href="__URL__/statisticsbyyear?case=<?php echo $_SESSION["case"];?>" target="_blank">年度叫修數量統計表</a></li> -->
<!-- 					<li><a href="__URL__/statisticsbyyearDetail?case=<?php echo $_SESSION["case"];?>" target="_blank">年度叫修明細統計表</a></li> -->
<!-- 					<li><a href="__URL__/statisticsCompletebyMonth?case=<?php echo $_SESSION["case"];?>" target="_blank">月完工數量統計表</a></li> -->
<!-- 					<li><a href="__URL__/statisticsCompletebyMonthDetail?case=<?php echo $_SESSION["case"];?>" target="_blank">月完工明細統計表</a></li> -->
<!-- 					<li><a href="__URL__/statisticsCompletebyYear?case=<?php echo $_SESSION["case"];?>" target="_blank">年度完工數量統計表 </a></li> -->
<!-- 					<li><a href="__URL__/statisticsCompletebyYearDetail?case=<?php echo $_SESSION["case"];?>" target="_blank">年度完工明細統計表 </a></li> -->
<!-- 					<li><a href="__URL__/statisticsMaintenancebyMonth?case=<?php echo $_SESSION["case"];?>" target="_blank">月保養數量統計表  </a></li> -->
<!-- 					<li><a href="__URL__/statisticsMaintenancebyMonthDetail?case=<?php echo $_SESSION["case"];?>" target="_blank">月保養明細統計表  </a></li> -->
<!-- 					<li><a href="__URL__/statisticsMaintenancebyYear?case=<?php echo $_SESSION["case"];?>" target="_blank">年度保養數量統計表  </a></li> -->
<!-- 					<li><a href="__URL__/statisticsMaintenancebyYearDetail?case=<?php echo $_SESSION["case"];?>" target="_blank">年度保養明細統計表  </a></li> -->
<!-- 					<li><a href="__URL__/statisticsbyfault?case=<?php echo $_SESSION["case"];?>" target="_blank">故障完修時間統計表 </a></li> -->
<!-- 				</ul></li> -->
		</ul>
	</div>
</div>

		<div class="mainPage">
			<div class="caseName">
  <?php echo $_SESSION["caseName"];?>
</div>


			<div class="topic">設備管理 - 保養週期</div>
			<div class="mainInfo">
				<div class="topic2">新增保養週期</div>
				<form onsubmit="return check()" id="form1" name="form1" method="post" action="__URL__/addMaintenanceOverTime?case=<?php echo $_SESSION["case"];?>">
					<input type="hidden" name="case" value="<?php echo $_SESSION["case"];?>" /> <input type="hidden" name="id" value="<?php echo ($ov["id"]); ?>" />
				
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">

						<tr>
							<th width="102" scope="row">主類別</th>
							<td colspan="3"><select name="devicetype" id="devicetype">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th width="102" scope="row">子類別</th>
							<td colspan="3"><select name="devicechildtype" id="devicechildtype">
									<option value="請選擇">請選擇</option>
							</select></td>
						</tr>
						<tr>
							<th width="102" scope="row">班別</th>
							<td colspan="3"><select name="work" id="work">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($works)): $i = 0; $__LIST__ = $works;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["workcode"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th width="102" scope="row">保養週期名稱</th>
							<td colspan="3"><input type="text" name="name" id="name" value="<?php echo ($ov["name"]); ?>"/></td>
						</tr>
						<tr>
							<th scope="row">週期設定</th>
							<td colspan="3">
							<input type="hidden" name="startday" id="startday" />
							<input type="hidden" name="costday" id=costday />
							<input type="hidden" name="startmonth" id=startmonth />
							<input name="type" type="radio" checked="checked" value="D" /> 日保養 ， 每隔1天1次 ，保養時間1天 <br /> 
							<input name="type" type="radio" value="W" /> 週保養 - 每週<input type="text" id="wstartday" style="width: 30px" /> ， 每隔7天1次 ，保養時間 <input type="text" id="wcostday" style="width: 30px" /> 天 <br /> 
							<input name="type" type="radio" value="M" /> 月保養 - 每月 <input type="text" id="mstartday" style="width: 30px" /> 日， 每年12次 ，保養時間 <input type="text" id="mcostday" style="width: 30px" /> 天 <br /> 
							<input name="type" type="radio" value="Q" /> 季保養 - 每年 <input type="text" id="qmonth" style="width: 30px" /> 月 <input type="text" id="qstartday" style="width: 30px" /> 日， 每年4次 ，保養時間 <input type="text" id="qcostday" style="width: 30px" /> 天 <br /> 
							<input name="type" type="radio" value="H" /> 半年保養 -每年 <input type="text" id="hmonth" style="width: 30px" /> 月 <input type="text" id="hstartday" style="width: 30px" /> 日， 每年2次 ，保養時間 <input type="text" id="hcostday" style="width: 30px" /> 天 <br />
							<input name="type" type="radio" value="Y" /> 年保養 - 每年 <input type="text" id="ymonth" style="width: 30px" /> 月 <input type="text" id="ystartday" style="width: 30px" /> 日， 每年1次 ，保養時間 <input type="text" id="ycostday" style="width: 30px" /> 天</td>
						</tr>
						<tr>
							<th scope="row">保養個數</th>
							<td width="241"><input type="text" name="maintenancecount" value="<?php echo ($ov["maintenancecount"]); ?>" style="width: 50px" /> 個</td>
							<th width="91" scope="row">需求人力</th>
							<td width="256"><input type="text" name="needpersoncount" value="<?php echo ($ov["needpersoncount"]); ?>" style="width: 50px" /> 人</td>
						</tr>
						<tr>
							<th scope="row">每次分鐘數</th>
							<td colspan="3"><input type="text" name="minutespertime" value="<?php echo ($ov["minutespertime"]); ?>" style="width: 50px" /> 分鐘</td>
						</tr>

						<tr>
							<th scope="row">&nbsp;</th>
							<td colspan="3"><input type="submit" name="Submit2" value="保存" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>