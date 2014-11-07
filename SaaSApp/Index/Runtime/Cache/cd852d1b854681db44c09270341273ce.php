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
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
<script type="text/javascript">
	$(function() {
		//2個查詢都可以
		//$("#tab_Detail input").live('keyup',function(){
		$("#tab_Detail input[type='text']").live(
				'keyup',
				function() {
					$("#tdTotal").html(
							fn.getFloat($("#m1").val()) + fn.getFloat($("#m2").val()) + fn.getFloat($("#m3").val()) + fn.getFloat($("#m4").val()) + fn.getFloat($("#m5").val()) + fn.getFloat($("#m6").val()) + fn.getFloat($("#m7").val()) + fn.getFloat($("#m8").val()) + fn.getFloat($("#m9").val()) + fn.getFloat($("#m10").val()) + fn.getFloat($("#m11").val())
									+ fn.getFloat($("#m12").val()));
				});
		$("#createdate").val(new Date().format("yyyy/MM/dd hh:mm"));
		$("#tdCreateDate").html($("#createdate").val());
	});
	function check() {
		return true;
	}
	function addDetail() {
		if (validator.index('subject', '請選擇科目!') && validator.empty('m1', '請輸入1月預算!') && validator.empty('m2', '請輸入2月預算!') && validator.empty('m3', '請輸入3月預算!') && validator.empty('m4', '請輸入4月預算!') && validator.empty('m5', '請輸入5月預算!') && validator.empty('m6', '請輸入6月預算!') && validator.empty('m7', '請輸入7月預算!') && validator.empty('m8', '請輸入8月預算!')
				&& validator.empty('m9', '請輸入9月預算!') && validator.empty('m10', '請輸入10月預算!') && validator.empty('m11', '請輸入11月預算!') && validator.empty('m12', '請輸入12月預算!')

		) {
			var table = $('#tab_Detail');
			var len = $("#tab_Detail tr").length;
			var row = len % 2 == 0 ? $("<tr class=\"trcolor\"></tr>") : $("<tr></tr>");
			var hValue = $('#subject').find("option:selected").text() + "," + $('#m1').val() + "," + $('#m2').val() + "," + $('#m3').val() + "," + $('#m4').val() + "," + $('#m5').val() + "," + $('#m6').val() + "," + $('#m7').val() + "," + $('#m8').val() + "," + $('#m9').val() + "," + $('#m10').val() + "," + $('#m11').val() + "," + $('#m12').val() + "," + $("#tdTotal").html();
			row.append($("<td></td>").append($('#subject option:selected').text()).append($("<input type='hidden' value='" + hValue + "' name ='budgetdetail[]' />")));
			row.append($("<td align=\"right\"></td>").append($('#m1').val()));
			row.append($("<td align=\"right\"></td>").append($('#m2').val()));
			row.append($("<td align=\"right\"></td>").append($('#m3').val()));
			row.append($("<td align=\"right\"></td>").append($('#m4').val()));
			row.append($("<td align=\"right\"></td>").append($('#m5').val()));
			row.append($("<td align=\"right\"></td>").append($('#m6').val()));
			row.append($("<td align=\"right\"></td>").append($('#m7').val()));
			row.append($("<td align=\"right\"></td>").append($('#m8').val()));
			row.append($("<td align=\"right\"></td>").append($('#m9').val()));
			row.append($("<td align=\"right\"></td>").append($('#m10').val()));
			row.append($("<td align=\"right\"></td>").append($('#m11').val()));
			row.append($("<td align=\"right\"></td>").append($('#m12').val()));
			row.append($("<td align=\"right\"></td>").append($("#tdTotal").html()));
			row.append($("<td></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#object').val('');
			$('#m1').val('');
			$('#m2').val('');
			$('#m3').val('');
			$('#m4').val('');
			$('#m5').val('');
			$('#m6').val('');
			$('#m7').val('');
			$('#m8').val('');
			$('#m9').val('');
			$('#m10').val('');
			$('#m11').val('');
			$('#m12').val('');
			$('#tdTotal').html('');
		}

	}
</script>
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


			<div class="topic">會計系統 - 預算管理</div>
			<div class="mainInfo">
				<form action="__URL__/addBudget" method="post" enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" />
					<input type="hidden" name="id" value="<?php echo ($budget["id"]); ?>" />
					 <input type="hidden" name="createdate" value="<?php echo (date('Y-m-d',strtotime($budget["createdate"]))); ?>" />
					<div class="topic2">新增 / 修改預算編列資料</div>

					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="88" scope="row">建立日期</th>
							<td width="255" id="tdCreateDate"><?php echo (date('Y-m-d',strtotime($budget["createdate"]))); ?></td>
							<th width="101" scope="row">編列人</th>
							<td width="246"><input type="text" name="createuser" value="<?php echo ($budget["createuser"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">預算名稱</th>
							<td colspan="3"><input type="text" name="name" value="<?php echo ($budget["name"]); ?>" /></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tab_month" id="tab_Detail">
						<tr>
							<th width="161" scope="col">部門名稱</th>
							<th width="34" scope="col">1月</th>
							<th width="34" scope="col">2月</th>
							<th width="34" scope="col">3月</th>
							<th width="34" scope="col">4月</th>
							<th width="34" scope="col">5月</th>
							<th width="34" scope="col">6月</th>
							<th width="34" scope="col">7月</th>
							<th width="34" scope="col">8月</th>
							<th width="34" scope="col">9月</th>
							<th width="36" scope="col">10月</th>
							<th width="36" scope="col">11月</th>
							<th width="42" scope="col">12月</th>
							<th width="80" scope="col"><div style="width: 60px">總計</div></th>
							<th width="17" scope="col">&nbsp;</th>
						</tr>
						<tr class="trcolor1">
							<td><select id="subject" style="width: 120px">
									<option value="選擇部門">選擇部門</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<td><input type="text" id="m1" style="width: 25px" /></td>
							<td><input type="text" id="m2" style="width: 25px" /></td>
							<td><input type="text" id="m3" style="width: 25px" /></td>
							<td><input type="text" id="m4" style="width: 25px" /></td>
							<td><input type="text" id="m5" style="width: 25px" /></td>
							<td><input type="text" id="m6" style="width: 25px" /></td>
							<td><input type="text" id="m7" style="width: 25px" /></td>
							<td><input type="text" id="m8" style="width: 25px" /></td>
							<td><input type="text" id="m9" style="width: 25px" /></td>
							<td><input type="text" id="m10" style="width: 25px" /></td>
							<td><input type="text" id="m11" style="width: 25px" /></td>
							<td><input type="text" id="m12" style="width: 25px" /></td>
							<td align="right" id="tdTotal"></td>
							<td><img src="__PUBLIC__/images/add_16.png" alt="新增" onclick="addDetail()" style="cursor: pointer;" width="16" height="16" border="0" /></td>
						</tr>
						<?php if(is_array($details)): $i = 0; $__LIST__ = $details;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><volist name="list" id="item"> <?php if($i%2 == 1): ?><tr>
							<?php else: ?>
							<tr class="trcolor"><?php endif; ?> 
						<td><?php echo ($item["subject"]); ?><input type="hidden" name="budgetdetail[]" value="<?php echo ($item["subject"]); ?>,<?php echo ($item["m1"]); ?>,<?php echo ($item["m2"]); ?>,<?php echo ($item["m3"]); ?>,<?php echo ($item["m4"]); ?>,<?php echo ($item["m5"]); ?>,<?php echo ($item["m6"]); ?>,<?php echo ($item["m7"]); ?>,<?php echo ($item["m8"]); ?>,<?php echo ($item["m9"]); ?>,<?php echo ($item["m10"]); ?>,<?php echo ($item["m11"]); ?>,<?php echo ($item["m12"]); ?>,<?php echo ($item["total"]); ?>" /></td>
						<td align="right"><?php echo ($item["m1"]); ?></td>
						<td align="right"><?php echo ($item["m2"]); ?></td>
						<td align="right"><?php echo ($item["m3"]); ?></td>
						<td align="right"><?php echo ($item["m4"]); ?></td>
						<td align="right"><?php echo ($item["m5"]); ?></td>
						<td align="right"><?php echo ($item["m6"]); ?></td>
						<td align="right"><?php echo ($item["m7"]); ?></td>
						<td align="right"><?php echo ($item["m8"]); ?></td>
						<td align="right"><?php echo ($item["m9"]); ?></td>
						<td align="right"><?php echo ($item["m10"]); ?></td>
						<td align="right"><?php echo ($item["m11"]); ?></td>
						<td align="right"><?php echo ($item["m12"]); ?></td>
						<td align="right"><?php echo ($item["total"]); ?></td>
						<td><img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
					<div align="center" style="margin-top: 10px">
						<input type="submit" name="Submit" value="確認" /> <input type="reset" name="Submit2" value="取消" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>