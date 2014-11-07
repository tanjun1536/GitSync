<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
<script type="text/javascript">
	$(function() {
		$("#querydate").val(new Date().format("yyyy/MM/dd hh:mm"));
		$("#tdquerydate").html($("#querydate").val());
		$('#queryerdepart').change(function() {
			getTeam('#queryerdepart', '#queryerteam');
		});
		$('#queryerteam').change(function() {
			getPeople('#queryerteam', '#queryer');
		});
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
				if (!json)
					return;
				$.each(json, function(k) {
					$(
							"<option  value='"+json[k]['id']+"'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo(teams);
				});
			}
		});
	}
	function getPeople(depart, users) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getPeopleByTeam",
			data : "id=" + $(depart).val(),
			success : function(data) {
				$(users).empty();
				$("<option value=''>員工姓名</option>").appendTo(users);
				var json = eval(data);
				$.each(json, function(k) {
					if (json[k]['id'] != $('#user').val())
						$(
								"<option  value='"+json[k]['id']+"'>"
										+ decodeURI(json[k]['name']) + "("
										+ decodeURI(json[k]['ucode'])
										+ ")</option>").appendTo(users);
				});
			}
		});
	}
	var editrow=null;
	function addCP() {
		
	if (editrow == null) {
			var len = $("#tabCP tr").length;
			var lastRow = $("#tabCP tr")[len - 3];
			var row = $("<tr></tr>");
			var hValue = $('#cp').val() + "," + $('#spmc').val() + ","
					+ $('#ggcc').val() + "," + $('#cpxh').val() + ","
					+ $('#sl').val() + "," + $('#dw').val() + ","
					+ $('#dj').val() + "," + $('#fj').val() + ","
					+ $('#bz').val();
			row
					.append($("<input type='hidden' value='" + hValue + "' name ='detail[]' />"))
			row.append($("<td></td>").append($('#cp').val()));
			row.append($("<td></td>").append($('#spmc').val()));
			row.append($("<td></td>").append($('#ggcc').val()));
			row.append($("<td></td>").append($('#cpxh').val()));
			row.append($("<td></td>").append($('#sl').val()));
			row.append($("<td></td>").append($('#dw').val()));
			row.append($("<td></td>").append($('#dj').val()));
			row.append($("<td></td>").append($('#fj').val()));
			row.append($("<td></td>").append($('#bz').val()));
			row
					.append($("<td></td>")
							.append(
									$('<img onclick="editCP($(this).parent().parent());" style="cursor:pointer" src="__PUBLIC__/images/icon_edit.gif" alt="編輯" width="16" height="16" border="0" />'))
							.append(
									$('<img onclick="$(this).parent().parent().remove();cal();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			$(lastRow).after(row);
		
		}	
	else
		{
			
	var tds = editrow.find('td');
			$(tds[0]).html($('#cp').val());
			$(tds[1]).html($('#spmc').val());
			$(tds[2]).html($('#ggcc').val());
			$(tds[3]).html($('#cpxh').val());
			$(tds[4]).html($('#sl').val());
			$(tds[5]).html($('#dw').val());
			$(tds[6]).html($('#dj').val());
			$(tds[7]).html($('#fj').val());
			$(tds[8]).html($('#bz').val());
			editrow = null;
			$("#s").val("新增");
		}
		cal();
		$('#cp').val('');
		$('#spmc').val('');
		$('#ggcc').val('');
		$('#cpxh').val('');
		$('#sl').val('');
		$('#dw').val('');
		$('#dj').val('');
		$('#fj').val('');
		$('#bz').val('');

	}
	function editCP(row) {
		editrow = row;
		var tds = editrow.find('td');
		$('#cp').val($(tds[0]).html());
		$('#spmc').val($(tds[1]).html());
		$('#ggcc').val($(tds[2]).html());
		$('#cpxh').val($(tds[3]).html());
		$('#sl').val($(tds[4]).html());
		$('#dw').val($(tds[5]).html());
		$('#dj').val($(tds[6]).html());
		$('#fj').val($(tds[7]).html());
		$('#bz').val($(tds[8]).html());
		$("#s").val("保存");
	}
	function cal()
	{
	var totalDJ = 0;
		var totalFJ = 0;
		var len = $("#tabCP tr").length;
		$("#tabCP tr").each(function(index) {
			if (index > 0 && index < len - 1) {
				var tdArr = $(this).find("td");
				totalDJ += fn.getFloat($(tdArr[6]).html());
				totalFJ += fn.getFloat($(tdArr[7]).html());
			}

		});

		$("#totaldj").val(totalDJ);
		$("#totalfj").val(totalFJ);
		$("#tdTotalDJ").html(totalDJ);
		$("#tdTotalFJ").html(totalFJ);
	}
	function check() {
		return validator.empty('name', '請輸入公司名稱');
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
		<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<div class="sideLeft">
	<div>
		<a href="__APP__/User/profile"> <img src="__PUBLIC__/<?php if(empty($_SESSION['SESSION_USER']['userimage'])) echo 'images/3_03.jpg';  else echo 'Uploads/'.$_SESSION['SESSION_USER']['userimage']; ?>" alt="" width="151" border="0" />
		</a>
	</div>
	<div class="name">
		<a href="__APP__/User/Profile"><?php echo $_SESSION['SESSION_USER']['name'] ?></a>
	</div>
	<div id="date">
		<script>
			WdatePicker({
				eCont : "date",
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


			<div class="topic">詢價管理 - 廠商詢價管理</div>
			<div class="mainInfo">
				<form id="form1" name="form1" method="post" action="__URL__/PriceBusinessSave">
					<input type="hidden" name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" /> 
					<input type="hidden" name="type" value="廠商詢價" />
					<input type="hidden" name="querydate" id="querydate" /> 
					<input type="hidden" name="querycode" id="querycode" value="<?php echo ($linecode); ?>" /> 
					<input type="hidden" name="state" value="未處理" />
					<input type="hidden" name="totaldj" id="totaldj" />
					<input type="hidden" name="totalfj" id="totalfj" />
					<div class="topic2">新增／修改詢價單</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="116" scope="row">日期</th>
							<td width="228" id="tdquerydate">系統抓取</td>
							<th width="100" scope="row">編號</th>
							<td width="246" id="tdquerycode"><?php echo ($linecode); ?></td>
						</tr>
						<tr>
							<th scope="row">詢價人</th>
							<td colspan="3" id="tdqueryer"><select id="queryerdepart" name="queryerdepart">
									<option value="">選擇部門</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="queryerteam" id="queryerteam">
									<option value="">選擇組別</option>
							</select><select id="queryer" name="queryer">
									<option value="員工姓名">員工姓名</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">申請類別</th>
							<td colspan="3"><select name="reqtype">
									<option value="">請選擇</option>
									<option value="照明">照明</option>
									<option value="電料">電料</option>
									<option value="水料">水料</option>
									<option value="消防">消防</option>
									<option value="空調">空調</option>
									<option value="泵浦">泵浦</option>
									<option value="馬達">馬達</option>
									<option value="五金">五金</option>
									<option value="弱電">弱電</option>
									<option value="3C">3C</option>
									<option value="儀器">儀器</option>
									<option value="其他">其他</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">狀態</th>
							<td colspan="3">未處理</td>
						</tr>
						<tr>
							<th scope="row">採購說明</th>
							<td colspan="3"><input type="text" name="purchaseremark" style="width: 400px" /></td>
						</tr>
						<tr>
							<th scope="row">備註說明</th>
							<td colspan="3"><input type="text" name="remark" style="width: 400px" /></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th colspan="4" scope="col">新增商品</th>
						</tr>
						<tr>
							<td width="74" class="tdcolor2">廠牌</td>
							<td width="270"><input type="text" name="cp" id="cp" /></td>
							<td width="74" class="tdcolor2">商品名稱</td>
							<td width="272"><input type="text" name="spmc" id="spmc" /></td>
						</tr>
						<tr>
							<td class="tdcolor2">規格尺寸</td>
							<td><input type="text" name="ggcc" id="ggcc" /></td>
							<td class="tdcolor2">產品型號</td>
							<td><input type="text" name="cpxh" id="cpxh" /></td>
						</tr>
						<tr>
							<td class="tdcolor2">數量</td>
							<td><input type="text" name="sl" id="sl" /></td>
							<td class="tdcolor2">單位</td>
							<td><input type="text" name="dw" id="dw" /></td>
						</tr>
						<tr>
							<td class="tdcolor2">單價</td>
							<td><input type="text" name="dj" id="dj" /></td>
							<td class="tdcolor2">複價</td>
							<td><input type="text" name="fj" id="fj" /></td>
						</tr>
						<tr>
							<td class="tdcolor2">備註</td>
							<td colspan="3"><input type="text" name="bz" style="width: 400px" id="bz" /></td>
						</tr>
						<tr>
							<td class="tdcolor2">&nbsp;</td>
							<td colspan="3"><input type="button" onclick="addCP()" value="新增" id="s"/></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide" id="tabCP">
						<tr>
							<th width="89" scope="col"><span class="tdcolor2">廠牌</span></th>
							<th width="128" scope="col"><span class="tdcolor2">商品名稱</span></th>
							<th width="77" scope="col"><span class="tdcolor2">規格尺寸</span></th>
							<th width="79" scope="col"><span class="tdcolor2">產品型號</span></th>
							<th width="44" scope="col"><span class="tdcolor2">數量</span></th>
							<th width="48" scope="col"><span class="tdcolor2">單位</span></th>
							<th width="49" scope="col"><span class="tdcolor2">單價</span></th>
							<th width="43" scope="col"><span class="tdcolor2">複價</span></th>
							<th width="74" scope="col"><span class="tdcolor2">備註</span></th>
							<th width="53" scope="col">操作</th>
						</tr>
						<tr>
							<td colspan="6" align="right" class="tdcolor1">總計</td>
							<td align="center" id="tdTotalDJ">&nbsp;</td>
							<td align="center" id="tdTotalFJ">&nbsp;</td>
							<td colspan="2" class="tdcolor3">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="10" align="center"><input type="submit" name="Submit2" value="確定送出" /> <input
								type="reset" name="Submit3" value="取消" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>