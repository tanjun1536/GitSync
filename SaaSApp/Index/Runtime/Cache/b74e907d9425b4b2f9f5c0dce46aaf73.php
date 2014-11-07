<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
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
				<div class="topic2">叫修記錄</div>
				<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
					<tr>
						<th scope="row">叫修單編號</th>
						<td><?php echo ($repair["repaircode"]); ?></td>
						<th scope="row">叫修日期</th>
						<td><?php echo (date('Y/m/d H:i:s',strtotime($repair["repairdate"]))); ?></td>
					</tr>
					<tr>
						<th width="123" scope="row">樓層區域</th>
						<td width="359"><?php echo ($repair["bname"]); ?>／<?php echo ($repair["bfname"]); ?>／<?php echo ($repair["aname"]); ?></td>
						<th width="77" scope="row">申請人</th>
						<td width="131"><?php echo ($repair["requestuser"]); ?></td>
					</tr>
					<tr>
						<th scope="row">設備類別</th>
						<td colspan="3"><?php echo ($repair["tname"]); ?>／<?php echo ($repair["ctname"]); ?></td>
					</tr>
					<tr>
						<th scope="row">設備編號／名稱</th>
						<td colspan="3"><label><?php echo ($repair["devicecode"]); ?><br /> <?php echo ($repair["devicename"]); ?><br /> <strong>附件：</strong><a href="__URL__/down?name=<?php echo (urlencode($repair["atts"])); ?>" target="_blank"><?php echo ($repair["atts"]); ?></a>
						</label></td>
					</tr>
					<tr>
						<th scope="row">派工</th>
						<td colspan="3"><ul>
								<li><strong>派工日期：</strong> <?php if(!empty($dispatch)): ?><?php if(($dispatch["dispatchdate"])  !=  "0000-00-00 00:00:00"): ?><?php echo (date('Y/m/d',strtotime($dispatch["dispatchdate"]))); ?><?php endif; ?><?php endif; ?></li>
								<li><strong>執行時間：</strong>
								<?php if(!empty($dispatch)): ?><?php if(($dispatch["dostartdate"])  !=  "0000-00-00 00:00:00"): ?><?php echo (date('Y/m/d',strtotime($dispatch["dostartdate"]))); ?><?php endif; ?> <?php echo ($dispatch["dostarthour"]); ?>:<?php echo ($dispatch["dostartminute"]); ?> - <?php if(($dispatch["doenddate"])  !=  "0000-00-00 00:00:00"): ?><?php echo (date('Y/m/d',strtotime($dispatch["doenddate"]))); ?><?php endif; ?><?php echo ($dispatch["doendhour"]); ?>:<?php echo ($dispatch["doendminute"]); ?><?php endif; ?></li>
								<li><strong>執行人：</strong><?php echo ($dispatch["dousersname"]); ?></li>
							</ul></td>
					</tr>
					<tr>
						<th scope="row">委外</th>
						<td colspan="3"><ul>
								<li><strong>委外日期：</strong> <?php if(!empty($delegate)): ?><?php if(($delegate["delegatedate"])  !=  "0000-00-00 00:00:00"): ?><?php echo (date('Y/m/d',strtotime($delegate["delegatedate"]))); ?><?php endif; ?><?php endif; ?></li>
								<li><strong>委外廠商：</strong><?php echo ($delegate["manufactures"]); ?></li>
								<li><strong>連絡人：</strong><?php echo ($delegate["linker"]); ?></li>
								<li><strong>聯絡電話：</strong><?php echo ($delegate["linkphone"]); ?></li>
							</ul></td>
					</tr>
					<tr>
						<th scope="row">完工</th>
						<td colspan="3"><ul>
								<li><strong>完工日期：</strong> <?php if(!empty($complete)): ?><?php if(($complete["completedate"])  !=  "0000-00-00 00:00:00"): ?><?php echo (date('Y/m/d',strtotime($complete["completedate"]))); ?><?php endif; ?><?php endif; ?></li>
								<li><strong>實際執行人／時間：</strong><br /> <?php $_result=explode(',',$complete['dotimeandusers']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tu): ++$i;$mod = ($i % 2 )?><li><?php echo ($tu); ?></li><?php endforeach; endif; else: echo "" ;endif; ?></li>
								<li><strong>附件：</strong> <?php if(($complete["atts"])  !=  ""): ?><?php $_result=explode(',',$complete['atts']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$att): ++$i;$mod = ($i % 2 )?><a href="__URL__/down?name=<?php echo (urlencode($att)); ?>" target="_blank"><?php echo ($att); ?></a>；<?php endforeach; endif; else: echo "" ;endif; ?><?php endif; ?></li>
							</ul></td>
					</tr>
					<tr>
						<th scope="row">相關聯結</th>
						<td colspan="3"><ul>
								<?php $_result=explode(',',$complete['links']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): ++$i;$mod = ($i % 2 )?><li><a href="<?php echo ($link); ?>" target="_blank"><?php echo ($link); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul></td>
					</tr>
				</table>
				<div class="mailNav">
					<a href="#m1">我要留言</a>
				</div>
				<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop">
					<tr>
						<th width="95" scope="col">留言日期</th>
						<th width="83" scope="col">留言人</th>
						<th width="458" scope="col">內容說明</th>
						<th width="57" scope="col">備註</th>
					</tr>
					<?php if(is_array($msgs)): $i = 0; $__LIST__ = $msgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
						<?php else: ?>
						<tr class="trcolor"><?php endif; ?>
					<td align="center"><?php if(($item["senddate"])  !=  "0000-00-00 00:00:00"): ?><?php echo (date('Y/m/d',strtotime($item["senddate"]))); ?><?php endif; ?> </notempty></td>
					<td align="center"><?php echo ($item["senduser"]); ?></td>
					<td><?php echo ($item["msg"]); ?></td>
					<td align="center"><?php echo ($item["msgtype"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
				<div class="pages"><?php echo ($page); ?></div>
				<div class="topic2">
					我要留言<a name="m1" id="m1"></a>
				</div>
				<form id="form1" onsubmit="$('#senddate').val(new Date().format('yyyy-MM-dd hh:mm:ss'))" name="form1" method="post" action="__URL__/addRepairViewMessage?case=<?php echo ($repair["case"]); ?>&id=<?php echo ($repair["id"]); ?>">
					<input type="hidden" value="<?php echo ($repair["id"]); ?>" name="repair"><input type="hidden" name="senddate" id="senddate"><input type="hidden" name="senduser" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>"> <textarea name="msg" rows="6" style="width: 695px"></textarea>
								<div style="margin-top: 10px">
									<input type="submit" name="Submit" value="送出留言" /> <input type="reset" name="Submit2" value="取消" />
								</div>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>