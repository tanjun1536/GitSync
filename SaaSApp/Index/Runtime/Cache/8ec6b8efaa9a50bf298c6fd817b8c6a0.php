<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>

<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/JavaScript">
	
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
		<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<div class="sideLeft">
	<div>
		<a href="__APP__/User/profile"> <img src="__PUBLIC__/<?php if(empty($_SESSION['SESSION_USER']['userimage'])) echo 'images/3_03.jpg';  else echo 'Uploads/'.$_SESSION['SESSION_USER']['userimage']; ?>" alt="" width="151" border="0" />
		</a>
	</div>
	<div class="name">
		<a href="__APP__/User/Profile"><?php echo $_SESSION['SESSION_USER']['name'] ?></a>
	</div>
	<div id="divdate">
		<script>
			WdatePicker({
				eCont : "divdate",
				skin:"twoer",
				onpicked : function(dp) {
					window.top.location.href='__APP__/Work/index?date=' + dp.cal.getDateStr();
				}
			})
		</script>
	</div>
	<div class="menuSide">
		<ul>
			<?php if(is_array($LeftMenu)): $i = 0; $__LIST__ = $LeftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(empty($item["children"])): ?><?php if($item["name"] == '提醒'): ?><li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?>(<?php echo $_SESSION["AWOKE_WORK"];?>)</a></li>
			<?php else: ?>
			<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a></li><?php endif; ?> <?php else: ?> <?php if($item["name"] == '專案管理'): ?><li><img src="__PUBLIC__/images/hire_me.png" alt="" width="23" height="23" /><a href="__APP__/Case/index">專案管理</a></li>
			<?php else: ?>
			<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><?php echo ($item["name"]); ?>
				<ul>
					<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><?php if($citem["name"] == '一般訊息'): ?><li><a href="__APP__/Msg/index">一般訊息</a>(<?php echo $_SESSION["MSG_COMM"];?>)</li>
					<?php elseif($citem["name"] == '我交辦事項'): ?>
					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_MINE_WORK']>0) echo '<font color="red">我交辦事項('.$_SESSION["MSG_MINE_WORK"].')</font>'; else echo '我交辦事項('.$_SESSION["MSG_MINE_WORK"].')'; ?></a></li>
					<?php elseif($citem["name"] == '他人交辦事項'): ?>
					<li><a href="__APP__/Msg/otherwork"><?php if($_SESSION['MSG_OTHER_WORK']>0) echo '<font color="red">他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')</font>'; else echo '他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')'; ?></a></li>
					<?php else: ?>
					<li><a href="<?php echo ($citem["link"]); ?>"><?php echo ($citem["name"]); ?></a></li><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul></li><?php endif; ?><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- 			<li><img src="__PUBLIC__/images/icon_edit.gif" alt="" width="23" height="23" /><a href="__APP__/User/profile">編輯個人檔案</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/icon_mail.gif" alt="" width="23" height="23" />訊息 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Msg/index">一般訊息</a>(<?php echo $_SESSION["MSG_COMM"];?>)</li> -->
			<!-- 					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_MINE_WORK']>0) echo '<font color="red">我交辦事項('.$_SESSION["MSG_MINE_WORK"].')</font>'; else echo '我交辦事項('.$_SESSION["MSG_MINE_WORK"].')'; ?></a></li> -->
			<!-- 					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_OTHER_WORK']>0) echo '<font color="red">他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')</font>'; else echo '他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')'; ?></a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/icon_recommend.gif" alt="" width="23" height="23" /><a href="__APP__/Remind/index">提醒</a> (<?php echo $_SESSION["AWOKE_WORK"];?>)</li> -->
			<!-- 			<li><img src="__PUBLIC__/images/icon_friend.gif" alt="" width="23" height="23" /><a href="__APP__/User/friend">同事名單</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/company_32.png" alt="" width="23" height="23" />公司管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Company/edit?code=<?php echo $_SESSION["SESSION_USER"]["code"];?>">公司基本資料</a></li> -->
			<!-- 					<li><a href="__APP__/Depart/index">部門管理</a></li> -->
			<!-- 					<li><a href="__APP__/Team/index">組別管理</a></li> -->
			<!-- 					<li><a href="__APP__/Level/index">級別管理</a></li> -->
			<!-- 					<li><a href="__APP__/User/index">員工管理</a></li> -->
			<!-- 					<li><a href="__APP__/Limit/index">權限管理</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/document.png" alt="" width="23" height="23" /><a href="__APP__/Contract/index">合約管理</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/user_business_chart_32.png" alt="" width="23" height="23" /><a href="__APP__/Customer/index">客戶管理</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/page_text_chart_32.png" alt="" width="23" height="23" />業務管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Business/index">業務資料追蹤表</a></li> -->
			<!-- 					<li><a href="__APP__/Business/bid">業務報價管理</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/hire_me.png" alt="" width="23" height="23" /><a href="__APP__/Case/index">專案管理</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/pd_32.png" alt="" width="23" height="23" />商品管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Stock/productBigType">商品類別管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/product">商品列表</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/business_32.png" alt="" width="23" height="23" />廠商管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Stock/manufacturersType">廠商類別管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/manufacturers">廠商列表</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/stock.png" alt="" width="23" height="23" />進銷存管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Stock/stock">庫存管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/purchase">採購管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/stockCheck">驗貨管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/stockStorage">進貨管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/stockChange">異動管理</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/accounting.png" alt="" width="23" height="23" />會計系統 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Account/accountlist">常用帳號設定</a></li> -->
			<!-- 					<li><a href="__APP__/Account/subjectlist">科目設定</a></li> -->
			<!-- 					<li><a href="__APP__/Account/incomelist">收入管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/paylist">支付管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/billlist">傳票管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/caselist">專案管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/budgetlist">預算管理</a></li> -->
			<!-- 				</ul></li> -->
		</ul>
	</div>
</div>

		<div class="mainPage">
			<ul id="navmenu-h">
<?php if(is_array($TopMenu)): $i = 0; $__LIST__ = $TopMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(empty($item["children"])): ?><li><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a></li>
			<?php else: ?>
			<li><a href="#"><?php echo ($item["name"]); ?></a>
				<ul>
					<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><li><a href="<?php echo ($citem["link"]); ?>"><?php echo ($citem["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					
				</ul></li><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
		<li><a href="__APP__/Favorite">我的最愛</a>  </li>
</ul>


			<div class="topic">工程管理 - 工程報價</div>
			<div class="mainInfo">
				<div class="topic2">工程報價單</div>
				<table width="695" border="0" cellpadding="0" cellspacing="1"
					class="tabThSide">

					<tr>
						<th scope="row">報價單號</th>
						<td><?php echo ($price["pricecode"]); ?></td>
						<th scope="row">報價日期</th>
						<td><?php echo ($price["pricedate"]); ?></td>
					</tr>
					<tr>
						<th width="128" scope="row">分項</th>
						<td width="216"><?php echo ($price["pricesubitem"]); ?></td>
						<th width="122" scope="row">BU單位</th>
						<td width="224"><?php echo ($price["BUunit"]); ?></td>
					</tr>
					<tr>
						<th scope="row">製表人</th>
						<td colspan="3"><?php echo ($price["tabulator"]); ?></td>
					</tr>
					<tr>
						<th scope="row">承辦人</th>
						<td colspan="3"><?php echo ($price["undertakername"]); ?></td>
					</tr>
					<tr>
						<th scope="row">承辦人電話</th>
						<td><?php echo ($price["phone"]); ?></td>
						<th scope="row">承辦人EMAIL</th>
						<td><?php echo ($price["email"]); ?></td>
					</tr>
					<tr>
						<th scope="row">案場名稱</th>
						<td colspan="3"><?php echo ($price["casename"]); ?></td>
					</tr>
					<tr>
						<th scope="row">工程名稱</th>
						<td colspan="3"><?php echo ($price["projectname"]); ?></td>
					</tr>
					<tr>
						<th scope="row">客戶名稱</th>
						<td><?php echo ($price["clientname"]); ?></td>
						<th scope="row">聯絡人</th>
						<td><?php echo ($price["linker"]); ?></td>
					</tr>
					<tr>
						<th scope="row">客戶地址</th>
						<td colspan="3"><?php echo ($price["clientprovname"]); ?><?php echo ($price["clientcityname"]); ?><?php echo ($price["clietnaddress"]); ?></td>
					</tr>
					<tr>
						<th scope="row">客戶統編</th>
						<td><?php echo ($price["clientcode"]); ?></td>
						<th scope="row">客戶電話</th>
						<td><?php echo ($price["clientphone"]); ?></td>
					</tr>
					<tr>
						<th scope="row">客戶傳真</th>
						<td colspan="3"><?php echo ($price["clientfax"]); ?></td>
					</tr>
					<tr>
						<th scope="row">送貨(工程地點)</th>
						<td colspan="3"><?php echo ($price["projectprovname"]); ?><?php echo ($price["projectcityname"]); ?><?php echo ($price["projectaddress"]); ?></td>
					</tr>
					<tr>
						<th scope="row">預估施工方式</th>
						<td colspan="3"><?php echo ($price["estimateconstructionmethods"]); ?></td>
					</tr>
					<tr>
						<th scope="row">預估委外方式</th>
						<td colspan="3"><?php echo ($price["estimatedelegatemethods"]); ?></td>
					</tr>
					<tr>
						<th scope="row">預估工資成本</th>
						<td><?php echo ($price["estimatesalarycost"]); ?></td>
						<th scope="row">預估材料成本</th>
						<td><?php echo ($price["estimatemeterialcost"]); ?></td>
					</tr>
					<tr>
						<th scope="row">預估發包成本</th>
						<td><?php echo ($price["estimatefbcost"]); ?></td>
						<th scope="row">預估其他成本</th>
						<td><?php echo ($price["estimateothercost"]); ?></td>
					</tr>
					<tr>
						<th scope="row">預估總成本</th>
						<td><?php echo ($price["estimatetotalcost"]); ?></td>
						<th scope="row">成交價</th>
						<td><?php echo ($price["strikeprice"]); ?></td>
					</tr>
					<tr>
						<th scope="row">預估毛利</th>
						<td><?php echo ($price["estimategrossprofit"]); ?></td>
						<th scope="row">預估毛利率</th>
						<td><?php echo ($price["estimategrossprofitrate"]); ?></td>
					</tr>
					<tr>
						<th scope="row">實際施工方式</th>
						<td colspan="3"><?php echo ($price["factconstructionmethods"]); ?></td>
					</tr>
					<tr>
						<th scope="row">實際委外方式</th>
						<td colspan="3"><?php echo ($price["factdelegatemethods"]); ?></td>
					</tr>
					<tr>
						<th scope="row">實際委外廠商</th>
						<td><?php echo ($price["factdelegatecompany"]); ?></td>
						<th scope="row">實際工資成本</th>
						<td><?php echo ($price["factsalarycost"]); ?></td>
					</tr>
					<tr>
						<th scope="row">實際材料成本</th>
						<td><?php echo ($price["factmeterialcost"]); ?></td>
						<th scope="row">實際其他成本</th>
						<td><?php echo ($price["facttotalcost"]); ?></td>
					</tr>
					<tr>
						<th scope="row">實際總成本</th>
						<td><?php echo ($price["facttotalcost"]); ?></td>
						<th scope="row">實際成交價</th>
						<td><?php echo ($price["factstrikeprice"]); ?></td>
					</tr>
					<tr>
						<th scope="row">實際毛利</th>
						<td><?php echo ($price["factgrossprofit"]); ?></td>
						<th scope="row">實際毛利率</th>
						<td><?php echo ($price["factgrossprofitrate"]); ?></td>
					</tr>
					<tr>
						<th scope="row">備註說明</th>
						<td colspan="3"><?php echo ($price["projectremark"]); ?></td>
					</tr>
				</table>
				<table width="695" border="0" cellpadding="0" cellspacing="1"
					class="tabThSide">
					<tr>
						<th width="34" scope="col">NO</th>
						<th width="326" scope="col">品名/項目</th>
						<th width="53" scope="col">數量</th>
						<th width="54" scope="col">單位</th>
						<th width="60" scope="col">單價</th>
						<th width="69" scope="col">複價</th>
						<th width="91" scope="col">備註/規格</th>
					</tr>
					<?php if(is_array($details)): $i = 0; $__LIST__ = $details;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr class="trcolor">
						<?php else: ?>
						<tr><?php endif; ?>
					<td align="center"><?php echo ($i); ?></td>
					<td><?php echo ($item["productname"]); ?></td>
					<td align="center"><?php echo ($item["productquantity"]); ?></td>
					<td align="center"><?php echo ($item["productunit"]); ?></td>
					<td align="center"><?php echo ($item["price"]); ?></td>
					<td align="center"><?php echo ($item["productfj"]); ?></td>
					<td align="center"><?php echo ($item["remark"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
				<div>
					<p>
						合計：<?php echo ($price["total"]); ?><br /> 稅金(5%)：<?php echo ($price["taxprice"]); ?><br /> 總價：<?php echo ($price["totalprice"]); ?><br /> 備註：<?php echo ($price["priceremark"]); ?><br />
					</p>
				</div>
				<div class="back">
					<a href="javascript:window.history.go(-1)">》回上頁</a>
				</div>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>