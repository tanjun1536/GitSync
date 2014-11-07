<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-/W3C/DTD XHTML 1.0 Transitional/EN" "http:/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http:/www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/basic.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/calendar.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/nav-h.css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.json-2.3.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/array.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-easyui-1.2.5/easyloader.js"></script>
<script type="text/javascript">
	var src = null;
	var user = new Array();
	$(function() {

		//alert(fn.compare([2,1,3],[1,2,3]));
		$('#electype').change(function() {
			getChildType()
		});
		$('#elecchildtype').change(function() {
			getLevels()
		});
		$('#depart').change(function() {
			getTeam("#depart", "#teams");
		});
		$("#teams").change(function() {
			getPeople();
		});
	});
	function getChildType() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getChildElecById",
			data : "pid=" + $('#electype').val(),
			success : function(data) {
				$("#elecchildtype").empty();
				$("<option value='選擇名稱'>選擇名稱</option>").appendTo(
						"#elecchildtype");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option value='" + json[k]['id'] + "'>"
									+ decodeURI(json[k]['name']) + "</option>")
							.appendTo("#elecchildtype");
				});
			}
		});
	}

	function getLevels() {
		$.ajax({
			type : "POST",
			dataType : "text",
			url : "__URL__/getLevels",
			data : "id=" + $('#elecchildtype').val(),
			success : function(data) {
				var arr = data.split("|");
				var id = arr[0];
				src = arr[0].split(",");
				$("#level").html(arr[1]);
			}
		});
	}
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
	function getPeople() {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getPeopleByTeam",
			data : "id=" + $('#teams').val(),
			success : function(data) {
				$("#users").empty();
				$("<option value=''>請選擇同事</option>").appendTo("#users");
				var json = eval(data);
				if (json == null)
					return;
				$.each(json, function(k) {
					$(
							"<option  value='"+json[k]['id']+"'>"
									+ decodeURI(json[k]['name']) + "("
									+ json[k]['ucode'] + ")</option>")
							.appendTo("#users");
				});
			}
		});
	}
	function addCheck() {
		//如果已經選擇了該人就提示
		if (checkselected()) {
			alert('已經選擇了該人員');
			return;
		}
		if (validator.index('depart', '請選擇部門!')
				&& validator.index('users', '請選擇人員!')) {
			var ul = $('#container');
			var li = $("<li></li>");
			var levels = getLevel();
			var code = '';
			var id = '';
			for ( var i = 0; i < levels.length; i++) {
				code += levels[i].lcode;
				id += levels[i].id;
				if (i < levels.length - 1) {
					code += ',';
					id += ',';
				}
			}
			var hValue = $('#users').val();
			var u = new Object();
			u.id = $('#users').val();
			u.name = $("#users").find("option:selected").text() + "(" + code+ ")";
			u.level=id;
			user.push(u);
			li.append($("#users").find("option:selected").text() + "("+ code + ")")
			  .append($('<img onclick="deleteSelect('+ hValue+ ',this);" style="cursor:pointer" src="__PUBLIC__/images/close_16.png" alt="刪除" width="16" height="16" border="0" />'));
			ul.append(li);

		}
	}
	function deleteSelect(u, img) {
		var arr=[];
		for ( var i = 0; i < user.length; i++) {
			if (user[i].id != u)
				arr.push(user[i]);
		}
		user =arr;
		//alert(user.length);
		$(img).parent().remove();
	}
	function checkselected() {
		for ( var i = 0; i < user.length; i++) {
			if (user[i].id == $('#users').val())
				return true;
		}
		return false;
	}
	function getLevel() {
		var levels = null;
		$.ajax({
			type : "POST",
			dataType : "text",
			url : "__URL__/getLevel",
			data : "id=" + $('#users').val(),
			async : false,
			success : function(data) {
				levels = eval(data);
			}
		});
		return levels;
	}
	function check() {
		if (validator.index('electype', '請選擇類別!')
				&& validator.index('elecchildtype', '請選擇名稱!'))
// 				&& validator.empty('sdate', '請選擇開始時間!')
// 				&& validator.empty('sminute', '請輸開始入分鐘!')
// 				&& validator.empty('sdate', '請選擇結束時間!')
// 				&& validator.empty('sminute', '請輸入結束分鐘!')
// 				&& validator.empty('je', '請輸入金額!')
				 {
			if (user.length == 0) {
				alert('請選擇審核人!');
				return false;
			}
			var levels=new Array();
			for(var j=0;j<user.length;j++)
			{
				levels=levels.concat(user[j].level.split(','));
			}
			for(var i=0;i<src.length;i++)
			{
				//判斷虔誠是否複合要求
				if(jQuery.inArray(src[i],levels)==-1)
					{
						alert('選擇的審核人和簽呈設定不一致!');
						return false;
					}
				else
					{
						$("#checkers").val($.toJSON(user));
						return true;
					}
					
				
			}

		}
		return false;
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


			<div class="topic">文件管理 - 電子簽呈</div>
			<div class="mainInfo">
				<form action="__URL__/insert" method="post"
					onsubmit="return check()" enctype="multipart/form-data"
					name="form1" id="form1">
					<input type="text" name="checkers" id="checkers">
					<div class="topic2">新增電子簽呈</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1"
						class="tabThSide">
						<tr>
							<th scope="row">申請人</th>
							<td><?php echo $_SESSION["SESSION_USER"]["name"];?>(<?php echo $_SESSION["SESSION_USER"]["ucode"];?>)</td>
							<input type="hidden" name="requester" value="<?php echo $_SESSION["SESSION_USER"]["id"];?>"
								id="requester" />
							<input type="hidden" name="requestername"
								value="<?php echo $_SESSION["SESSION_USER"]["name"];?>" id="requester" />
							<input type="hidden" name="requestercode"
								value="<?php echo $_SESSION["SESSION_USER"]["ucode"];?>" id="requester" />
						</tr>
						<tr>
							<th scope="row">類別/名稱</th>
							<td><label> <select name="electype" id="electype">
										<option value="選擇類別">選擇類別</option>
										<?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select> <select name="elecchildtype" id="elecchildtype">
										<option value="選擇名稱">選擇名稱</option>
								</select> <span class="txt_red" id="level">(選擇後此處顯示級別) </span></label></td>
						</tr>
						<tr>
							<th width="94" scope="row">起迄時間</th>
							<td width="598"><input type="text" name="sdate" id="sdate"
								class="Wdate" onfocus="WdatePicker()" style="width: 100px" /> <select
								name="shour">
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
							</select> 時 ： <input name="sminute" id="sminute" style="width: 30px"
								/> 分~ <input
								type="text" name="edate" id="edate" class="Wdate"
								onfocus="WdatePicker()" style="width: 100px" /> <select
								name="ehour">
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
							</select> 時 ： <input id="eminute" name="eminute" style="width: 30px" /> 分</td>
						</tr>
						<tr>
							<th scope="row">金額</th>
							<td><input type="text" name="je" id="je"
								style="width: 100px" /></td>
						</tr>
						<tr>
							<th scope="row">內容描述</th>
							<td><textarea name="descript" rows="8" style="width: 500px"></textarea></td>
						</tr>
						<tr>
							<th scope="row">備註</th>
							<td><textarea name="remark" rows="8" style="width: 500px"></textarea></td>
						</tr>
						<tr>
							<th scope="row">簽核人</th>
							<td>
								<div>
									<select name="depart" id="depart">
										<option value="請選擇部門">請選擇部門</option>
										<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
									</select> <select name="teams" id="teams">
										<option value="">選擇組別</option>
									</select><select name="users" id="users">
										<option value="請選擇同事">請選擇同事</option>
									</select> <img src="__PUBLIC__/images/add_16.png"
										style="cursor: pointer;" alt="新增" onclick="addCheck();"
										width="16" height="16" />
								</div>
								<ul style="margin-top: 10px" id="container">
								</ul>
							</td>
						</tr>
						<tr>
							<th scope="row">附件</th>
							<td>
								<ul id="files">
									<li><input type="file" name="atts[]" /> <img
										src="__PUBLIC__/images/add_16.png"
										onclick="$('#files').append($('<li><input type=&quot;file&quot; name=&quot;atts[]&quot; /></li>'))"
										style="cursor: pointer;" alt="新增" width="16" height="16" /></li>
									<li><input type="file" name="atts[]" /></li>
								</ul>
							</td>
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