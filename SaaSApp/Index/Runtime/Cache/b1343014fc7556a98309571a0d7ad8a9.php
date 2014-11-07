<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/Concurrent.Thread-full-20090713.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	var clientcity = null;
	var billcity = null;
	$(function() {
		$('#billprov').change(function() {
			getCity('#billprov', '#billcity');
		});
		$('#clientprov').change(function() {
			getCity('#clientprov', '#clientcity');
		});
		$('#deliverprov').change(function() {
			getCity('#deliverprov', '#delivercity');
		});

		$('#billcity').change(function() {
			billcity = $(this).val();
		});
		$('#clientcity').change(function() {
			clientcity = $(this).val();
		});
	});
	function getCity(province, city) {
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
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo(city);
				});
				if (city == '#clientcity') {
					if(billcity)
						{
							$("#clientcity").val(billcity).trigger('change');
							billcity=null;
						}
				} else {
					if(clientcity)
					{
						$("#delivercity").val(clientcity);
						clientcity=null;
					}
				}
			}
		});
	}
	function copyclient() {

		$('#clientprov').val($('#billprov').val()).trigger('change');
		$('#clientcity').val($('#billcity').val());
		$('#clientaddress').val($('#billaddress').val());
	}
	function copydeliver() {
		$('#deliverprov').val($('#clientprov').val()).trigger('change');
		$('#delivercity').val($('#clientprov').val());
		$('#deliveraddress').val($('#clientaddress').val());
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


			<div class="topic">客戶管理</div>
			<div class="mainInfo">
				<form action="__URL__/saveCustomer" method="post"
					enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" />
					<div class="topic2">新增 / 修改客戶</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide">
						<tr>
							<th scope="row">客戶編號</th>
							<td><input type="text" name="clientcode" /></td>
						</tr>
						<tr>
							<th width="131" scope="row">公司抬頭</th>
							<td width="561"><input type="text" name="clienttitle"
								style="width: 300px" /></td>
						</tr>
						<tr>
							<th width="161" scope="row">客戶名稱</th>
							<td width="531"><input type="text" name="companyname"
								style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">行業類別</th>
							<td><select name="hytype">
									<?php if(is_array($ctlist)): $i = 0; $__LIST__ = $ctlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th scope="row">會員等級</th>
							<td><input name="membergrade" type="radio" value="A"
								checked="checked" /> A <input name="membergrade" type="radio"
								value="B" /> B <input name="membergrade" type="radio" value="C" />
								C <input name="membergrade" type="radio" value="D" /> D <input
								name="membergrade" type="radio" value="E" /> E</td>
						</tr>
						<tr>
							<th scope="row">統一編號</th>
							<td><input type="text" name="uniquecode" /></td>
						</tr>
						<tr>
							<th scope="row">公司電話</th>
							<td>電話一 <input type="text" name="phone1" /> ；電話二 <input
								type="text" name="phone2" /></td>
						</tr>
						<tr>
							<th scope="row">傳真</th>
							<td><input type="text" name="fax" /></td>
						</tr>
						<tr>
							<th scope="row">發票地址</th>
							<td><select name="billprov" id="billprov">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="billcity" id="billcity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" id="billaddress" name="billaddress" style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">發票方式</th>
							<td><input name="billtype" type="radio" value="二聯"
								checked="checked" /> 二聯 <input name="billtype" type="radio"
								value="三聯" /> 三聯</td>
						</tr>
						<tr>
							<th scope="row">客戶地址</th>
							<td><select name="clientprov" id="clientprov">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="clientcity" id="clientcity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" id="clientaddress" name="clientaddress" style="width: 300px" />
								<input type="button" value="同上" onclick="copyclient()" /></td>
						</tr>
						<tr>
							<th scope="row">送貨地址</th>
							<td><select name="deliverprov" id="deliverprov">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="delivercity" id="delivercity">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" id="deliveraddress" name="deliveraddress" style="width: 300px" />
								<input type="button" value="同上" onclick="copydeliver()" /></td>
						</tr>
						<tr>
							<th scope="row">送貨案場</th>
							<td><input type="text" name="delivercase" /></td>
						</tr>
						<tr>
							<th scope="row">聯絡人一</th>
							<td>姓名 <input type="text" name="linkername1" /> ；職位 <input
								type="text" name="linkerduty1" /> <br /> 電話 <input type="text"
								name="linkerphone1" /> ；手機 <input type="text"
								name="linkermobile1" /> <br /> Email <input type="text"
								name="linkeremail1" />；部門 <input type="text" name="unit1" /></td>
						</tr>
						<tr>
							<th scope="row"><p>聯絡人二</p></th>
							<td>姓名 <input type="text" name="linkername2" /> ；職位 <input
								type="text" name="linkerduty2" /> <br /> 電話 <input type="text"
								name="linkerphone2" /> ；手機 <input type="text"
								name="linkermobile2" /> <br /> Email <input type="text"
								name="linkeremail2" />；部門 <input type="text" name="unit2" /></td>
						</tr>
						<tr>
							<th scope="row">付款銀行</th>
							<td><input type="text" name="paybank" /></td>
						</tr>
						<tr>
							<th scope="row">所屬分行</th>
							<td><input type="text" name="belongbank" /></td>
						</tr>
						<tr>
							<th scope="row">銀行帳號</th>
							<td><input type="text" name="bankcode" /></td>
						</tr>
						<tr>
							<th scope="row">付款方式</th>
							<td><input name="paymanner" type="radio" value="匯款"
								checked="checked" /> 匯款 <input name="paymanner" type="radio"
								value="貨到付款" /> 貨到付款 <input name="paymanner" type="radio"
								value="月結" /> 月結</td>
						</tr>
						<tr>
							<th scope="row">單據方式</th>
							<td><input name="billmanner" type="radio" value="隨貨附發票 "
								checked="checked" /> 隨貨附發票 <input name="billmanner"
								type="radio" value="KEY單月結" /> KEY單月結</td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td><input type="submit" name="Submit" value="確定" /> <input
								type="reset" name="Submit2" value="取消" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>