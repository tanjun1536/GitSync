<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
<script type="text/javascript">
	var tid = "<?php echo $_GET["tid"];?>";
	var ctid = "<?php echo $_GET["ctid"];?>";
	var devicecode = "<?php echo $_GET["devicecode"];?>";
	var build="<?php echo ($device["build"]); ?>";
	var floor="<?php echo ($device["floor"]); ?>";
	var area="<?php echo ($device["area"]); ?>";
	$(function() {
		$("#print").bind("click", function(event) {
			$("#S").hide();
			$("#C").hide();
			$("#print").hide()
			$(".mainInfo").printArea();
			$("#S").show();
			$("#C").show();
			$("#print").show()
		});
		$("#type").change(function() {
			getChildType();
		});
		$("#childtype").change(function() {
			getDevice();
		});
		$("#build").change(function() {
			getFloor("#build", "#floor");
		});
		$("#floor").change(function() {
			getArea("#build", "#floor");
		});
		$("#devicecode").change(function() {
			var name = $("#devicecode").find("option:selected").attr("name");
			if (name != '') {
				$('#devicename').val(name);
				$('#devicenameLb').html(name);
			}
		});
		if (tid)
			$("#type").val(tid).trigger('change');
		if(build)
			$("#build").val(build).trigger('change');
	});
	function getFloor(b, f) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getFloor",
			data : "bid=" + $(b).val(),
			success : function(data) {
				$("#floor").empty();
				$("<option value='選擇樓層'>選擇樓層</option>").appendTo(f);
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo(f);
				});
				$("#floor").val(floor).trigger('change');
			}
		});

	}
	function getArea() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getArea",
			data : "fid=" + $("#floor").val(),
			success : function(data) {
				$("#area").empty();
				$("<option value='請選擇'>請選擇</option>").appendTo("#area");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo("#area");
				});
				$("#area").val(area).trigger('change');
			}
		});

	}
	function getChildType() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getDeviceChildType",
			data : "id=" + $("#type").val(),
			success : function(data) {
				$("#childtype").empty();
				$("<option value='0'>請選擇</option>").appendTo("#childtype");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo("#childtype");
				});
				if (ctid)
					$("#childtype").val(ctid).trigger('change');
			}
		});

	}
	var c = "<?php echo $_SESSION["case"];?>";
	function getDevice() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getDevice",
			data : {
				"case" : c,
				"type" : $("#type").val(),
				"childtype" : $("#childtype").val(),
				"build" : $("#build").val(),
				"floor" : $("#floor").val(),
				"area" : $("#area").val(),
			},
			success : function(data) {
				$("#devicecode").empty();
				$("<option value='0'>請選擇</option>").appendTo("#devicecode");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option name='" + decodeURI(json[k]['name'])
									+ "' value='" + json[k]['devicecode']
									+ "'>" + decodeURI(json[k]['name'])+"("+decodeURI(json[k]['devicecode'])+")"
									+ "</option>").appendTo("#devicecode");
				});
				if (devicecode)
					$("#devicecode").val(devicecode);
			}
		});

	}
	function check() {
		return validator.empty('repaircode', '請輸入叫修單編號!')
				&& validator.index('devicecode', '您尚未選擇叫修設備!');
	}
</script>
</head>
<body>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/calendar.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/nav-h.css" />
<div class="top">
	<div class="top_tempcolor">
		<a href="__APP__/Index/ChangeStyle?style=blue"
			class="color1 select"></a><a
			href="__APP__/Index/ChangeStyle?style=red"
			class="color2"></a><a
			href="__APP__/Index/ChangeStyle?style=green"
			class="color3"></a>
	</div>
	<div class="top_id">
		您好，<?php echo $_SESSION["SESSION_USER"]["name"];?> ! <a href="__APP__/Index/logout"><strong>登出</strong></a>
		<a href="__APP__/Work/index">回首頁</a>
	</div>
</div>



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


			<div class="topic">叫修單管理 - 申請叫修</div>
			<div class="mainInfo">
				<form action="__URL__/insertRepair?case=<?php echo $_SESSION["case"];?>"
					onsubmit="return check()" method="post"
					enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name="state" value="申請叫修" /> <input
						type="hidden" name="case" value="<?php echo $_SESSION["case"];?> " />
					<div class="topic2">叫修單</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide">
						<tr>
							<th scope="row">叫修單編號</th>
							<td><input type="text" name="repaircode" readonly="readonly"
								id="repaircode" value="<?php echo ($linecode); ?>" /></td>
							<th scope="row">叫修時間</th>
							<td><input type="hidden" name="repairdate" id="repairdate" />
								<script type="text/javascript">
									var d = new Date()
											.format("yyyy/MM/dd hh:mm");
									document.write(d);
									$("#repairdate").val(d);
								</script></td>
						</tr>
						<tr>
							<th width="100" scope="row">樓層區域</th>
							<td width="361"><select name="build" id="build">
									<option value="">選擇棟別</option>
									<?php if(is_array($builds)): $i = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="floor" id="floor">
									<option value="">選擇樓層</option>
							</select> <select name="area" id="area">
									<option value="">選擇區域</option>
							</select></td>
							<th width="73" scope="row">申請人</th>
							<td width="156"><input type="hidden" name="requestuser"
								id="requestuser" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>" /><input type="hidden" name="requestuserid"
								id="requestuserid" value="<?php echo $_SESSION["SESSION_USER"]["id"];?>" /><?php echo $_SESSION["SESSION_USER"]["name"];?></td>
						</tr>
						<tr>
							<th scope="row">設備編號</th>
							<td colspan="1"><select name="type" id="type">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="childtype" id="childtype">
									<option value="請選擇" selected="selected">請選擇</option>
							</select> <select name="devicecode" id="devicecode">
									<option value="請選擇" selected="selected">請選擇</option>
							</select></td>
							<th width="73" scope="row">叫修人</th>
							<td width="156"><input type="text" name="askuser"
								id="askuser" /></td>
						</tr>
						<tr>
							<th scope="row">設備名稱</th>
							<input type="hidden" name="devicename" id="devicename" value="<?php echo ($device["name"]); ?>"/>
							<td colspan="3"><label id="devicenameLb"><?php echo ($device["name"]); ?></label></td>
						</tr>
						<tr>
							<th scope="row">附件檔案</th>
							<td colspan="3"><input type="file" name="att" /></td>
						</tr>
						<tr>
							<th scope="row">說明</th>
							<td colspan="3"><textarea name="remark" rows="12"
									style="width: 500px"></textarea></td>
						</tr>
					</table>
<!-- 					<table width="695" border="0" cellpadding="0" cellspacing="1" -->
<!-- 						class="tabThSide"> -->
<!-- 						<tr> -->
<!-- 							<th width="252" scope="col">業方</th> -->
<!-- 							<th width="143" scope="col">現場主管</th> -->
<!-- 							<th width="149" scope="col">驗收</th> -->
<!-- 							<th width="146" scope="col">施工人員</th> -->
<!-- 						</tr> -->
<!-- 						<tr> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 						</tr> -->
<!-- 						<tr> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 							<td>&nbsp;</td> -->
<!-- 						</tr> -->
<!-- 					</table> -->
					<div align="center">
						<input type="submit" id="S" value="確定" /> <input type="reset"
							id="C" value="取消" /> 
					</div>


				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>