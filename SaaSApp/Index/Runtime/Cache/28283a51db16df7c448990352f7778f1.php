<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/JavaScript">
	var dept = "<?php echo ($member["memberdeptid"]); ?>";
	var member = "<?php echo ($member["memberid"]); ?>";
	var team = "<?php echo ($member["teamid"]); ?>";
	var userteam = "<?php echo ($member["memberteamid"]); ?>";
	var salarytype = "<?php echo ($member["salarytype"]); ?>";
	var salary = "<?php echo ($member["salary"]); ?>";

	$(function() {
		$('#memberdeptid').change(function() {
			getTeam('#memberdeptid', '#memberteamid');
		});
		$('#memberteamid').change(function() {
			getPeople('#memberteamid', '#memberid');
		});
		$('#memberid').change(function() {
		  $("#phone").empty().val($(this).find("option:selected").attr('phone'));
		  $("#mobile").empty().val($(this).find("option:selected").attr('mobile'));
		  $("#email").empty().val($(this).find("option:selected").attr('email'));
			$.ajax({
				type : "POST",
				dataType : "json",
				url : "__URL__/getSalary",
				data : "id=" + $("#memberid").val(),
				success : function(data) {
					$("#defult_salary").val(data);
				}
			});
		});
		if (dept)
			$("#memberdeptid").val(dept).trigger('change');
		if (team)
			$("#teamid").val(team);
		if (salarytype == '0') {
			$("#defult_salary").val(salary);
			$("input[type=radio][value=0]").attr("checked", true);
		}

		else {
			$("#manul_salary").val(salary);
			$("input[type=radio][value=1]").attr("checked", true);
		}

	});
	function getTeam(depart, teams) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getTeam",
			data : "pid=" + $(depart).val(),
			success : function(data) {
				$(teams).empty();
				$("<option value=''>選擇組別</option>").appendTo(teams);
				var json = eval(data);
				if(!json)return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name'])  + "</option>").appendTo(teams);
				});
				if (userteam)
					$("#memberteamid").val(userteam).trigger('change');
			}
		});
	}
	function getPeople(teamid, users) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getPeopleByTeam",
			data : "id=" + $(teamid).val(),
			success : function(data) {
				$(users).empty();
				$("<option value=''>選擇員工</option>").appendTo(users);
				var json = eval(data);
				$.each(json, function(k) {
					$("<option phone='"+json[k]['phone']+"' mobile='"+json[k]['mobile']+"' email='"+json[k]['email']+"'  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "(" + decodeURI(json[k]['ucode']) + ")</option>").appendTo(users);
				});
				if (member)
					$("#memberid").val(member).trigger('change');
			}
		});
	}
	function check() {
		var salarytype = $("input[type=radio]:checked").val();
		if (salarytype == '0')
			$("#salary").val($("#defult_salary").val());
		else
			$("#salary").val($("#manul_salary").val());
		return validator.index('memberid', '請選擇員工') && validator.index('teamid', '請選擇專案組別');
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


			<div class="topic">專案管理- 所屬人員</div>
			<div class="mainInfo">
				<div class="topic2">新增 / 修改所屬人員</div>
				<form id="form1" onsubmit="return check();" name="form1" method="post" action="__URL__/addMember?case=<?php echo $_SESSION["case"];?>">
					<input type="hidden" name="case" value="<?php echo $_SESSION["case"];?>" /> <input type="hidden" name="id" value="<?php echo ($member["id"]); ?>" />
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="102" scope="row">姓名</th>
							<td width="230"><select name="memberdeptid" id="memberdeptid">
									<option value="">選擇部門</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="memberteamid" id="memberteamid">
									<option value="">選擇組別</option>
							</select> <select name="memberid" id="memberid">
									<option value="">選擇員工</option>
							</select></td>
							<th width="102" scope="row">聯絡電話</th>
							<td width="256"><input type="text" id="phone" name="phone" value="<?php echo ($member["phone"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">email</th>
							<td><input type="text" name="email" id="email" value="<?php echo ($member["email"]); ?>" /></td>
							<th width="102" scope="row">行動電話</th>
							<td><input type="text" name="mobile" id="mobile" value="<?php echo ($member["mobile"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">所屬組別</th>
							<td><select name="teamid" id="teamid">
									<option value="選擇專案組別">選擇專案組別</option>
									<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<th width="102" scope="row">薪資</th>
							<td><div>
									<input type="hidden" name="salary" id="salary" /> <input name="salarytype" type="radio" checked="checked" value="0" /> 預設時薪 : <input type="text" id="defult_salary" style="width: 100px" />
								</div>
								<div>
									<input name="salarytype" type="radio" value="1" /> 手動時薪 : <input type="text" id="manul_salary" style="width: 100px" />
								</div></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td colspan="3"><input type="submit" name="Submit2" value="確定" /> <input type="reset" name="Submit2" value="取消" /></td>
						</tr>
					</table>
				</form>
				<div class="topic2">所屬人員</div>
				<form id="form1" name="form1" onsubmit="return confirm('是否確認刪除選擇的數據?')" method="post" action="__URL__/deleteMember?case=<?php echo $_SESSION["case"];?>">
					<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop">
						<tr>
							<th width="28" scope="col"><input type="checkbox" name="checkbox5" value="checkbox" /></th>
							<th width="114" scope="col">姓名</th>
							<th width="108" scope="col">聯絡電話</th>
							<th width="108" scope="col">行動電話</th>
							<th width="232" scope="col">EMAIL</th>
							<th width="103" scope="col">操作</th>
						</tr>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
							<?php else: ?>
							<tr class="trcolor"><?php endif; ?>
						<td align="center"><input type="checkbox" name="itemcheckbox[]" value="<?php echo ($item["id"]); ?>" /></td>
						<td align="center"><?php echo ($item["name"]); ?>(<?php echo ($item["ucode"]); ?>)</td>
						<td align="center"><?php echo ($item["phone"]); ?></td>
						<td align="center"><?php echo ($item["mobile"]); ?></td>
						<td align="center"><?php echo ($item["mobile"]); ?></td>
						<td align="center"><a href="case3_cost.php">統計 </a>| <a href="__URL__/editMember?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($item["id"]); ?>">修改</a></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
					<div class="pages"><?php echo ($page); ?></div>
					<div style="margin-top: 10px">
						<input type="submit" name="Submit" value="刪除" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>