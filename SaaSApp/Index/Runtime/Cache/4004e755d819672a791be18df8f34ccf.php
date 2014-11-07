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
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
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
	<div class="calendar">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="clmonth" summary="2007年9月份月曆">
			<tr>
				<th height="20" colspan="7" bgcolor="#000000" scope="col"><a href="#">&lt;&lt;</a> <span class="month"><script>
					var d = new Date();
					document.write(d.getFullYear());
					document.write('年');
					document.write(d.getMonth()+1);
					document.write('月');
				</script></span> <a href="#">&gt;&gt;</a></th>
			</tr>
			<tr>
				<th height="20" bgcolor="#dedede" scope="col">日</th>
				<th bgcolor="#dedede" scope="col">一</th>
				<th bgcolor="#dedede" scope="col">二</th>
				<th bgcolor="#dedede" scope="col">三</th>
				<th bgcolor="#dedede" scope="col">四</th>
				<th bgcolor="#dedede" scope="col">五</th>
				<th bgcolor="#dedede" scope="col">六</th>
			</tr>
			<script type="text/javascript">
				var d = new Date();
				var year = d.getFullYear();
				var month = d.getMonth();
					month++;
				var dayOfWeek = new Date(year,month,1).getDay();
				var days = new Date(year, month, 0).getDate();
				var curr=0;
				var i=0;
				var txt;
				for (curr=0 ; curr<days; i++) {
					curr=i+1-dayOfWeek;
					txt=curr;
					if(curr==d.getDate())txt='<a href="#"  ><font color="red" >'+curr+'</font></a>';
					if (i == 0 || i % 7 == 0) {
						document.write('<tr>');
						if (curr>0)
							document.write('<td bgcolor="#FFFBE8">' + txt + '</td>');
						else
							document.write('<td bgcolor="#FFFBE8">&nbsp;</td>');
					}
					
					else if ((i + 1) % 7 == 0) {
						document.write('<td bgcolor="#FFFBE8">' + txt + '</td>');
						document.write('</tr>');
					}
					else
						{
							if (curr>0)
								document.write('<td bgcolor="#FFFFFF">' + txt + '</td>');
							else
								document.write('<td bgcolor="#FFFFFF">&nbsp;</td>');
						}
				}
				for(var j=0;j<(7-i%7);j++)
					{
					document.write('<td bgcolor="#FFFFFF">&nbsp;</td>');
					}
			</script>
			<!-- 			<tr> -->
			<!-- 				<td bgcolor="#FFFBE8">&nbsp;</td> -->
			<!-- 				<td bgcolor="#FFFFFF">1</td> -->
			<!-- 				<td bgcolor="#FFFFFF">2</td> -->
			<!-- 				<td bgcolor="#FFFFFF">3</td> -->
			<!-- 				<td bgcolor="#FFFFFF">4</td> -->
			<!-- 				<td bgcolor="#FFFFFF">5</td> -->
			<!-- 				<td bgcolor="#FFFBE8">6</td> -->
			<!-- 			</tr> -->
			<!-- 			<tr> -->
			<!-- 				<td bgcolor="#FFFBE8">7</td> -->
			<!-- 				<td bgcolor="#FFFFFF">8</td> -->
			<!-- 				<td bgcolor="#FFFFFF">9</td> -->
			<!-- 				<td bgcolor="#FFFFFF"><a href="remind_exlist.php" class="active">10</a></td> -->
			<!-- 				<td bgcolor="#FFFFFF">11</td> -->
			<!-- 				<td bgcolor="#FFFFFF">12</td> -->
			<!-- 				<td bgcolor="#FFFBE8">13</td> -->
			<!-- 			</tr> -->
			<!-- 			<tr> -->
			<!-- 				<td bgcolor="#FFFBE8">14</td> -->
			<!-- 				<td bgcolor="#FFFFFF">15</td> -->
			<!-- 				<td bgcolor="#FFFFFF">16</td> -->
			<!-- 				<td bgcolor="#FFFFFF">17</td> -->
			<!-- 				<td bgcolor="#FFFFFF">18</td> -->
			<!-- 				<td bgcolor="#FFFFFF">19</td> -->
			<!-- 				<td bgcolor="#FFFBE8">20</td> -->
			<!-- 			</tr> -->
			<!-- 			<tr> -->
			<!-- 				<td bgcolor="#FFFBE8"><a href="remind_list.php" class="active">21</a></td> -->
			<!-- 				<td bgcolor="#FFFFFF">22</td> -->
			<!-- 				<td bgcolor="#FFFFFF">23</td> -->
			<!-- 				<td bgcolor="#FFFFFF">24</td> -->
			<!-- 				<td bgcolor="#FFFFFF">25</td> -->
			<!-- 				<td bgcolor="#FFFFFF" class="today">26</td> -->
			<!-- 				<td bgcolor="#FFFBE8">27</td> -->
			<!-- 			</tr> -->
			<!-- 			<tr> -->
			<!-- 				<td bgcolor="#FFFBE8">28</td> -->
			<!-- 				<td bgcolor="#FFFFFF">29</td> -->
			<!-- 				<td bgcolor="#FFFFFF">30</td> -->
			<!-- 				<td bgcolor="#FFFFFF">31</td> -->
			<!-- 				<td bgcolor="#FFFFFF">&nbsp;</td> -->
			<!-- 				<td bgcolor="#FFFFFF">&nbsp;</td> -->
			<!-- 				<td bgcolor="#FFFBE8">&nbsp;</td> -->
			<!-- 			</tr> -->
		</table>
	</div>
	<div class="menuSide">

		<ul>
			<?php if(is_array($LeftMenu)): $i = 0; $__LIST__ = $LeftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(empty($item["children"])): ?><?php if($item["name"] == '提醒'): ?><li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?>(<?php echo $_SESSION["AWOKE_WORK"];?>)</a></li>
				<?php else: ?>
					<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a></li><?php endif; ?>
			<?php else: ?> 
			<?php if($item["name"] == '專案管理'): ?><li><img src="__PUBLIC__/images/hire_me.png" alt="" width="23" height="23" /><a href="__APP__/Case/index">專案管理</a></li>
					
					<?php else: ?>
			<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><?php echo ($item["name"]); ?>
				<ul>
					<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><?php if($citem["name"] == '一般訊息'): ?><li><a href="__APP__/Msg/index">一般訊息</a>(<?php echo $_SESSION["MSG_COMM"];?>)</li>
					<?php elseif($citem["name"] == '我交辦事項'): ?>
					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_MINE_WORK']>0) echo '<font color="red">我交辦事項('.$_SESSION["MSG_MINE_WORK"].')</font>'; else echo '我交辦事項('.$_SESSION["MSG_MINE_WORK"].')'; ?></a></li>
					<?php elseif($citem["name"] == '他人交辦事項'): ?>
					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_OTHER_WORK']>0) echo '<font color="red">他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')</font>'; else echo '他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')'; ?></a></li>
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
</ul>


			<div class="topic">文件管理 - 電子簽呈</div>
			<div class="mainInfo">
				<div class="mailNav">
					<form id="form2" name="form2" method="post" action="__URL__/index">
						<a href="__URL__/add">新增簽呈</a><a href="__URL__/index" class="select">寄出的簽呈</a> <a href="__URL__/receive">收到的簽呈</a> 開始日期 <input type="text" name="requesterdate" class="Wdate" onfocus="WdatePicker();" style="width: 100px" /> <select name="state">
							<option value="">選擇狀態</option>
							<?php if(!empty($state)): ?><?php if($state == '申請'): ?><option value="申請" selected="selected">申請</option>
							<?php else: ?>
							<option value="申請">申請</option><?php endif; ?> <?php if($state == '簽核中'): ?><option value="簽核中" selected="selected">簽核中</option>
							<?php else: ?>
							<option value="簽核中">簽核中</option><?php endif; ?> <?php if($state == '生效'): ?><option value="生效" selected="selected">生效</option>
							<?php else: ?>
							<option value="生效">生效</option><?php endif; ?> <?php if($state == '作廢'): ?><option value="作廢" selected="selected">作廢</option>
							<?php else: ?>
							<option value="作廢">作廢</option><?php endif; ?> <?php if($state == '不同意'): ?><option value="不同意" selected="selected">不同意</option>
							<?php else: ?>
							<option value="不同意">不同意</option><?php endif; ?> <?php else: ?>
							<option value="選擇狀態">選擇狀態</option>
							<option value="申請">申請</option>
							<option value="簽核中">簽核中</option>
							<option value="生效">生效</option>
							<option value="作廢">作廢</option>
							<option value="不同意">不同意</option><?php endif; ?>

						</select> <input type="submit" name="Submit3" value="搜尋" />

					</form>
				</div>
				<form id="form1" name="form1" method="post" action="__URL__/dirty">
					<table width="695" border="0" cellpadding="0" cellspacing="0" class="mailList">
						<tr>
							<th width="28" scope="col">&nbsp;</th>
							<th width="75" scope="col">申請日期</th>
							<th width="101" scope="col">類別</th>
							<th width="291" scope="col">名稱</th>
							<th width="148" scope="col">起迄時間</th>
							<th width="52" scope="col"><div align="center">狀態</div></th>
						</tr>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
							<?php else: ?>
							<tr class="trcolor"><?php endif; ?>
						<td align="center"><input type="checkbox" name="itemcheckbox[]" value="<?php echo ($item["id"]); ?>" /></td>
						<td><?php echo (date('y/m/d',strtotime($item["requesterdate"]))); ?></td>
						<td><?php echo ($item["typename"]); ?></td>
						<td><a href="__URL__/view?id=<?php echo ($item["id"]); ?>"><?php echo ($item["typechildname"]); ?></a></td>
						<td>起：<?php echo (date('y/m/d',strtotime($item["sdate"]))); ?> <?php echo ($item["shour"]); ?>:<?php echo ($item["sminute"]); ?><br /> 迄：<?php echo (date('y/m/d',strtotime($item["edate"]))); ?> <?php echo ($item["ehour"]); ?>:<?php echo ($item["eminute"]); ?>
						</td>
						<td align="center"><?php echo ($item["state"]); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
					<div style="margin-top: 10px">
						<label> <input type="submit" name="Submit2" value="作廢" />
						</label>
					</div>
				</form>
				<div class="pages"><?php echo ($page); ?></div>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>