<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.format.1.03.js"></script>
<script type="text/JavaScript">
	$(function() {
		$(".int").format({
			precision : 0,
			allow_negative : false,
			autofix : true
		});
		$('#undertakerdept').change(function() {
			getTeam('#undertakerdept', '#undertakerteam');
		});
		$('#undertakerteam').change(function() {
			getPeople('#undertakerteam', '#undertaker');
		});
		$('#clientprovince').change(function() {
			getCity('#clientprovince', '#clientcity');
		});
		$('#projectprovince').change(function() {
			getCity('#projectprovince', '#projectcity');
		});
		$('#undertaker').change(function() {
			$("#undertakername").val($(this).find("option:selected").text());
			$("#tdundertakerphone").html($(this).find("option:selected").attr("phone"));
			$("#tdundertakeremail").html($(this).find("option:selected").attr("email"));
			$("#undertakerphone").val($(this).find("option:selected").attr("phone"));
			$("#undertakeremail").val($(this).find("option:selected").attr("email"));
		});
		$(".estimate").bind("keyup",function(){
			var total=0;
			$(".estimate").each(function(k){
				total+=fn.getFloat($(this).val());
			});
			$("#estimatetotalcost").val(total);
			$("#tdestimatetotalcost").html(total);
		});
		$(".fact").bind("keyup",function(){
			var total=0;
			$(".fact").each(function(k){
				total+=fn.getFloat($(this).val());
			});
			$("#facttotalcost").val(total);
			$("#tdfacttotalcost").html(total);
		});
		
		$("#product").change(function(){
// 			$("#price").html($(this).find("option:selected").attr("price"));
// 			$("#unit").html($(this).find("option:selected").attr("unit"));
		});
		$("#amount").bind("keyup",function(){
			$("#sum").html(fn.getFloat($(this).val())*fn.getFloat($("#price").html()));
		});
		$("#strikeprice").bind("keyup",function(){
			var grossprofit=fn.getFloat($("#strikeprice").val())-fn.getFloat($("#estimatetotalcost").val());
			var grossprofitrate=grossprofit/fn.getFloat($("#estimatetotalcost").val());
			$("#tdestimategrossprofit").html(grossprofit);
			$("#estimategrossprofit").val(grossprofit);
			$("#tdestimategrossprofitrate").html(grossprofitrate);
			$("#estimategrossprofitrate").val(grossprofitrate);
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
				if(!json)return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name'])  + "</option>").appendTo(teams);
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
						$("<option phone='"+json[k]['phone']+"' email='"+json[k]['email']+"' value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "(" + decodeURI(json[k]['ucode']) + ")</option>").appendTo(users);
				});
			}
		});
	}
	function getCity(province,city) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getCity",
			data : "pid=" + $(province).val(),
			success : function(data) {
				$(city).empty();
				$("<option value='請選擇'>請選擇</option>").appendTo(city);
				var json = eval(data);
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['name']) + "</option>").appendTo(city);
				});
			}
		});
	}
	
	function query(value)
	{
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/queryProduct",
			data : "name=" + value,
			success : function(data) {
				$("#product").empty();
				$("<option value='請選擇'>請選擇</option>").appendTo("#product");
				var json = eval(data);
				$.each(json, function(k) {
					$("<option unit='"+json[k]['productunit']+"' price='"+json[k]['productprice']+"' value='" + json[k]['id'] + "'>" + decodeURI(json[k]['productname']) + "</option>").appendTo("#product");
				});
			}
		});
	}
	function addDetail()
	{
		if (validator.empty('amount', '請輸入数量!')  && validator.empty('product', '請輸入商品!') ) {
			var table = $('#detail');
			var len = $("#detail tr").length;
			var row = len % 2 == 1 ? $("<tr class=\"trcolor\"></tr>") : $("<tr></tr>");
			var hValue = $('#product').val() + "," + $('#amount').val() + "," + $('#unit').val() + "," + $('#price').val()+ "," + $('#sum').val()+ "," + $('#remark').val();
			row.append($("<td></td>").append($('#product').val()).append($("<input type='hidden' value='" + hValue + "' name ='details[]' />")));
			row.append($("<td align=\"center\"></td>").append($('#amount').val()));
			row.append($("<td align=\"center\"></td>").append($('#unit').val()));
			row.append($("<td align=\"center\"></td>").append($('#price').val()));
			row.append($("<td align=\"center\"></td>").append($('#sum').val()));
			row.append($("<td align=\"center\"></td>").append($('#remark').val()));
			row.append($("<td align=\"center\"></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#product').val('');
			$('#sum').val('');
			$('#amount').val('');
			$('#remark').val('');
			$('#unit').val('');
			$('#price').val('');
		}

	}
	function clc()
	{
		var tds;
		var t=0
		$("#detail tr").each(function(){
			tds=$(this).find("td");
			t+=fn.getFloat($(tds[4]).html());
		});
		var tax=t*0.05;
		var tp=t+t*0.05;
		$("#total").val(t);
		$("#taxprice").val(tax);
		$("#totalprice").val(tp);
		$("#stotal").html(t);
		$("#stotalfax").html(tax);
		$("#stotalprice").html(tp);
				
		
	}
	function check() {
		return validator.empty('day', '請選擇日期') && validator.empty('minutes', '請輸入分鐘') && validator.index('hosterdepart', '請選擇會議主持部門') && validator.index('hoster', '請選擇會議主持') && validator.index('recorderdepart', '請選擇會議記錄人部門') && validator.index('recorder', '請選擇會議記錄人') && validator.index('starterdepart', '請選擇會議發起人部門') && validator.index('starter', '請選擇會議發起人')
				&& validator.empty('partersname', '請輸入與會人員') && validator.empty('topic', '請輸入會議主題');
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
				<form id="form1" name="form1" method="post"
					action="__URL__/PriceSave">
					<input type="hidden" name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" />
					<input type="hidden" name="state" value="未送簽" />
					<div class="topic2">新增 / 修改工程報價單</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide">

						<tr>
							<th scope="row">報價單號</th>
							<td><input type="text" name="pricecode" value="<?php echo ($linecode); ?>"/></td>
							<th scope="row">報價日期</th>
							<td><input type="text" name="pricedate" class="Wdate" onfocus="WdatePicker()"/></td>
						</tr>
						<tr>
							<th width="128" scope="row">分項</th>
							<td width="216"><input type="text" name="pricesubitem" /></td>
							<th width="122" scope="row">BU單位</th>
							<td width="224"><input type="hidden" name="BUunitName" id="BUunitName" />
							
								<select name="BUunit" onchange="$('#BUunitName').val($(this).find('option:selected').text())">
									<option value="請選擇" selected="selected">請選擇</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th scope="row">製表人</th>
							<td colspan="3"><input type="hidden" name="tabulator" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>"/><?php echo $_SESSION["SESSION_USER"]["name"];?></td>
						</tr>
						<tr>
							<th scope="row">承辦人</th>
							<td colspan="3"><select name="undertakerdept" id="undertakerdept">
									<option value="選擇部門">選擇部門</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="undertakerteam" id="undertakerteam">
									<option value="選擇組別">選擇組別</option>
							</select> <select name="undertaker" id="undertaker">
									<option value="選擇人員">選擇人員</option>
							</select>
							<input type="hidden" name="undertakername" id="undertakername" />
							</td>
						</tr>
						<tr>
							<th scope="row">承辦人電話</th>
							<td id="tdundertakerphone">自動抓取<input type="hidden" name="undertakerphone" /></td>
							
							<th scope="row">承辦人EMAIL</th>
							<td id="tdundertakeremail">自動抓取<input type="hidden" name="undertakeremail" /></td>
						</tr>
						<tr>
							<th scope="row">案場名稱</th>
							<td><input type="text" name="casename" /></td>
							<th scope="row">工程名稱</th>
							<td><input type="text" name="projectname" /></td>
						</tr>
						<tr>
							<th scope="row">客戶名稱</th>
							<td><input type="text" name="clientname" /></td>
							<th scope="row">聯絡人</th>
							<td><input type="text" name="linker" /></td>
						</tr>
						<tr>
							<th scope="row">客戶地址</th>
							<td colspan="3"><select name="clientprovince" id="clientprovince">
									<option value="請選擇">請選擇</option>provinces
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="clientcity" id="clientcity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" name="clientaddress" style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">客戶統編</th>
							<td><input type="text" name="clientcode" /></td>
							<th scope="row">客戶電話</th>
							<td><input type="text" name="clientphone" /></td>
						</tr>
						<tr>
							<th scope="row">客戶傳真</th>
							<td colspan="3"><input type="text" name="clientfax" /></td>
						</tr>
						<tr>
							<th scope="row">送貨(工程地點)</th>
							<td colspan="3"><select name="projectprovince" id="projectprovince">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="projectcity" id="projectcity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" name="projectaddress" style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">預估施工方式</th>
							<td colspan="3"><input name="estimateconstructionmethods" type="radio"
								value="自行施工" /> 自行施工 <input name="estimateconstructionmethods"
								type="radio" value="招商委外" /> 招商委外</td>
						</tr>
						<tr>
							<th scope="row">預估委外方式</th>
							<td colspan="3"><input name="estimatedelegatemethods" type="radio"
								value="限制性招標 " /> 限制性招標 <input name="estimatedelegatemethods"
								type="radio" value="選擇性招標" /> 選擇性招標 <input
								name="estimatedelegatemethods" type="radio" value="公開招標" /> 公開招標</td>
						</tr>
						<tr>
							<th scope="row">預估工資成本</th>
							<td><input class="estimate" type="text" name="estimatesalarycost" /></td>
							<th scope="row">預估材料成本</th>
							<td><input class="estimate" type="text" name="estimatemeterialcost" /></td>
						</tr>
						<tr>
							<th scope="row">預估發包成本</th>
							<td><input class="estimate" type="text" name="estimatefbcost" /></td>
							<th scope="row">預估其他成本</th>
							<td><input class="estimate" type="text" name="estimateothercost" /></td>
						</tr>
						<tr>
							<th scope="row">預估總成本</th>
							<input type="hidden" id="estimatetotalcost" name="estimatetotalcost" />
							<td id="tdestimatetotalcost">上述四個成本相加</td>
							<th scope="row">成交價</th>
							<td><input name="strikeprice" type="text" id="strikeprice" /></td>
						</tr>
						<tr>
							<th scope="row">預估毛利</th>
							<input type="hidden" id="estimategrossprofit" name="estimategrossprofit" />
							<td id="tdestimategrossprofit">成交價-總成本</td>
							<th scope="row" id="tdestimategrossprofit">預估毛利率</th>
							<input type="hidden" id="estimategrossprofitrate" name="estimategrossprofitrate" />
							<td id="tdestimategrossprofitrate">毛利/總成本</td>
						</tr>
						<tr>
							<th scope="row">實際施工方式</th>
							<td colspan="3"><input name="factconstructionmethods" type="radio"
								value="自行施工" /> 自行施工 <input name="factconstructionmethods"
								type="radio" value="招商委外" /> 招商委外</td>
						</tr>
						<tr>
							<th scope="row">實際委外方式</th>
							<td colspan="3"><input name="factdelegatemethods" type="radio"
								value="限制性招標" /> 限制性招標 <input name="factdelegatemethods"
								type="radio" value="選擇性招標" /> 選擇性招標 <input
								name="factdelegatemethods" type="radio" value="公開招標" /> 公開招標</td>
						</tr>
						<tr>
							<th scope="row">實際委外廠商</th>
							<td><input type="text" name="factdelegatecompany" /></td>
							<th scope="row">實際工資成本</th>
							<td><input class="fact" type="text" name="factsalarycost" /></td>
						</tr>
						<tr>
							<th scope="row">實際材料成本</th>
							<td><input class="fact" type="text" name="factmeterialcost" /></td>
							<th scope="row">實際其他成本</th>
							<td><input class="fact" type="text" name="factothercost" /></td>
						</tr>
						<tr>
							<th scope="row">實際總成本</th>
							<input type="hidden" id="facttotalcost" name="facttotalcost" />
							<td id="tdfacttotalcost">上述三個成本相加</td>
							<th scope="row">實際成交價</th>
							<td><input type="text" name="factstrikeprice" /></td>
						</tr>
						<tr>
							<th scope="row">實際毛利</th>
							<td><input type="text" name="factgrossprofit" /></td>
							<th scope="row">實際毛利率</th>
							<td><input type="text" name="factgrossprofitrate" /></td>
						</tr>
						<tr>
							<th scope="row">備註說明</th>
							<td colspan="3"><textarea name="projectremark" rows="4"
									style="width: 530px"></textarea></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide" id="detail">
						<tr>
							<th width="323" scope="col">品名/項目</th>
							<th width="46" scope="col">數量</th>
							<th width="55" scope="col">單位</th>
							<th width="52" scope="col">單價</th>
							<th width="62" scope="col">複價</th>
							<th width="82" scope="col">備註/規格</th>
							<th width="32" scope="col">&nbsp;</th>
						</tr>
						<tr>
							<td><div>
									<input type="text" id="product" />
<!-- 									 <input type="button" -->
<!-- 										onclick="query($(this).prev().val())" value="搜尋" /> -->
								</div>
<!-- 								<div> -->
<!-- 									<select name="product" style="width: 300px" id="product"> -->
<!-- 										<option value="顯示商品名稱">顯示商品名稱</option> -->
<!-- 									</select> -->
<!-- 								</div> -->
								
								</td>
							<td align="center"><input id="amount" type="text" class="int"
								size="3" /></td>
							<td align="center" ><input type="text" id="unit" /></td>
							<td align="center" ><input type="text" id="price" /></td>
							<td align="center" ><input type="text" id="sum" /></td>
							<td align="center"><input id="remark" type="text"
								size="10" /></td>
							<td align="center"><a href="javascript:void(0)" onclick="addDetail()"><img
									src="__PUBLIC__/images/add_16.png" alt="增加" width="16" height="16"
									border="0" /></a></td>
						</tr>
					</table>
					<div>
						<input type="button" name="Submit2" value="計算" onclick="clc()"/>
					</div>
					<div>
					<input type="hidden" id="total" name="total" />
					<input type="hidden" id="taxprice" name="taxprice" />
					<input type="hidden" id="totalprice" name="totalprice" />
						<p>
							合計：<span id="stotal"></span><br /> 稅金(5%)：<span id="stotalfax"></span><br /> 總價：<span id="stotalprice"></span><br /> 備註：<br />
							<textarea name="priceremark" rows="4" style="width: 690px"></textarea>
						</p>
					</div>
					<div align="center">
						<input type="submit" name="Submit3" value="確定送出" /> <input
							type="reset" name="Submit4" value="取消" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>