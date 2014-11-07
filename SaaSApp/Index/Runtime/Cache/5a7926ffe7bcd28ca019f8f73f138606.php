<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/JavaScript">
	var type = "<?php echo ($m["type"]); ?>";
	var category = "<?php echo ($m["category"]); ?>";
	var mprov = "<?php echo ($m["mprov"]); ?>";
	var iprov = "<?php echo ($m["invoiceprov"]); ?>";
	var mcity = "<?php echo ($m["mcity"]); ?>";
	var icity = "<?php echo ($m["invoicecity"]); ?>";
	$(function() {
		$('#mprov').change(function() {
			getCity('#mprov', '#mcity');
		});
		$('#invoiceprov').change(function() {
			getCity('#invoiceprov', '#invoicecity');
		});
		if (type)
			$("#type").val(type);
		if (category)
			$("#category").val(category);
		if (mprov)
			$("#mprov").val(mprov).trigger('change');
		if (iprov)
			$("#invoiceprov").val(iprov).trigger('change');
	});
	function getCity(p, c) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getCity",
			data : "pid=" + $(p).val(),
			success : function(data) {
				$(c).empty();
				$("<option value=''>請選擇</option>").appendTo(c);
				var json = eval(data);
				$.each(json, function(k) {
					$("<option value='" + json[k]['id'] + "'>" + decodeURI(json[k]['name']) + "</option>").appendTo(c);
				});
				if (c == '#mcity' && mcity)
					$("#mcity").val(mcity);
				if (c == '#invoicecity' && icity)
					$("#invoicecity").val(icity);

			}
		});
	}
	function check() {
		return true;
		//return validator.index('day', '請選擇日期');
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


			<div class="topic">廠商管理</div>
			<div class="mainInfo">
				<form action="__URL__/addManufacturers" onsubmit="return check()" method="post" enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name="id" style="width: 400px" value="<?php echo ($m["id"]); ?>" /> <input type="hidden" name="code" style="width: 400px" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" />
					<div class="topic2">新增 / 修改 廠商</div>
					<table width="695" border="0" align="center" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="132" scope="row">廠商類別</th>
							<td width="560"><select name="type" id="type">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th width="132" scope="row">廠商分類</th>
							<td width="560"><select name="category" id="category">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th scope="row">廠商名稱</th>
							<td><input type="text" name="mname" value="<?php echo ($m["mname"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">統一編號</th>
							<td><input type="text" name="ucode" value="<?php echo ($m["ucode"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">廠商編號</th>
							<td><input type="text" name="mcode" value="<?php echo ($m["mcode"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">地址</th>
							<td><select name="mprov" id="mprov">
									<option value="">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="mcity" id="mcity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" name="maddress" value="<?php echo ($m["maddress"]); ?>" style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">聯絡電話</th>
							<td><input type="text" name="mlinkphone" value="<?php echo ($m["mlinkphone"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">傳真</th>
							<td><input type="text" name="mfax" value="<?php echo ($m["mfax"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">聯絡人</th>
							<td>
							1.姓名： <input type="text" name="mlinker1" value="<?php echo ($m["mlinker1"]); ?>" style="width: 100px" /> 電話： <input type="text" name="mlinkerphone1" value="<?php echo ($m["mlinkerphone1"]); ?>" /><br/>分機： <input type="text" name="mlinkerfj1" value="<?php echo ($m["mlinkerfj1"]); ?>" /> Email： <input type="text" name="mlinkeremail1" value="<?php echo ($m["mlinkeremail1"]); ?>" /> <br /> 
							2.姓名： <input type="text" name="mlinker2" value="<?php echo ($m["mlinker2"]); ?>" style="width: 100px" /> 電話： <input type="text" name="mlinkerphone2" value="<?php echo ($m["mlinkerphone2"]); ?>" /> <br/>分機： <input type="text" name="mlinkerfj2" value="<?php echo ($m["mlinkerfj2"]); ?>" />Email： <input type="text" name="mlinkeremail2" value="<?php echo ($m["mlinkeremail2"]); ?>"/> <br />
							3.姓名： <input type="text" name="mlinker3" value="<?php echo ($m["mlinker3"]); ?>" style="width: 100px" /> 電話： <input type="text" name="mlinkerphone3" value="<?php echo ($m["mlinkerphone3"]); ?>" /><br/> 分機： <input type="text" name="mlinkerfj3" value="<?php echo ($m["mlinkerfj3"]); ?>" />Email： <input type="text" name="mlinkeremail3" value="<?php echo ($m["mlinkeremail3"]); ?>" /> <br /> 
						    4.姓名： <input type="text" name="mlinker4" value="<?php echo ($m["mlinker4"]); ?>" style="width: 100px" /> 電話： <input type="text" name="mlinkerphone4" value="<?php echo ($m["mlinkerphone4"]); ?>" /> <br/>分機： <input type="text" name="mlinkerfj4" value="<?php echo ($m["mlinkerfj4"]); ?>" />Email： <input type="text" name="mlinkeremail4" value="<?php echo ($m["mlinkeremail4"]); ?>" /> <br /> 
							5.姓名： <input type="text" name="mlinker5" value="<?php echo ($m["mlinker5"]); ?>" style="width: 100px" /> 電話： <input type="text" name="mlinkerphone5" value="<?php echo ($m["mlinkerphone5"]); ?>" /> <br/>分機： <input type="text" name="mlinkerfj5" value="<?php echo ($m["mlinkerfj5"]); ?>" />Email： <input type="text" name="mlinkeremail5" value="<?php echo ($m["mlinkeremail5"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">發票名稱</th>
							<td><input type="text" name="invoicename" value="<?php echo ($m["invoicename"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">發票地址</th>
							<td><select name="invoiceprov" id="invoiceprov">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="invoicecity" id="invoicecity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" name="invoiceaddress" style="width: 300px" value="<?php echo ($m["invoiceaddress"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">付款銀行</th>
							<td><input type="text" name="paybank" value="<?php echo ($m["paybank"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">所屬分行</th>
							<td><input type="text" name="belongbank" value="<?php echo ($m["belongbank"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">銀行帳號</th>
							<td><input type="text" name="bankcode" value="<?php echo ($m["bankcode"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">備註</th>
							<td><input type="text" name="remark" value="<?php echo ($m["remark"]); ?>" style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td><input type="submit" name="Submit" value="確定" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>