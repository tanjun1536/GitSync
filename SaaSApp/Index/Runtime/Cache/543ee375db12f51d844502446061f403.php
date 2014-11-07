<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
	var name = "<?php echo ($dname); ?>";
	var code = "<?php echo ($dcode); ?>";
	var build = "<?php echo ($dbuild); ?>";
	var floor = "<?php echo ($dfloor); ?>";
	var area = "<?php echo ($darea); ?>";
	var type = "<?php echo ($dtype); ?>";
	$(function() {
		$("#type").change(function() {
			getChildType();
		});
		$("#dbuild").change(function() {
			getFloor();
		});
		$("#dfloor").change(function() {
			getArea();
		});
		if (name)
			$("#dname").val(name);
		if (code)
			$("#dcode").val(code);
		if (type)
			$("#dtype").val(type);
		if (build)
			$("#dbuild").val(build).trigger('change');

	});
	$(function() {
		$('#headerchecker').click(function() {

			if ($(this).attr("checked") == 'checked') {
				$("[name='itemcheckbox[]']").attr("checked", 'true');
			} else {
				$("[name='itemcheckbox[]']").removeAttr("checked");

			}
		});

	});
	function getChildType() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getDeviceChildType",
			data : "id=" + $("#type").val(),
			success : function(data) {
				$("#childtype").empty();
				$("<option value=''>請選擇</option>").appendTo("#childtype");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo("#childtype");
				});
			}
		});

	}
	function getFloor() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getFloor",
			data : "bid=" + $("#dbuild").val(),
			success : function(data) {
				$("#dfloor").empty();
				$("<option value=''>請選擇</option>").appendTo("#dfloor");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo("#dfloor");
				});
				if (floor)
					$("#dfloor").val(floor).trigger('change');
			}
		});

	}
	function getArea() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getArea",
			data : "fid=" + $("#dfloor").val(),
			success : function(data) {
				$("#darea").empty();
				$("<option value=''>請選擇</option>").appendTo("#darea");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo("#darea");
				});
				if (area)
					$("#darea").val(area);
			}
		});

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


			<div class="topic">設備管理 - 設備管理</div>
			<div class="mainInfo">
				<div class="topic2">設備搜尋</div>
				<form id="form1" name="form1" method="post"
					action="__URL__/deviceIndex?case=<?php echo $_SESSION["case"];?>">
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide">
						<tr>
							<th width="88" scope="row">設備編號</th>
							<td width="328"><input type="text" name="dcode" id="dcode" /></td>
							<th width="88" scope="row">主類別</th>
							<td width="186"><select name="dtype" id="dtype">
									<option value="" selected="selected">請選擇</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th scope="row">設備名稱</th>
							<td><input type="text" name="dname" id="dname"
								style="width: 300px" /></td>
							<th width="88" scope="row">樓層區域</th>
							<td><select name="dbuild" id='dbuild'>
									<option value="">請選擇</option>
									<?php if(is_array($builds)): $i = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select><select name="dfloor" id="dfloor">
									<option value="">請選擇</option>
							</select><select name="darea" id="darea">
									<option value="">請選擇</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td colspan="3"><input type="submit" name="Submit2"
								value="搜尋" /></td>
						</tr>
					</table>
				</form>
				<div class="topic2">設備列表</div>
				<form name="form3" method="post" action="__URL__/ImportDevices" enctype="multipart/form-data">
					<div class="mailNav">
						<?php if(check_power('匯出',$ext) == 1): ?><a
							href="__URL__/exportDevice">匯出所有設備</a><?php endif; ?>
						<?php if(check_power('新增',$ext) == 1): ?><a
							href="__URL__/addDevice?case=<?php echo $_SESSION["case"];?>">新增設備</a><?php endif; ?>
						<?php if(check_power('匯入',$ext) == 1): ?>匯入設備 <input
							type="file" name="file" /> <input type="submit" name="Submit"
							value="匯入" /><?php endif; ?>
						<?php if(check_power('刪除所有設備',$ext) == 1): ?><a onclick="return confirm('是否確認刪除數據?')"
							href="__URL__/DeleteDeviceByCase?case=<?php echo $_SESSION["case"];?>">刪除所有設備</a><?php endif; ?>
				</form>
				</if>

			</div>
			</form>
			<form onsubmit="return confirm('是否刪除選擇的數據?')" id="form2" name="form2"
				method="post" action="__URL__/deleteDevices?case=<?php echo $_SESSION["case"];?>">
				<table width="695" border="0" cellpadding="0" cellspacing="0"
					class="tab_thtop">
					<tr>
						<th width="28" scope="col"><input type="checkbox"
							name="headerchecker" id="headerchecker" value="checkbox" /></th>
						<th width="105" scope="col">樓層區域</th>
						<th width="135" scope="col">設備編號</th>
						<th width="205" scope="col">設備名稱</th>
						<th width="136" scope="col">主類別</th>
						<th width="84" scope="col">子類別</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
						<?php else: ?>
					<tr class="trcolor"><?php endif; ?>
					<td align="center"><input type="checkbox"
						name="itemcheckbox[]" value="<?php echo ($item["id"]); ?>" /></td>
					<td align="center"><?php echo ($item["fname"]); ?>—<?php echo ($item["aname"]); ?></td>
					<td align="center"><a
						href="__URL__/viewDevice?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>"><?php echo ($item["devicecode"]); ?></a></td>
					<td><?php echo ($item["name"]); ?></td>
					<td align="center"><?php echo ($item["tname"]); ?></td>
					<td align="center"><?php echo ($item["ctname"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
				<div style="margin-top: 10px">
					<?php if(check_power('刪除',$ext) == 1): ?><input
						type="submit" name="Submit3" value="刪除" /><?php endif; ?>

				</div>
			</form>
			<div class="pages"><?php echo ($page); ?></div>
		</div>
	</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>