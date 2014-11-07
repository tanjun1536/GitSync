<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
<script type="text/JavaScript">
	$(function() {
		$("#outdate").val(new Date().format("yyyy/MM/dd"));
		$("#outhour").val(new Date().getHours());
		$("#outminute").val(new Date().getMinutes());
		// 		$("#productcode").live("blur", function() {
		// 			getProduct();
		// 		});
		$("#quantity").live(
				"keyup",
				function() {
					$("#subtotal").html(
							$("#quantity").val() * $("#productprice").val());
				});
		
		
	});
	function getProduct() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getProduct",
			data : "code=" + $("#productcode").val(),
			success : function(data) {
				var json = eval(data);
				if (json) {

					$("#productname").html(json.productname);
					$("#productprice").val(json.productprice);
					$("#productunit").val(json.productunit);
					$("#productmodel").val(json.productmodel);
					$("#productsize").val(json.productsize);
					$("#productcp").val(json.productcp);
					$("#productcd").val(json.productcd);
				} else {
					alert('商品編號輸入有錯誤！');
					$("#productcode").trigger('focus');
				}
			}

		});

	}
	function addProduct() {
		if (validator.empty('productcode', '請輸入商品編號!')
				&& validator.empty('quantity', '請輸入數量!')) {
			var table = $("#purchasedetail");
			var len = $("#purchasedetail tr").length;

			var lastRow = $("#purchasedetail tr")[len - 2];
			var row = len % 2 == 1 ? $("<tr class=\"trcolor\"></tr>")
					: $("<tr></tr>");
			var hValue = $('#productcode').val() + ","
					+ $('#productname').html() + "," + $('#productprice').val()
					+ "," + $('#quantity').val() + "," + $('#subtotal').html()
					+ "," + $('#productremark').val()+ ","
					+ $('#productunit').val()+ "," 
					+ $('#productmodel').val()+ ","
					+ $('#productsize').val()+ "," 
					+ $('#productcp').val()+ "," 
					+ $('#productcd').val();
			row
					.append($("<td align=\"center\"></td>")
							.append($('#productcode').val())
							.append(
									$("<input type='hidden' value='" + hValue + "' name ='detail[]' />")));
			row.append($("<td></td>").append($('#productname').html()));
			row.append($("<td align=\"center\"></td>").append(
					$('#productprice').val()));
			row.append($("<td align=\"center\"></td>").append(
					$('#quantity').val()));
			row.append($("<td align=\"center\"></td>").append(
					$('#subtotal').html()));
			row.append($("<td align=\"center\"></td>").append(
					$('#productremark').val()));
			row
					.append($("<td align=\"center\"></td>")
							.append(
									$('<img onclick="$(this).parent().parent().remove();calTotal();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			$(lastRow).after(row);
			$('#productcode').val('');
			$('#quantity').val('');
			$('#subtotal').html('');
			$('#productname').html('');
			$('#productprice').val('');
			$('#productremark').val('');
			$('#productunit').val();
			 $('#productmodel').val();
			$('#productsize').val(); 
			$('#productcp').val(); 
			 $('#productcd').val();
			calTotal();

		}

	}
	function calTotal() {
		var total = 0;
		$("#purchasedetail tr").each(function(i) {
			var td = $(this).find("td")[4];
			if (td)
				if ($(td).html() != '')
					total += parseFloat($(td).html());
		});
		total=fn.getFloat(total);
		$("#total").html(total);
		$("#totalmoney").val(total);
	}
	function getStock() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getStock",
			data : "code=" + $("#outwarehousecode").val(),
			success : function(data) {
				if (data != null && data != '') {
					$("#outwarehousename").val(data);
					$("#tdoutwarehousename").html(data);
				} else {
					alert('倉庫代碼輸入錯誤!');
					$("#outwarehousecode").val('');
				}
			}

		});

	}
	function check() {

		if (validator.empty('outwarehousecode', '請輸入倉庫代號')
				&& validator.index('outtype', '請選擇出庫性質')) {
			if($("#tdoutwarehousename").html()=='')
			{
			alert('請填寫倉庫名稱!');
			return false;
			}
			if ($("#totalmoney").val() == '0') {
				alert('請填寫出庫明細!');
				return false;
			}
			if($("#objid").val()=="查詢結果")
				{
					alert('請选择对象!');
					return false;
				}
				
			return true;
		}
		return false;
	}
	
	function getObjs()
	{
		var objname=$("#objname").val();
		var objtype=$("#objtype").val();
		$.post("__URL__/getObjs",{objtype:objtype,objname:objname},function(data){
				$("#objid").empty().append('<option value="查詢結果">查詢結果</option>');
				data=eval(data);
				if(data)
				{
					$.each(data,function(i){
						$("#objid").append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
						
					});
				}
			
		});
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


			<div class="topic">進銷存管理 - 異動管理</div>
			<div class="mainInfo">
				<div class="topic2">新增出庫單</div>
				<form id="form1" name="form1" method="post" onsubmit="return check()" action="__URL__/addStockOut">
					<input type="hidden" name="totalmoney" id="totalmoney" value="<?php echo ($total); ?>" />
					 <input type="hidden" name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" /> 
					 <input type="hidden" name="outuser" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>" /> 
					 <input type="hidden" name="outdate" id="outdate" />
					  <input type="hidden" name="outwarehousename" id="outwarehousename" /> 
					  <input type="hidden" name="type" value="出庫" /> 
					  <input type="hidden" name="state" value="新進單" /> 
					  <input type="hidden" name="outtypename" id="outtypename" />
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="91" scope="row">倉庫代號</th>
							<td width="242"><input type="text" name="outwarehousecode" id="outwarehousecode" /> <input type="button" name="Submit3" value="確定" onclick="getStock()" /></td>
							<th width="91" scope="row">倉庫名稱</th>
							<td width="266" id="tdoutwarehousename"></td>
						</tr>
						<tr>
							<th scope="row">出庫性質</th>
							<td><select name="outtype" id="outtype" onchange="$('#outtypename').val(this.options[this.selectedIndex].text)">>
									<option value="請選擇">請選擇</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
							<th scope="row">出庫時間</th>
							<td><select name="outhour" id="outhour">
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
							</select> 時 <input type="text" name="outminute" id="outminute" style="width: 20PX" /> 分</td>
						</tr>
						<tr>
							<th scope="row">出貨單號</th>
							<td><input type="text" name="outcode" id="outcode" value="<?php echo ($outcode); ?>" readonly="readonly" /></td>
							<th scope="row">發票號碼</th>
							<td><input type="text" name="billcode" id="billcode" /></td>
						</tr>
						<tr>
							<th scope="row">對象</th>
							<td colspan="3"><select name="objtype" id="objtype">
									<option value="客戶">客戶</option>
									<option value="廠商">廠商</option>
							</select> <input type="text" name="objname" id="objname" value="<?php echo ($orderuser); ?>" /> <input type="button" onclick="getObjs()" value="查詢" /> 
							<select name="objid" id="objid">
									<option value="查詢結果">查詢結果</option>
							</select><br></br>
                  			訂單編號：<input type="text" name="ordercode" value="<?php echo ($ordercode); ?>" />
							</td>
						</tr>
								<tr>
							<th scope="row">發票類型</th>
							<td colspan="3"><select name="billtype" id="billtype">
									<option value="二聯">二聯</option>
									<option value="三聯">三聯</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">付款方式</th>
							<td colspan="3"><select name="paymethod" id="paymethod">
									<option value="匯款" selected="selected">匯款</option>
									<option value="現金">現金</option>
									<option value="月結">月結</option>
									<option value="信用卡">信用卡</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">送貨方式</th>
							<td colspan="3"><select name="delivermethod" id="delivermethod">
									<option value="配送">配送</option>
									<option value="郵寄">郵寄</option>
									<option value="自取">自取</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row"  >備註</th>
							<td colspan="3"><textarea rows="5" style="width: 100%" name="remark"></textarea> </td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop" id="purchasedetail">
						<tr>
							<th width="133" scope="col">商品編號</th>
							<th width="176" scope="col">商品名稱</th>
							<th width="59" scope="col">單價</th>
							<th width="75" scope="col">數量</th>
							<th width="78" scope="col">小計</th>
							<th width="148" scope="col">備註</th>
							<th width="24" scope="col">&nbsp;</th>
						</tr>
						<tr>
							
							<td align="center"><input type="hidden" id="productunit" />
							<input type="hidden" id="productmodel" />
							<input type="hidden" id="productsize" />
							<input type="hidden" id="productcp" />
							<input type="hidden" id="productcd" /><input type="text" name="productcode" id="productcode" style="width: 80px" /> <input type="button" value="搜尋" onclick="getProduct()" /></td>
							<td id="productname">&nbsp;</td>
							<td align="center"><input type="text" name="productprice" id="productprice" style="width: 80px" /></td>
							<td align="center"><input type="text" id="quantity" style="width: 50px" /></td>
							<td align="center" id="subtotal">&nbsp;</td>
							<td><input type="text" name="productremark" id="productremark" style="width: 140px" /></td>
							<td align="center"><img onclick="addProduct()" src="__PUBLIC__/images/add_16.png" style="cursor: pointer" alt="新增" width="16" height="16" /></td>
						</tr>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
							<?php else: ?>
						<tr class="trcolor"><?php endif; ?>
						<td align="center"><?php echo ($item["productcode"]); ?><input type="hidden" value="<?php echo ($item["productcode"]); ?>,<?php echo ($item["productname"]); ?>,<?php echo ($item["productprice"]); ?>,<?php echo ($item["quantity"]); ?>,<?php echo ($item["subtotal"]); ?>,<?php echo ($item["remark"]); ?>" name="detail[]" /></td>
						<td id="productname"><?php echo ($item["productname"]); ?></td>
						<td align="center"><?php echo ($item["productprice"]); ?></td>
						<td align="center"><?php echo ($item["quantity"]); ?></td>
						<td align="center"><?php echo ($item["subtotal"]); ?></td>
						<td align="center"><?php echo ($item["remark"]); ?></td>
						<td align="center"><img onclick="$(this).parent().parent().remove();calTotal();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<tr class="trcolor3">
							<td colspan="4" align="right"><strong>總計入庫金額：</strong></td>
							<td align="center" id="total"><?php echo ($total); ?></td>
							<td>元</td>
							<td align="center">&nbsp;</td>
						</tr>
						 <tr class="trcolor3">
					        <td colspan="3" align="right" bgcolor="#FFFFEC">&nbsp;</td>
					        <td colspan="4" bgcolor="#FFFFEC" ><input type="radio" name="taketoaccount" checked="checked" value="1" />
					拋轉會計系統<input type="radio" name="taketoaccount" value="0" />
					不必拋轉會計系統</td>
					        <td align="center" bgcolor="#FFFFEC">&nbsp;</td>
					      </tr>
					</table>
					<div align="center" style="margin-top: 10px">
						<input type="submit" name="Submit" value="確定新增" /> <input type="reset" name="Submit2" value="取消" />
					</div>
				</form>
				<form id="form3" name="form3" method="post" action="__URL__/ImportStockOut" enctype="multipart/form-data">
					<div class="mailNav">
						匯入出庫單 <input type="file" name="file" /> <input type="button" name="Submit" onclick="$('#form3').submit()" value="匯入" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>