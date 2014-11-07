<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
	function addDetail()
	{
		if(validator.index("member","請選擇專案員工")&&
				validator.empty("movedate","請選擇日期")&&
				validator.index("oldworktype","請選擇班別")&&
				validator.index("newworktype","請選擇調班後班別"))
		{
			var tab=$("#tabDetail");
			var len = $("#tabDetail tr").length;
			var row = len % 2 == 1 ? $("<tr class=\"trcolor\"></tr>") : $("<tr></tr>");
			var hValue = $('#member').val() + "," + $('#movedate').val() + "," + $('#oldworktype').val() + "," + $('#newworktype').val();
			row.append($("<td align=\"center\"></td>").append($('#member').val()).append($("<input type='hidden' value='" + hValue + "' name ='detail[]' />")));
			row.append($("<td align=\"center\"></td>").append($('#movedate').val()));
			row.append($("<td align=\"center\"></td>").append($('#oldworktype').val()));
			row.append($("<td align=\"center\"></td>").append($('#newworktype').val()));
			row.append($("<td align=\"center\"></td>").append($('<img onclick="$(this).parent().parent().remove();calTotal();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			tab.append(row);
			$('#member').val('');
			$('#movedate').val('');
			$('#oldworktype').val('');
			$('#newworktype').val('');
		}
		
		
	}
	function check()
	{
		var datas = [];
		$("#tabDetail tr").each(function(i) {
			if (i > 0) {
				var tds = $(this).find("td");
				var data = new Object();
				data.code = $(tds[0]).html();
				data.area = $(tds[1]).html();
				data.username = $(tds[2]).html();
				data.gaugecode = $(tds[3]).html();
				data.type = $(tds[4]).html();
				data.predegree = $(tds[5]).html();
				data.alldegree = $(tds[6]).find('input').val();
				data.thisdegree = $(tds[7]).html();
				datas.push(data);
			}
		});
		$("#data").val($.toJSON(datas));
		//alert($.toJSON(datas));
		return true;
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


			<div class="topic">專案管理- 調班管理</div>
			<div class="mainInfo">
				<div class="topic2">新增/ 修改調班單</div>
				<form id="form1" name="form1" method="post" action="__URL__/insertWorkShift?case=<?php echo $_SESSION["case"];?>" onsubmit="return check();">
					<input type="hidden" name="case" value="<?php echo $_SESSION["case"];?>" /> 
					<input type="hidden" name="keyusername" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>(<?php echo $_SESSION["SESSION_USER"]["ucode"];?>)" />
					 <input type="hidden" name="keyuserid" value="<?php echo $_SESSION["SESSION_USER"]["id"];?>" /> 
					 <input type="hidden" name="movetime" value="<?php echo ($date); ?>" />
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="95" scope="row">調班單號</th>
							<td width="249"><input type="text" name="movecode" /></td>
							<th width="102" scope="row">KEY單人</th>
							<td width="244"><?php echo $_SESSION["SESSION_USER"]["name"];?></td>
						</tr>
						<tr>
							<th scope="row">調班月份</th>
							<td>西元 <input type="text" name="moveyear" style="width: 70px" /> 年 <select name="movemonth">
									<option value="1月">1月</option>
									<option value="2月">2月</option>
									<option value="3月">3月</option>
									<option value="4月">4月</option>
									<option value="5月">5月</option>
									<option value="6月">6月</option>
									<option value="7月">7月</option>
									<option value="8月">8月</option>
									<option value="9月">9月</option>
									<option value="10月">10月</option>
									<option value="11月">11月</option>
									<option value="12月">12月</option>
							</select>
							</td>
							<th scope="row">KEY單時間</th>
							<td><?php echo ($date); ?></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop" id="tabDetail">
						<tr>
							<th width="167" scope="col">員工姓名</th>
							<th width="159" scope="col">日期</th>
							<th width="148" scope="col">班別</th>
							<th width="168" scope="col">調班後班別</th>
							<th width="51" scope="col">操作</th>
						</tr>
						<tr>
							<td align="center"><select id="member">
									<option value="">請選擇專案員工</option>
									<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["name"]); ?>(<?php echo ($item["ucode"]); ?>)"><?php echo ($item["name"]); ?>(<?php echo ($item["ucode"]); ?>)</option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<td align="center"><input type="text" id="movedate" class="Wdate" onfocus="WdatePicker()" /></td>
							<td align="center"><select id="oldworktype">
									<option value="">請選擇</option>
									<?php if(is_array($works)): $i = 0; $__LIST__ = $works;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["workcode"]); ?>"><?php echo ($item["workcode"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<td align="center"><select id="newworktype">
									<option value="">請選擇</option>
									<?php if(is_array($works)): $i = 0; $__LIST__ = $works;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["workcode"]); ?>"><?php echo ($item["workcode"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<td align="center"><a href="javascript:void(0)"><img onclick="addDetail()" src="__PUBLIC__/images/add_16.png" alt="新增" width="16" height="16" border="0" /></a></td>
						</tr>
					</table>
					<div align="center" style="margin-top: 10px">
						<input type="submit" name="Submit" value="確定" /> <input type="reset" name="Submit2" value="取消" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>