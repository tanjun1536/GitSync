<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/date.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.format.1.03.js"></script>
<script type="text/JavaScript">
	$(function() {
		$("#manufacturertype").change(function() {
			getManufacturers();
		});
		$("#productcode").live("blur", function() {
			getProduct();
		});
		$("#quantity").live("keyup", function() {
			$("#subtotal").html($("#quantity").val() * $("#productprice").html());
		});
		$(".int").format({
			precision : 0,
			allow_negative : false,
			autofix : true
		});
		$("#purchasedate").val(new Date().format("yyyy/MM/dd hh:mm"));
	});

	function getManufacturers() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getManufacturers",
			data : "type=" + $("#manufacturertype").val(),
			success : function(data) {
				$("#manufacturer").empty();
				$("<option value=''>選擇公司</option>").appendTo("#manufacturer");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['mname']) + "</option>").appendTo("#manufacturer");
				});
			}

		});

	}
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
					$("#productprice").html(json.productprice);
				} else {
					alert('商品編號輸入有錯誤！');
					$("#productcode").trigger('focus');
				}
			}

		});

	}
	function addProduct() {
		if (validator.empty('productcode', '請輸入商品編號!') && validator.empty('quantity', '請輸入數量!')) {
			var table = $("#purchasedetail");
			var len=$("#purchasedetail tr").length;
			
			var lastRow = $("#purchasedetail tr")[len - 2];
			var row = len%2==1?$("<tr class=\"trcolor\"></tr>"):$("<tr></tr>");
			var hValue = $('#productcode').val() + "," + $('#productname').html() + "," + $('#productprice').html()+ "," + $('#quantity').val()+ "," + $('#subtotal').html();
			row.append($("<td align=\"center\"></td>").append($('#productcode').val()).append($("<input type='hidden' value='" + hValue + "' name ='detail[]' />")));
			row.append($("<td></td>").append($('#productname').html()));
			row.append($("<td align=\"center\"></td>").append($('#productprice').html()));
			row.append($("<td align=\"center\"></td>").append($('#quantity').val()));
			row.append($("<td align=\"center\"></td>").append($('#subtotal').html()));
			row.append($("<td align=\"center\"></td>").append($('<img onclick="$(this).parent().parent().remove();calTotal();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			$(lastRow).after(row);
			$('#productcode').val('');
			$('#quantity').val('');
			$('#subtotal').html('');
			$('#productname').html('');
			$('#productprice').html('');
			calTotal();
			
		}

	}
	function calTotal()
	{
		var total=0;
		$("#purchasedetail tr").each(function(i){
			var td=$(this).find("td")[4];
			if(td)
				if($(td).html()!='')
					total+=parseFloat($(td).html());
		});
 		$("#total").html(total);
 		$("#totalmoney").val(total);
	}
	function check() {
		if($("#totalmoney").val()=='0')
			{
				alert('請填寫採購明細!');
				return false;
			}
		return validator.empty('purchasecode', '請輸入採購編號') && validator.index('manufacturertype', '請選擇類別') && validator.index('manufacturer', '請選擇公司');
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


			<div class="topic">進銷存管理 - 採購管理</div>
			<div class="mainInfo">
				<form id="form2" onsubmit="return check()" name="form2" method="post" action="__URL__/addPurchase">
					<div class="topic2">新增採購單</div>
					<input type="hidden" name="purchasedate" id="purchasedate" />
					<input type="hidden" name="purchasestate" value="新進單" />
					<input type="hidden" name="totalmoney" id="totalmoney" value="0"/>
					<input type="hidden" name="code" style="width: 400px" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" />
					<input type="hidden" name="purchaseuser" style="width: 400px" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>" />
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="88" scope="row">採購編號</th>
							<td><input type="text" name="purchasecode" id="purchasecode" value="<?php echo ($linecode); ?>" readonly="readonly"/></td>
						</tr>
						<tr>
							<th scope="row">採購對象</th>
							<td><select name="manufacturertype" id="manufacturertype">
									<option value="">選擇類別</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="manufacturer" id="manufacturer">
									<option value="">選擇公司</option>
							</select></td>
						</tr>
					</table>
					<table width="695" border="0" cellpadding="0" cellspacing="0" class="tab_thtop" id="purchasedetail">
						<tr>
							<th width="162" scope="col">商品編號</th>
							<th width="274" scope="col">商品名稱</th>
							<th width="84" scope="col">單價</th>
							<th width="71" scope="col">數量</th>
							<th width="78" scope="col">小計</th>
							<th width="24" scope="col">&nbsp;</th>
						</tr>
						<tr>
							<td align="center"><input type="text" id="productcode" name="productcode" style="width: 150px" /></td>
							<td id="productname">&nbsp;</td>
							<td align="center" id="productprice">&nbsp;</td>
							<td align="center"><input type="text" name="quantity" class="int" id="quantity" style="width: 50px" /></td>
							<td align="center" id="subtotal">&nbsp;</td>
							<td align="center"><img onclick="addProduct()" src="__PUBLIC__/images/add_16.png" style="cursor:pointer" alt="新增" width="16" height="16" /></td>
						</tr>
<!-- 						<tr class="trcolor3"> -->
<!-- 							<td colspan="4" align="center">&nbsp;</td> -->
<!-- 							<td align="center"><span style="margin-top: 10px"><strong> <input type="button" name="Submit3" value="金額總計" /> -->
<!-- 								</strong></span></td> -->
<!-- 							<td align="center">&nbsp;</td> -->
<!-- 						</tr> -->
						<tr class="trcolor3">
							<td colspan="4" align="right"><strong>總計金額：</strong></td>
							<td align="center" id="total">0</td>
							<td align="center">元</td>
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