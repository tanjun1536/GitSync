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
	$(function() {
		//選擇城市
		getCity();
		//選擇組別
		getTeam();
		//選擇生日
		
		$('#province').change(function() {
			getCity()
		});
		$('#depart').change(function() {
			getTeam()
		});
		//檢查用戶名是否重複
		$("#username").live("blur", function() {
			checkUser();
		});
		$("#birthyear").val(<?php echo ($user["birthyear"]); ?>);
		$("#birthmonth").val(<?php echo ($user["birthmonth"]); ?>);
		$("#birthday").val(<?php echo ($user["birthday"]); ?>);
		$("#bloodtype").attr('value','<?php echo ($user["bloodtype"]); ?>');
		$("#role").val(<?php echo ($user["role"]); ?>);
		$("input[name='isonduty'][value='<?php echo ($user["isonduty"]); ?>']").attr("checked",true);
	});
	function getCity() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getCity",
			data : "pid=" + $('#province').val(),
			success : function(data) {
				$("#city").empty();
				$("<option value='請選擇'>請選擇</option>").appendTo("#city");
				var json = eval(data);
				$.each(json, function(k) {
					if(json[k]['id']==<?php echo ($user["city"]); ?>)
					$("<option selected='selected' value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#city");
					else
					$("<option value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#city");
				});
			}
		});
	}
	function getTeam() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getTeam",
			data : "pid=" + $('#depart').val(),
			success : function(data) {
				$("#team").empty();
				$("<option value='請選擇組別'>請選擇組別</option>").appendTo("#team");
				$("<option value='不分組別'>不分組別</option>").appendTo("#team");
				var json = eval(data);
				$.each(json, function(k) {
					if(json[k]['id']==<?php echo ($user["team"]); ?>)
						$("<option selected='selected' value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#team");
					else
						$("<option value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#team");
				});
			}
		});
	}
	function checkUser() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/checkUser",
			data : "username=" + $('#username').val(),
			success : function(data) {
				if (data != 1) {
					alert('用戶名已經存在！');
					$('#username').val('');

				}
			}
		});
	}
	function addExperience() {
		if (validator.empty('jzgs', '請輸入就職公司!') && validator.empty('zw', '請輸入職位!') && validator.empty('rzqs', '請選擇任職起始!') && validator.empty('rzjs', '請選擇任職結束!') && validator.empty('xz', '請輸入薪資!')) {
			var table = $('#experience');
			var row = $("<tr></tr>");
			var hValue = $('#jzgs').val() + "," + $('#zw').val() + "," + $('#rzqs').val() + "," + $('#rzjs').val() + "," + $('#xz').val();
			row.append($("<td></td>").append($('#jzgs').val()).append($("<input type='hidden' value='"+hValue+"' name ='experience[]' />")));
			row.append($("<td></td>").append($('#zw').val()));
			row.append($("<td></td>").append($('#rzqs').val()));
			row.append($("<td></td>").append($('#rzjs').val()));
			row.append($("<td></td>").append($('#xz').val()));
			row.append($("<td></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#jzgs').val('');
			$('#zw').val('');
			$('#rzqs').val('');
			$('#rzjs').val('');
			$('#xz').val('');
		}

	}
	function addEducation() {
		if (validator.empty('jdxx', '請輸入就讀學校!') && validator.empty('kx', '請輸入科系!') && validator.empty('xl', '請輸入學歷!') && validator.empty('qssj', '請選擇起始時間!') && validator.empty('bysj', '請選擇畢業時間!')) {
			var table = $('#education');
			var row = $("<tr></tr>");
			var hValue = $('#jdxx').val() + "," + $('#kx').val() + "," + $('#xl').val() + "," + $('#qssj').val() + "," + $('#bysj').val() + "," + $('#zt').val();
			row.append($("<td></td>").append($('#jdxx').val()).append($("<input type='hidden' value='"+hValue+"' name ='education[]' />")));
			row.append($("<td></td>").append($('#kx').val()));
			row.append($("<td></td>").append($('#xl').val()));
			row.append($("<td></td>").append($('#qssj').val()));
			row.append($("<td></td>").append($('#bysj').val()));
			row.append($("<td></td>").append($('#zt').val()));
			row.append($("<td></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#jdxx').val('');
			$('#kx').val('');
			$('#xl').val('');
			$('#qssj').val('');
			$('#bysj').val('');
		}

	}
	function addCertificate() {
		Concurrent.Thread.create(function() {
			if (validator.empty('zzmc', '請輸入證照名稱!') && validator.empty('qdsj', '請選擇取得時間!')) {
				var complete = false;
				var atts = '';
				//先用ajax上传文件
				$.ajaxFileUpload({
					url : '__URL__/doAjaxFileUpload',
					secureuri : false,
					fileElementId : 'atts',
					dataType : 'text',
					async : false,
					success : function(data) {
						complete = true;
						atts = data;
					},
					error : function(data, status, e) {
						onerror(e);
					}

				});
				while (complete == false) {
					Concurrent.Thread.sleep(1000);
				}

				var table = $('#certificate');
				var row = $("<tr></tr>");
				var hValue = $('#zzmc').val() + "," + $('#qdsj').val() + "," + $('#sdate').val() + "," + $('#edate').val() + "," + atts + "," + $('#bz').val();
				row.append($("<td></td>").append($('#zzmc').val()).append($("<input type='hidden' value='" + hValue + "' name ='certificate[]' />")));
				row.append($("<td></td>").append($('#qdsj').val()));
				row.append($("<td></td>").append("起：" + $('#sdate').val() + "<br />迄：" + $('#edate').val()));
				row.append($("<td></td>").append("<a href='__URL__/down?name="+atts+"'>下載</a>"));
				row.append($("<td></td>").append($('#bz').val()));
				row.append($("<td></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
				table.append(row);
				$('#zzmc').val('');
				$('#qdsj').val('');
				$('#sdate').val('');
				$('#edate').val('');
				$('#bz').val('');
				$("#atts").after($("#atts").clone(true).val(""));
				$("#atts").remove();
			}
		});

	}
	function addSkill() {
		if (validator.empty('zcmc', '請輸入專長名稱!')) {
			var table = $('#skill');
			var row = $("<tr></tr>");
			var hValue = $('#zcmc').val() + "," + $('#dj').val() + "," + $('#zcbz').val();
			row.append($("<td></td>").append($('#zcmc').val()).append($("<input type='hidden' value='"+hValue+"' name ='skill[]' />")));
			row.append($("<td></td>").append($('#dj').val()));
			row.append($("<td></td>").append($('#zcbz').val()));
			row.append($("<td></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#zcmc').val('');
			$('#dj').val('');
			$('#zcbz').val('');
		}

	}
	function addFamily() {
		if (validator.empty('xm', '請輸入姓名!') && validator.empty('zy', '請輸入職業!') && validator.index('nc', '請選擇年次!') && validator.empty('gx', '請輸入關係!')) {
			var table = $('#family');
			var row = $("<tr></tr>");
			var hValue = $('#xm').val() + "," + $('#zy').val() + "," + $('#nc').val() + "," + $('#gx').val();
			row.append($("<td></td>").append($('#xm').val()).append($("<input type='hidden' value='"+hValue+"' name ='family[]' />")));
			row.append($("<td></td>").append($('#zy').val()));
			row.append($("<td></td>").append($('#nc').val()));
			row.append($("<td></td>").append($('#gx').val()));
			row.append($("<td></td>").append($('<img onclick="$(this).parent().parent().remove();" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />')));
			table.append(row);
			$('#xm').val('');
			$('#zy').val('');
			$('#gx').val('');
		}

	}
	function check()
	{
		if($('#password').val()==$('#passwordsure').val())
		{
			return validator.empty('ucode','請輸入員工編號')&&
			validator.empty('password','請輸入密碼')&&
			validator.empty('passwordsure','請輸入確認密碼');
		}
		else
		{
			alert("兩次輸入的密碼不一致!");
			return false;
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


			<div class="topic">員工管理 - 新增/ 修改員工</div>
			<div class="mainInfo">
				<!-- 			Profile.php -->
				<form action="__URL__/update" onsubmit="return check()" method="post" enctype="multipart/form-data" name="form1" id="form1">
					<input name="url" value="<?php echo ($url); ?>" />
					<table width="695" border="0" align="center" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th scope="row">員工編號</th>
							<input type="hidden" name="id" value="<?php echo ($user["id"]); ?>" />
							<td><?php echo ($user["ucode"]); ?><input type="hidden" name="ucode" value="<?php echo ($user["ucode"]); ?>" />
							</td>
						</tr>
						<tr>
							<th scope="row">帳號</th>
							<td><input type="text" name="username" id="username" value="<?php echo ($user["username"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">密碼</th>
							<td><input type="password" name="password" id="password" /></td>
						</tr>
						<tr>
							<th scope="row">確認密碼</th>
							<td><input type="password" name="passwordsure" id="passwordsure" /></td>
						</tr>
						<tr>
							<th scope="row">個人相片</th>
							<td><input type="file" name="userImage" /> 
							<input type="hidden" value="<?php echo ($user["userimage"]); ?>" name="userimage" />
							<input type="checkbox" name="delImage" value="1" /> 刪除相片</td>
						</tr>
						<tr>
							<th width="100" scope="row">姓名</th>
							<td width="592"><input type="text" name="name" value="<?php echo ($user["name"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">籍貫</th>
							<td><input type="text" name="origin" value="<?php echo ($user["origin"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">目前住址</th>
							<td><select name="province" id="province">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(($user["province"])  ==  $item["id"]): ?><option value="<?php echo ($item["id"]); ?>" selected="selected"><?php echo ($item["name"]); ?></option>
									<?php else: ?>
									<option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="city" id="city">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" name="address" style="width: 300px" /></td>
						</tr>
						<tr>
							<th scope="row">身份證字號</th>
							<td><input type="text" name="card" value="<?php echo ($user["card"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">性別</th>
							<td><?php if($user["sex"] == '男'): ?><input name="sex" checked="checked" type="radio" value="男" /> 男 <input name="sex" type="radio" value="女" /> 女<?php else: ?> <input name="sex" type="radio" value="男" /> 男 <input name="sex" checked="checked" type="radio" value="女" /> 女<?php endif; ?></td>
						</tr>
						<tr>
							<th scope="row">生日</th>
							<td><select name="birthyear" id="birthyear">
									<option value=""></option>
									<option value='1997'>西元1997 / 民國86</option>
									<option value='1996'>西元1996 / 民國85</option>
									<option value='1995'>西元1995 / 民國84</option>
									<option value='1994'>西元1994 / 民國83</option>
									<option value='1993'>西元1993 / 民國82</option>
									<option value='1992'>西元1992 / 民國81</option>
									<option value='1991'>西元1991 / 民國80</option>
									<option value='1990'>西元1990 / 民國79</option>
									<option value='1989'>西元1989 / 民國78</option>
									<option value='1988'>西元1988 / 民國77</option>
									<option value='1987'>西元1987 / 民國76</option>
									<option value='1986'>西元1986 / 民國75</option>
									<option value='1985'>西元1985 / 民國74</option>
									<option value='1984'>西元1984 / 民國73</option>
									<option value='1983'>西元1983 / 民國72</option>
									<option value='1982'>西元1982 / 民國71</option>
									<option value='1981'>西元1981 / 民國70</option>
									<option value='1980'>西元1980 / 民國69</option>
									<option value='1979'>西元1979 / 民國68</option>
									<option value='1978'>西元1978 / 民國67</option>
									<option value='1977'>西元1977 / 民國66</option>
									<option value='1976'>西元1976 / 民國65</option>
									<option value='1975'>西元1975 / 民國64</option>
									<option value='1974'>西元1974 / 民國63</option>
									<option value='1973'>西元1973 / 民國62</option>
									<option value='1972'>西元1972 / 民國61</option>
									<option value='1971'>西元1971 / 民國60</option>
									<option value='1970'>西元1970 / 民國59</option>
									<option value='1969'>西元1969 / 民國58</option>
									<option value='1968'>西元1968 / 民國57</option>
									<option value='1967'>西元1967 / 民國56</option>
									<option value='1966'>西元1966 / 民國55</option>
									<option value='1965'>西元1965 / 民國54</option>
									<option value='1964'>西元1964 / 民國53</option>
									<option value='1963'>西元1963 / 民國52</option>
									<option value='1962'>西元1962 / 民國51</option>
									<option value='1961'>西元1961 / 民國50</option>
									<option value='1960'>西元1960 / 民國49</option>
									<option value='1959'>西元1959 / 民國48</option>
									<option value='1958'>西元1958 / 民國47</option>
									<option value='1957'>西元1957 / 民國46</option>
									<option value='1956'>西元1956 / 民國45</option>
									<option value='1955'>西元1955 / 民國44</option>
									<option value='1954'>西元1954 / 民國43</option>
									<option value='1953'>西元1953 / 民國42</option>
									<option value='1952'>西元1952 / 民國41</option>
									<option value='1951'>西元1951 / 民國40</option>
									<option value='1950'>西元1950 / 民國39</option>
									<option value='1949'>西元1949 / 民國38</option>
									<option value='1948'>西元1948 / 民國37</option>
									<option value='1947'>西元1947 / 民國36</option>
									<option value='1946'>西元1946 / 民國35</option>
									<option value='1945'>西元1945 / 民國34</option>
									<option value='1944'>西元1944 / 民國33</option>
									<option value='1943'>西元1943 / 民國32</option>
									<option value='1942'>西元1942 / 民國31</option>
									<option value='1941'>西元1941 / 民國30</option>
									<option value='1940'>西元1940 / 民國29</option>
									<option value='1939'>西元1939 / 民國28</option>
									<option value='1938'>西元1938 / 民國27</option>
									<option value='1937'>西元1937 / 民國26</option>
									<option value='1936'>西元1936 / 民國25</option>
									<option value='1935'>西元1935 / 民國24</option>
									<option value='1934'>西元1934 / 民國23</option>
									<option value='1933'>西元1933 / 民國22</option>
									<option value='1932'>西元1932 / 民國21</option>
									<option value='1931'>西元1931 / 民國20</option>
									<option value='1930'>西元1930 / 民國19</option>
									<option value='1929'>西元1929 / 民國18</option>
									<option value='1928'>西元1928 / 民國17</option>
									<option value='1927'>西元1927 / 民國16</option>
									<option value='1926'>西元1926 / 民國15</option>
									<option value='1925'>西元1925 / 民國14</option>
									<option value='1924'>西元1924 / 民國13</option>
									<option value='1923'>西元1923 / 民國12</option>
									<option value='1922'>西元1922 / 民國11</option>
									<option value='1921'>西元1921 / 民國10</option>
							</select> 年 <select name="birthmonth" id="birthmonth">
									<option value=""></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
							</select> 月 <select name="birthday" id="birthday">
									<option value=""></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
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
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
							</select> 日</td>
						</tr>
						<tr>
							<th scope="row">血型</th>
							<td><select name="bloodtype" id="bloodtype">
									<option value="請選擇">請選擇</option>
									<option value="A型">A型</option>
									<option value="B型">B型</option>
									<option value="O型">O型</option>
									<option value="AB型">AB型</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">聯絡電話</th>
							<td><input type="text" name="phone" value="<?php echo ($user["phone"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">行動電話</th>
							<td><input type="text" name="mobile" value="<?php echo ($user["mobile"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">EMAIL</th>
							<td><input type="text" name="email" value="<?php echo ($user["email"]); ?>" style="width: 200px" /></td>
						</tr>
						<tr>
							<th scope="row">任職日期</th>
							<td><input type="text" class="Wdate" onFocus="WdatePicker()" value="<?php echo (formatDate($user["onduty"])); ?>" name="onduty" /></td>
						</tr>
						<tr>
							<th scope="row">部門/組別</th>
							<td><select name="depart" id="depart">
									<option value="請選擇部門">請選擇部門</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(($user["depart"])  ==  $item["id"]): ?><option selected="selected" value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option>
									<?php else: ?>
									<option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="team" id="team">
									<option value="請選擇組別">請選擇組別</option>
									<option value="不分組別">不分組別</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">級別</th>
							<td>
								<ul class="level">
									<?php if(is_array($levels)): $i = 0; $__LIST__ = $levels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(in_array(($item["id"]), is_array($user["level"])?$user["level"]:explode(',',$user["level"]))): ?><li><input type="checkbox" checked="checked" name="level[]" value="<?php echo ($item["id"]); ?>" /><?php echo ($item["lcode"]); ?></li>
									<?php else: ?>
									<li><input type="checkbox" name="level[]" value="<?php echo ($item["id"]); ?>" /> <?php echo ($item["lcode"]); ?></li><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</td>
						</tr>
						<tr>
							<th scope="row">權限</th>
							<td><select name="role" id="role">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($roles)): $i = 0; $__LIST__ = $roles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th scope="row">離職</th>
							<td><input name="isonduty" type="radio" value="1" checked="checked" /> 在職 <input name="isonduty" type="radio" value="0" /> 離職</td>
						</tr>
						<tr>
							<th scope="row">離職日期</th>
							<td><input type="text" class="Wdate" onFocus="WdatePicker()" value="<?php echo (formatDate($user["offduty"])); ?>" name="offduty" /></td>
						</tr>
					<tr>
							<th scope="row">備註</th>
							<td><textarea name="remark" rows="5" style="width:550px"></textarea></td>
						</tr>
						<tr>
							<th scope="row">經歷</th>
							<td><table width="580" border="0" cellpadding="0" cellspacing="0" id="experience">
									<tr>
										<th width="182" height="44" scope="col">就職公司</th>
										<th width="118" scope="col">職位</th>
										<th width="86" scope="col">任職起始</th>
										<th width="86" scope="col">任職結束</th>
										<th width="80" scope="col">薪資</th>
										<th width="28" scope="col">&nbsp;</th>
									</tr>
									<tr>
										<td><input type="text" id="jzgs" name="jzgs" style="width: 160px" /></td>
										<td><input type="text" id="zw" name="zw" style="width: 100px" /></td>
										<td><input type="text" id="rzqs" onFocus="WdatePicker()" name="rzqs" style="width: 70px" /></td>
										<td><input type="text" id="rzjs" onFocus="WdatePicker()" name="rzjs" style="width: 70px" /></td>
										<td><input type="text" id="xz" name="xz" style="width: 60px" /></td>
										<td><img onclick="addExperience()" src="__PUBLIC__/images/add_16.png" style="cursor: pointer" alt="新增" width="16" height="16" border="0" /></td>
									</tr>
									<?php if(is_array($user["experiences"])): $i = 0; $__LIST__ = $user["experiences"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$exp): ++$i;$mod = ($i % 2 )?><tr>
										<td><?php echo ($exp["companyname"]); ?><input type="hidden" value="<?php echo ($exp["companyname"]); ?>,<?php echo ($exp["duty"]); ?>,<?php echo ($exp["sdate"]); ?>,<?php echo ($exp["edate"]); ?>,<?php echo ($exp["salary"]); ?>" name="experience[]"></input></td>
										<td><?php echo ($exp["duty"]); ?></td>
										<td><?php echo ($exp["sdate"]); ?></td>
										<td><?php echo ($exp["edate"]); ?></td>
										<td><?php echo ($exp["salary"]); ?></td>
										<td><img onclick="$(this).parent().parent().remove();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</table></td>
						</tr>
						<tr>
							<th scope="row">學歷</th>
							<td><table width="580" border="0" cellpadding="0" cellspacing="0" id="education">
									<tr>
										<th width="147" scope="col">就讀學校</th>
										<th width="116" scope="col">科系</th>
										<th width="43" scope="col">學歷</th>
										<th width="85" scope="col">起始時間</th>
										<th width="85" scope="col">畢業時間</th>
										<th width="76" scope="col">狀態</th>
										<th width="28" scope="col">&nbsp;</th>
									</tr>
									<tr>
										<td><input type="text" id="jdxx" name="jdxx" style="width: 130px" /></td>
										<td><input type="text" id="kx" name="kx" style="width: 100px" /></td>
										<td><input type="text" id="xl" name="xl" style="width: 30px" /></td>
										<td><input type="text" id="qssj" onFocus="WdatePicker()" name="qssj" style="width: 70px" /></td>
										<td><input type="text" id="bysj" onFocus="WdatePicker()" name="bysj" style="width: 70px" /></td>
										<td><select name="zt" id="zt">
												<option value="畢業">畢業</option>
												<option value="肄業">肄業</option>
										</select></td>
										<td><img onclick="addEducation();" style="cursor: pointer" src="__PUBLIC__/images/add_16.png" alt="新增" width="16" height="16" border="0" /></td>
									</tr>
									<?php if(is_array($user["educations"])): $i = 0; $__LIST__ = $user["educations"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$edu): ++$i;$mod = ($i % 2 )?><tr>
										<td><?php echo ($edu["school"]); ?> <input type="hidden" value="<?php echo ($edu["school"]); ?>,<?php echo ($edu["specialty"]); ?>,<?php echo ($edu["educational"]); ?>,<?php echo ($edu["sdate"]); ?>,<?php echo ($edu["edate"]); ?>,<?php echo ($edu["status"]); ?>" name="education[]"></input></td>
										<td><?php echo ($edu["specialty"]); ?></td>
										<td><?php echo ($edu["educational"]); ?></td>
										<td><?php echo ($edu["sdate"]); ?></td>
										<td><?php echo ($edu["edate"]); ?></td>
										<td><?php echo ($edu["status"]); ?></td>
										<td><img onclick="$(this).parent().parent().remove();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</table></td>
						</tr>
						<tr>
							<th scope="row">證照</th>
							<td><div style="margin-bottom: 10px">
									證照名稱：<input type="text" id="zzmc" name="zzmc" style="width: 220px" /> <br /> 取得時間： <input type="text" id="qdsj" class="Wdate" onFocus="WdatePicker()" name="qdsj" style="width: 120px" /> <br /> 有效期限：起 <input type="text" id="sdate" class="Wdate" onFocus="WdatePicker()" name="sdate" style="width: 120px" /> 迄 <input type="text" id="edate" class="Wdate" onFocus="WdatePicker()" name="edate" style="width: 120px" /> <br /> 附件： <input type="file" name="atts[]" id="atts" /> <br /> 備註： <input type="text" id="bz" name="bz" style="width: 350px" /> <img onclick="addCertificate();" src="__PUBLIC__/images/add_16.png" style="cursor: pointer" alt="新增" width="16" height="16" border="0" />
								</div>
								<table width="580" border="0" cellpadding="0" cellspacing="0" id="certificate">
									<tr>
										<th width="196" scope="col">證照名稱</th>
										<th width="84" scope="col">取得時間</th>
										<th width="120" scope="col">有效期限</th>
										<th width="43" scope="col">附件</th>
										<th width="105" scope="col">備註</th>
										<th width="32" scope="col">&nbsp;</th>
									</tr>
									<?php if(is_array($user["certificates"])): $i = 0; $__LIST__ = $user["certificates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cer): ++$i;$mod = ($i % 2 )?><tr>
										<td><?php echo ($cer["name"]); ?> <input type="hidden" value="<?php echo ($cer["name"]); ?>,<?php echo (date('Y-m-d',strtotime($cer["date"]))); ?>,<?php echo ($cer["remark"]); ?>" name="certificate[]"></input></td>
										<td><?php echo (date('Y-m-d',strtotime($cer["date"]))); ?></td>
										<td>起：<?php echo (date('Y.m.d',strtotime($cer["sdate"]))); ?><br /> 迄：<?php echo (date('Y.m.d',strtotime($cer["edate"]))); ?>
										</td>
										</td>
										<td><a href="__URL__/down?name=<?php echo (urlencode($cer["atts"])); ?>">下載</a></td>
										<td><?php echo ($cer["remark"]); ?></td>
										<td><img onclick="$(this).parent().parent().remove();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</table></td>
						</tr>
						<!-- 						<tr> -->
						<!-- 							<th scope="row">證照</th> -->
						<!-- 							<td><table width="580" border="0" cellpadding="0" cellspacing="0" id="certificate"> -->
						<!-- 									<tr> -->
						<!-- 										<th width="242" scope="col">證照名稱</th> -->
						<!-- 										<th width="85" scope="col">取得時間</th> -->
						<!-- 										<th width="225" scope="col">備註</th> -->
						<!-- 										<th width="28" scope="col">&nbsp;</th> -->
						<!-- 									</tr> -->
						<!-- 									<tr> -->
						<!-- 										<td><input type="text" id="zzmc" name="zzmc" style="width: 220px" /></td> -->
						<!-- 										<td><input type="text" id="qdsj" onFocus="WdatePicker()" name="qdsj" style="width: 70px" /></td> -->
						<!-- 										<td><input type="text" id="bz" name="bz" style="width: 200px" /></td> -->
						<!-- 										<td><img onclick="addCertificate();" src="__PUBLIC__/images/add_16.png" style="cursor: pointer" alt="新增" width="16" height="16" border="0" /></td> -->
						<!-- 									</tr> -->
						<!-- 									<?php if(is_array($user["certificates"])): $i = 0; $__LIST__ = $user["certificates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cer): ++$i;$mod = ($i % 2 )?>-->
						<!-- 									<tr> -->
						<!-- 										<td><?php echo ($cer["name"]); ?> <input type="hidden" value="<?php echo ($cer["name"]); ?>,<?php echo (date('Y-m-d',strtotime($cer["date"]))); ?>,<?php echo ($cer["remark"]); ?>" name="certificate[]"></input></td> -->
						<!-- 										<td><?php echo (date('Y-m-d',strtotime($cer["date"]))); ?></td> -->
						<!-- 										<td><?php echo ($cer["remark"]); ?></td> -->
						<!-- 										<td><img onclick="$(this).parent().parent().remove();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td> -->
						<!-- 									</tr> -->
						<!--<?php endforeach; endif; else: echo "" ;endif; ?> -->
						<!-- 								</table></td> -->
						<!-- 						</tr> -->
						<tr>
							<th scope="row">專長</th>
							<td><table width="580" border="0" cellpadding="0" cellspacing="0" id="skill">
									<tr>
										<th width="248" scope="col">專長名稱</th>
										<th width="74" scope="col">等級</th>
										<th width="230" scope="col">備註</th>
										<th width="28" scope="col">&nbsp;</th>
									</tr>
									<tr>
										<td><input type="text" id="zcmc" name="zcmc" style="width: 220px" /></td>
										<td><select name="dj" id="dj">
												<option value="略通">略通</option>
												<option value="熟練">熟練</option>
												<option value="精通">精通</option>
										</select></td>
										<td><input type="text" name="zcbz" id="zcbz" style="width: 200px" /></td>
										<td><img onclick="addSkill();" style="cursor: pointer" src="__PUBLIC__/images/add_16.png" alt="新增" width="16" height="16" border="0" /></td>
									</tr>
									<?php if(is_array($user["skills"])): $i = 0; $__LIST__ = $user["skills"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$skill): ++$i;$mod = ($i % 2 )?><tr>
										<td><?php echo ($skill["name"]); ?> <input type="hidden" value="<?php echo ($skill["name"]); ?>,<?php echo ($skill["grade"]); ?>,<?php echo ($skill["remark"]); ?>" name="skill[]"></input></td>
										<td><?php echo ($skill["grade"]); ?></td>
										<td><?php echo ($skill["remark"]); ?></td>
										<td><img onclick="$(this).parent().parent().remove();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</table></td>
						</tr>
						<tr>
							<th scope="row">兵役</th>
							<td><?php switch($user["army"]): ?><?php case "役畢":  ?><input name="army" checked="checked" type="radio" value="役畢" /> 役畢 <input name="army" type="radio" value="未服役" /> 未服役 <input name="army" type="radio" value="免役" /><?php break;?> <?php case "未服役":  ?><input name="army" type="radio" value="役畢" /> 役畢 <input name="army" checked="checked" type="radio" value="未服役" /> 未服役 <input name="army" type="radio" value="免役" /><?php break;?> <?php case "免役":  ?><input name="army" type="radio" value="役畢" /> 役畢 <input name="army" type="radio" value="未服役" /> 未服役 <input checked="checked" name="army" type="radio" value="免役" /><?php break;?><?php endswitch;?> 免役， 說明： <input type="text" name="armyremark" value="<?php echo ($user["armyremark"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">家庭狀況</th>
							<td><table width="580" border="0" cellpadding="0" cellspacing="0" id="family">
									<tr>
										<th width="155" scope="col">姓名</th>
										<th width="155" scope="col">職業</th>
										<th width="150" scope="col">年次</th>
										<th width="92" scope="col">關係</th>
										<th width="28" scope="col">&nbsp;</th>
									</tr>
									<tr>
										<td><input type="text" name="xm" id="xm" style="width: 134px" /></td>
										<td><input type="text" name="zy" id="zy" style="width: 134px" /></td>
										<td><select name="nc" id="nc">
												<option value=""></option>
												<option value='1997'>西元1997 / 民國86</option>
												<option value='1996'>西元1996 / 民國85</option>
												<option value='1995'>西元1995 / 民國84</option>
												<option value='1994'>西元1994 / 民國83</option>
												<option value='1993'>西元1993 / 民國82</option>
												<option value='1992'>西元1992 / 民國81</option>
												<option value='1991'>西元1991 / 民國80</option>
												<option value='1990'>西元1990 / 民國79</option>
												<option value='1989'>西元1989 / 民國78</option>
												<option value='1988'>西元1988 / 民國77</option>
												<option value='1987'>西元1987 / 民國76</option>
												<option value='1986'>西元1986 / 民國75</option>
												<option value='1985'>西元1985 / 民國74</option>
												<option value='1984'>西元1984 / 民國73</option>
												<option value='1983'>西元1983 / 民國72</option>
												<option value='1982'>西元1982 / 民國71</option>
												<option value='1981'>西元1981 / 民國70</option>
												<option value='1980'>西元1980 / 民國69</option>
												<option value='1979'>西元1979 / 民國68</option>
												<option value='1978'>西元1978 / 民國67</option>
												<option value='1977'>西元1977 / 民國66</option>
												<option value='1976'>西元1976 / 民國65</option>
												<option value='1975'>西元1975 / 民國64</option>
												<option value='1974'>西元1974 / 民國63</option>
												<option value='1973'>西元1973 / 民國62</option>
												<option value='1972'>西元1972 / 民國61</option>
												<option value='1971'>西元1971 / 民國60</option>
												<option value='1970'>西元1970 / 民國59</option>
												<option value='1969'>西元1969 / 民國58</option>
												<option value='1968'>西元1968 / 民國57</option>
												<option value='1967'>西元1967 / 民國56</option>
												<option value='1966'>西元1966 / 民國55</option>
												<option value='1965'>西元1965 / 民國54</option>
												<option value='1964'>西元1964 / 民國53</option>
												<option value='1963'>西元1963 / 民國52</option>
												<option value='1962'>西元1962 / 民國51</option>
												<option value='1961'>西元1961 / 民國50</option>
												<option value='1960'>西元1960 / 民國49</option>
												<option value='1959'>西元1959 / 民國48</option>
												<option value='1958'>西元1958 / 民國47</option>
												<option value='1957'>西元1957 / 民國46</option>
												<option value='1956'>西元1956 / 民國45</option>
												<option value='1955'>西元1955 / 民國44</option>
												<option value='1954'>西元1954 / 民國43</option>
												<option value='1953'>西元1953 / 民國42</option>
												<option value='1952'>西元1952 / 民國41</option>
												<option value='1951'>西元1951 / 民國40</option>
												<option value='1950'>西元1950 / 民國39</option>
												<option value='1949'>西元1949 / 民國38</option>
												<option value='1948'>西元1948 / 民國37</option>
												<option value='1947'>西元1947 / 民國36</option>
												<option value='1946'>西元1946 / 民國35</option>
												<option value='1945'>西元1945 / 民國34</option>
												<option value='1944'>西元1944 / 民國33</option>
												<option value='1943'>西元1943 / 民國32</option>
												<option value='1942'>西元1942 / 民國31</option>
												<option value='1941'>西元1941 / 民國30</option>
												<option value='1940'>西元1940 / 民國29</option>
												<option value='1939'>西元1939 / 民國28</option>
												<option value='1938'>西元1938 / 民國27</option>
												<option value='1937'>西元1937 / 民國26</option>
												<option value='1936'>西元1936 / 民國25</option>
												<option value='1935'>西元1935 / 民國24</option>
												<option value='1934'>西元1934 / 民國23</option>
												<option value='1933'>西元1933 / 民國22</option>
												<option value='1932'>西元1932 / 民國21</option>
												<option value='1931'>西元1931 / 民國20</option>
												<option value='1930'>西元1930 / 民國19</option>
												<option value='1929'>西元1929 / 民國18</option>
												<option value='1928'>西元1928 / 民國17</option>
												<option value='1927'>西元1927 / 民國16</option>
												<option value='1926'>西元1926 / 民國15</option>
												<option value='1925'>西元1925 / 民國14</option>
												<option value='1924'>西元1924 / 民國13</option>
												<option value='1923'>西元1923 / 民國12</option>
												<option value='1922'>西元1922 / 民國11</option>
												<option value='1921'>西元1921 / 民國10</option>
										</select></td>
										<td><input type="text" name="gx" id="gx" style="width: 70px" /></td>
										<td><img onclick="addFamily();" src="__PUBLIC__/images/add_16.png" style="cursor: pointer" alt="新增" width="16" height="16" border="0" /></td>
									</tr>

									<?php if(is_array($user["families"])): $i = 0; $__LIST__ = $user["families"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$family): ++$i;$mod = ($i % 2 )?><tr>
										<td><?php echo ($family["name"]); ?> <input type="hidden" value="<?php echo ($family["name"]); ?>,<?php echo ($family["duty"]); ?>,<?php echo ($family["birth"]); ?>,<?php echo ($family["relation"]); ?>" name="family[]"></input></td>
										<td><?php echo ($family["duty"]); ?></td>
										<td><?php echo ($family["birth"]); ?></td>
										<td><?php echo ($family["relation"]); ?></td>
										<td><img onclick="$(this).parent().parent().remove();" style="cursor: pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" /></td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</table></td>
						</tr>
						<tr>
							<th scope="row">基本薪資</th>
							<td><input type="text" name="salary" value="<?php echo ($user["salary"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">健康狀況</th>
							<td><input type="text" name="health" value="<?php echo ($user["health"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">緊急聯絡人</th>
							<td><input type="text" name="linkman" value="<?php echo ($user["linkman"]); ?>" style="width: 100px" /> 關係： <input type="text" name="linkrelation" value="<?php echo ($user["linkrelation"]); ?>" style="width: 50px" /> 電話： <input type="text" name="linkphone" value="<?php echo ($user["linkphone"]); ?>" style="width: 120px" /> 手機： <input type="text" name="linkmobile" value="<?php echo ($user["linkmobile"]); ?>" style="width: 120px" /></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td><input type="submit" name="Submit" value="確定" /> <input type="reset" name="Submit2" value="取消" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>