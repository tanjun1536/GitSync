<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



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


			<div class="topic">專案管理- 成本分析</div>
			<div class="mainInfo">
				<div style="margin-bottom: 10px">
					<form id="form2" name="form2" method="post" action="">
						西元 <input type="text" name="syear" style="width: 50px" /> / <select name="smonth">
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
						</select> ~ 西元 <input type="text" name="eyear" style="width: 50px" /> / <select name="emonth">
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
						</select> 員工姓名： <input type="text" name="username" /> <input type="submit" name="Submit2" value="搜尋" />
					</form>
				</div>
				<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop">
					<tr>
						<th width="247" scope="col">年/月</th>
						<th width="247" scope="col">姓名</th>
						<th width="346" scope="col">時薪</th>
						<th width="100" align="right" scope="col">小計</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
						<?php else: ?>
						<tr class="trcolor"><?php endif; ?>
					<td align="center"><?php echo ($item["year"]); ?>/<?php echo ($item["month"]); ?></td>
					<td align="center"><a href="__URL__/costanalysisperson?case=<?php echo $_SESSION["case"];?>&memberid=<?php echo ($item["uid"]); ?>&year=<?php echo ($item["year"]); ?>&month=<?php echo ($item["month"]); ?>"><?php echo ($item["name"]); ?>(<?php echo ($item["ucode"]); ?>)</a></td>
					<td align="center"><?php echo ($item["salary"]); ?></td>
					<td align="right"><?php echo ($item["total"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr>
						<td align="center" bgcolor="#F5F5F5">&nbsp;</td>
						<td align="center" bgcolor="#F5F5F5">&nbsp;</td>
						<td align="right" bgcolor="#F5F5F5"><strong>統計金額：</strong></td>
						<td align="right" bgcolor="#F5F5F5"><?php echo ($tt); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>