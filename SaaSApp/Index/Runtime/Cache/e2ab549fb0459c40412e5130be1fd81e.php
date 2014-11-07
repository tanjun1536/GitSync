<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
	var build="<?php echo ($build); ?>";
	var floor="<?php echo ($floor); ?>";
	var area="<?php echo ($area); ?>";
	var type="<?php echo ($type); ?>";
	var childtype="<?php echo ($childtype); ?>";

	$(function() {
		$("#type").change(function() {
			getChildType();
		});
		$("#build").change(function() {
			getFloor();
		});
		$("#floor").change(function() {
			getArea();
		});
		$("#space").keyup(function(){
			var m=$("#space").val()*$("#price").val();
			$("#estimateprice").val(m);
			$("#tdestimateprice").html(m);
		});
		$("#price").keyup(function(){
			var m=$("#space").val()*$("#price").val();
			$("#estimateprice").val(m);
			$("#tdestimateprice").html(m);
		});
		if(type) $("#type").val(type).trigger('change');
		if(build) $("#build").val(build).trigger('change');
		
	});
	function getFloor() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getFloor",
			data : "bid=" + $("#build").val(),
			success : function(data) {
				$("#floor").empty();
				$("<option value=''>選擇樓層</option>").appendTo("#floor");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#floor");
				});
				if(floor) $("#floor").val(floor).trigger('change');
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
				$("<option value=''>選擇區域</option>").appendTo("#area");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#area");
				});
				if(area) $("#area").val(area);
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
				$("<option value=''>請選擇</option>").appendTo("#childtype");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#childtype");
				});
				if(childtype) $("#childtype").val(childtype);
			}
		});

	}
	function selectUsers(idInput, nameInput) {
		var selUsers = document.getElementById(idInput).value;
		var theURL = "__APP__/User/usercheckbox?id=" + idInput + "&name=" + nameInput;
		var features = 'scrollbars=yes,scrollbars=yes,width=755,height=570';
		var winName = '';
		if (selUsers == '')
			window.open(theURL, winName, features);
		else
			window.open(theURL + "?selUsers=" + selUsers, winName, features);
	}
	function check() {
		return validator.empty('name', '請輸入設備名稱') && validator.index('build', '請選擇棟別') && validator.index('floor', '請選擇樓層') && validator.index('area', '請選擇區域') && validator.index('type', '請選擇主類型') && validator.index('childtype', '請選擇子類型');
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


			<div class="topic">叫修單管理</div>
			<div class="mainInfo">
				<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
					<div class="topic2">叫修單搜尋</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">

						<tr>
							<th width="100" scope="row">叫修單編號</th>
							<td width="244"><input type="text" name="code" value="<?php echo ($repaircode); ?>" /></td>
							<th width="121" scope="row">被派工人</th>
							<td width="225"><input type="text" name="sdispatcher" value="<?php echo ($sdispatcher); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">設備名稱</th>
							<td><input type="text" name="name"  value="<?php echo ($devicename); ?>" /></td>
							<th scope="row">申請人</th>
							<td><input type="text" name="askman" value="<?php echo ($askman); ?>"  /></td>
						</tr>
						<tr>
							<th scope="row">起始日期</th>
							<td><input type="text" name="sdate" class="Wdate" value="<?php echo ($sdate); ?>" onfocus="WdatePicker()" /></td>
							<th scope="row">截止日期</th>
							<td><input type="text" name="edate" class="Wdate" value="<?php echo ($edate); ?>" onfocus="WdatePicker()" /></td>
						</tr>
						<tr>
							<th scope="row">建物區域</th>
							<td colspan="3"><select name="build" id="build">
									<option value="">選擇棟別</option>
									<?php if(is_array($builds)): $i = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="floor" id="floor">
									<option value="">選擇樓層</option>
							</select> <select name="area" id="area">
									<option value="">選擇區域</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">設備類別</th>
							<td colspan="3"><select name="type" id="type">
									<option value="">請選擇主類別</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="childtype" id="childtype">
									<option value="">請選擇子類別</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td colspan="3"><input type="button" onclick="$('#form1').attr('action','__URL__/repair').submit()" name="Submit3" value="搜尋" />
							<input type="button" name="Submit3" onclick="$('#form1').attr('action','__URL__/exportRepair').submit()" value="導出" /></td>
						</tr>
					</table>
				</form>
				<div class="topic2">叫修列表</div>
				<div class="mailNav">
					<a href="__URL__/repair?q=ly">留言</a><a href="__URL__/repair?q=wg">完工</a><a href="__URL__/repair?q=qx">取消</a><a href="__URL__/repair?q=ww">委外 (<?php echo ($ww); ?>)</a><a href="__URL__/repair?q=pg">派工 (<?php echo ($pg); ?>)</a><a href="__URL__/repair?q=sqjx">申請叫修 (<?php echo ($sqjx); ?>)</a><a href="__URL__/repair?q=zb" class="select">總表</a>
				</div>
				<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop">
					<tr>
						<th width="130" scope="col">叫修單編號</th>
						<th width="90" scope="col"><?php if(!empty($ly)): ?>留言日期<?php else: ?>叫修日期<?php endif; ?></th>
						<th width="251" scope="col">設備編號／名稱</th>
						<th width="71" scope="col">申請人</th>
						<th width="76" scope="col">狀態</th>
						<th width="155" scope="col">操作</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
						<?php else: ?>
						<tr class="trcolor"><?php endif; ?>
					<td align="center"><a href="__URL__/repairView?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>"><?php echo ($item["repaircode"]); ?></a></td>
					<td align="center"><?php if(!empty($ly)): ?><?php echo (date('Y/m/d',strtotime($item["senddate"]))); ?><?php else: ?><?php echo (date('Y/m/d',strtotime($item["repairdate"]))); ?><?php endif; ?></td>
					<td><span class="txt_green"><?php echo ($item["devicecode"]); ?></span><br /> <?php echo ($item["devicename"]); ?></td>
					<td align="center"><?php echo ($item["requestuser"]); ?></td>
					<td align="center"><?php echo (getRepairState($item['repairdate'],$item["state"],$warn['days'])); ?></td>
					<td align="center"><?php if(check_power('委外說明',$ext) == 1): ?><a href="__URL__/addDelegateRemark?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>">委外說明</a><?php endif; ?> |<?php if(check_power('取消',$ext) == 1): ?><a href="__URL__/CancelRepair?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>">取消</a><?php endif; ?>|<?php if(check_power('刪除',$ext) == 1): ?><a onclick="return confirm('是否確認刪除選擇的數據?')" href="__URL__/DeleteRepair?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>">刪除</a>|<?php endif; ?> <a href="__URL__/PrintRepair?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>" target="_blank">列印</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
				<div class="pages"><?php echo ($page); ?></div>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>