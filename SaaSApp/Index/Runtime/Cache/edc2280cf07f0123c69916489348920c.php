<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	$(function() {
		$("#repair").change(function() {
			getRepair();
		});
		$("#departs").change(function() {
			getTeam("#departs","#teams");
		});
		$("#teams").change(function() {
			getPeople();
		});
		$("#dispatchdate").val(new Date().format("yyyy-MM-dd hh:mm:ss"));

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
			}
		});
	}
	function getRepair() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getRepair",
			data : "id=" + $("#repair").val(),
			success : function(data) {
				var json = eval(data);
				if (json == null)
					return;
				var bfa = json.bname + "/" + json.bfname + "/" + json.aname;
				var type = json.tname + "/" + json.ctname;
				var device = json.devicecode + "<br/>" + json.devicename;
				$('#bfa').html(bfa);
				$('#type').html(type);
				$('#device').html(device);
				$("#tab_msg").empty().append('<tr>\
						<th width="95" scope="col">留言日期</th>\
						<th width="83" scope="col">留言人</th>\
						<th width="458" scope="col">內容說明</th>\
						<th width="57" scope="col">備註</th>\
					</tr>');
				$.each(json.msg, function(index){
					var row=index%2==0?$("<tr></tr>"):$("<tr class=\"trcolor\"></tr>");
					var date=json.msg[index]['senddate'].substr(0,10);
					row.append("<td align=\"center\">"+date+"</td>");
					row.append("<td align=\"center\">"+json.msg[index]['senduser']+"</td>");
					row.append("<td align=\"center\">"+json.msg[index]['msg']+"</td>");
					var msgtype=(json.msg[index]['msgtype']==undefined)?'':json.msg[index]['msgtype'];
					row.append("<td align=\"center\">"+msgtype+"</td>");
					$("#tab_msg").append(row);
				});

			}
		});

	}
	function getPeople() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getPeopleByTeam",
			data : "id=" + $('#teams').val(),
			success : function(data) {
				$("#members").empty();
				$("<option value=''>請選擇同事</option>").appendTo("#members");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "(" + json[k]['ucode'] + ")</option>").appendTo("#members");
				});
			}
		});
	}
	function addUser() {
		if (validator.index('members', '請选择同事!'))
			$("#usercontainer").append('<li><span>' + $("#members").find("option:selected").text() + '</span> <img src="__PUBLIC__/images/close_16.png" alt="刪除" style="cursor: pointer;" width="16" height="16" onclick="$(this).parent().remove();" /></li>	');
	}
	function check() {
		var users = [];
		$("#usercontainer").find("li").each(function() {
			users.push($(this).find("span").html());
		})
		$("#dousersname").val(users.join(","));
		return validator.index('repair', '請选择叫修單編號!');
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


			<div class="topic">叫修單管理 - 派工</div>
			<div class="mainInfo">
				<form id="form1" onsubmit="return check()" name="form1" method="post" action="__URL__/addDoRepair?case=<?php echo $_SESSION["case"];?>">
					<input type="hidden" name="case" value="<?php echo $_SESSION["case"];?>" />
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th scope="row">叫修單編號</th>
							<td><select name="repair" id="repair">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($repairs)): $i = 0; $__LIST__ = $repairs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["repaircode"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<th scope="row">派工日期</th>
							<td><input type="hidden" name="dispatchdate" id="dispatchdate" /> <script type="text/javascript">
								var d = new Date().format("yyyy/MM/dd hh:mm");
								document.write(d);
							</script></td>
						</tr>
						<tr>
							<th width="133" scope="row">樓層區域</th>
							<td width="363" id="bfa">顯示棟別／樓層／區域</td>
							<th width="79" scope="row">派工人</th>
							<td width="115"><input type="hidden" name="dispatchuser" id="dispatchuser" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>" /><?php echo $_SESSION["SESSION_USER"]["name"];?></td>
						</tr>
						<tr>
							<th scope="row">設備類別</th>
							<td colspan="3" id="type">顯示主類別／子類別</td>
						</tr>
						<tr>
							<th scope="row">設備編號／名稱</th>
							<td colspan="3" id="device">顯示設備編號<br /> 顯示設備名稱
							</td>
						</tr>
						<tr>
							<th scope="row">執行時間</th>
							<td colspan="3"><input type="text" name="dostartdate" class="Wdate" onfocus="WdatePicker()" style="width: 100px" /> <select name="dostarthour">
									<option value="00">00</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
							</select> 時 <select name="dostartminute">
									<option value="00">00</option>
									<option value="30">30</option>
							</select> 分~ <input type="text" name="doenddate" class="Wdate" onfocus="WdatePicker()" style="width: 100px" /> <select name="doendhour">
									<option value="00">00</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
							</select> 時 <select name="doendminute">
									<option value="00">00</option>
									<option value="30">30</option>
							</select> 分</td>
						</tr>
						<tr>
							<th scope="row">執行人</th>
							<td colspan="3"><div>
<!-- 									<select name="departs" id="departs"> -->
<!-- 										<option value="請選擇部門">請選擇部門</option> -->
<!-- 										<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?>-->
<!-- 										<option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option> -->
<!--<?php endforeach; endif; else: echo "" ;endif; ?> -->
<!-- 									</select> <select name="teams" id="teams"> -->
<!-- 										<option value="">選擇組別</option> -->
<!-- 									</select> -->
									<select name="members" id="members">
										<option value="">請選擇同事</option>
										<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?>(<?php echo ($item["ucode"]); ?>)</option><?php endforeach; endif; else: echo "" ;endif; ?>
									</select> <img src="__PUBLIC__/images/add_16.png" alt="新增" onclick="addUser()" width="16" height="16" style="cursor: pointer;" />
								</div> <input type="hidden" name="dousersname" id="dousersname" />
								<ul style="margin-top: 10px" id="usercontainer">

								</ul></td>
						</tr>
						<tr>
							<th scope="row">說明</th>
							<td colspan="3"><textarea name="doremark" rows="10" style="width: 490px"></textarea></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td colspan="3"><span style="margin-top: 10px"> <input type="submit" name="Submit" value="確定" /> <input type="reset" name="Submit2" value="取消" />
							</span></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop" id="tab_msg">
					<tr>
						<th width="95" scope="col">留言日期</th>
						<th width="83" scope="col">留言人</th>
						<th width="458" scope="col">內容說明</th>
						<th width="57" scope="col">備註</th>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>