<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.format.1.03.js"></script>
<script type="text/JavaScript">
	$(function(){
// 		$("#productcode").live("blur", function() {
// 			getProduct();
// 		});
		$(".int").format({
			precision : 0,
			allow_negative : false,
			autofix : true
		});
	});
	function getProduct() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getProductStorage",
			data : "code=" + $("#productcode").val()+"&stockcode=<?php echo ($stock["stockcode"]); ?>",
			success : function(data) {
				var json = eval(data);
				if (json) {
					$("#productcode").val(json.productcode)
					$("#name").html(json.productname);
					$("#price").html(json.productprice);
					$("#storage").html(json.storage);
				} else {
					alert('商品編號輸入有錯誤！');
					$("#productcode").trigger('focus');
				}
			}

		});

	}
	function addInventory() {
		if (validator.empty('productcode', '請輸入商品編號!') && validator.empty('factquantity', '請輸入數量!')) {
			var table=$("#detail");
			var len = $("#detail tr").length;
			var row = len % 2 == 0 ? $("<tr class=\"trcolor\"></tr>") : $("<tr></tr>");
			var hValue = $('#productcode').val() + "," + $('#name').html() + "," + $('#price').html() + "," + $('#storage').html() + "," + $('#factquantity').val();
			row.append($("<td align=\"center\"></td>").append($('#productcode').val()).append($("<input type='hidden' value='" + hValue + "' name ='detail[]' />")));
			row.append($("<td></td>").append($('#name').html()));
			row.append($("<td align=\"center\"></td>").append($('#price').html()));
			row.append($("<td align=\"center\"></td>").append($('#storage').html()));
			row.append($("<td align=\"center\"></td>").append($('#factquantity').val()));
			row.append($("<td align=\"center\"></td>").append($('<img onclick="$(this).parent().parent().remove();calTotal();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#productcode').val('');
			$('#factquantity').val('');
			$('#name').html('');
			$('#price').html('');
			$('#storage').html('');

		}

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


			<div class="topic">進銷存管理 - 庫存管理</div>
			<div class="mainInfo">
				<div class="topic2">
					<a href="__URL__/stockView?id=<?php echo ($stock["id"]); ?>"><?php echo ($stock["stockname"]); ?></a> - 新增盤點紀錄
				</div>
				<form action="__URL__/stockInventoryDetailSave?id=<?php echo $_GET["id"];?>&stockid=<?php echo $_GET["stockid"];?>" method="post"
					enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name="continue" id="continue" value="1"/>
					<input type="hidden" name="stockid" value="<?php echo $_GET["stockid"];?>"/>
					<input type="hidden" name="inventoryid" value="<?php echo $_GET["id"];?>"/>
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide">
						<tr>
							<th width="123" scope="row">盤點開始日期</th>
							<td width="221"><?php echo (formatDate($inventory["startdate"])); ?></td>
							<th width="124" scope="row">倉庫關閉時間</th>
							<td width="222"><?php echo ($inventory["stockclosehour"]); ?>:<?php echo ($inventory["stockcloseminute"]); ?></td>
						</tr>
					</table>
					<div class="mailNav">
						匯入盤點紀錄 <input type="file" name="file" /> <input type="submit"
							name="Submit" value="匯入" />
					</div>
					<table width="695" border="0" cellpadding="0" cellspacing="0"
						class="tab_thtop" id="detail">
						<tr>
							<th width="141" scope="col">商品編號</th>
							<th width="306" scope="col">商品名稱</th>
							<th width="65" scope="col">單價</th>
							<th width="83" scope="col">預估數量</th>
							<th width="78" scope="col">實際數量</th>
							<th width="20" scope="col">&nbsp;</th>
						</tr>
						<tr>
							<td align="center"><input type="text" name="productcode" id="productcode"
								style="width: 80px" /><input type="button" value="搜尋" onclick="getProduct()"></td>
							<td id="name">&nbsp;</td>
							<td align="center" id="price">&nbsp;</td>
							<td align="center" id="storage">&nbsp;</td>
							<td align="center"><input type="text" name="factquantity" id="factquantity" class="int"
								style="width: 30px" /></td>
							<td align="center"><img
									src="__PUBLIC__/images/add_16.png" style="cursor: pointer;" onclick="addInventory()" alt="加入" width="16" height="16"
									border="0" /></td>
						</tr>
					</table>
					<div style="margin-top: 10px">
						<p>
							<input type="submit" name="Submit2" value="確定送出，且繼續新增紀錄" /> <input
								type="submit" name="Submit22" onclick="$('#continue').val(0)" value="確定送出，並結束盤點" />
						</p>
					</div>
				</form>
				<div>
					<strong>註:</strong> <br />
					確定結束盤點後，將不可再針對此次盤點紀錄做「修改」或「新增」的操作功能，並同時「開啟倉庫」
				</div>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>