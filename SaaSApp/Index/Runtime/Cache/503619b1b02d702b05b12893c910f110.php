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
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/JavaScript">
	$(function() {
		$('#jfsubjectmaintype').change(function() {
			getChildType('#jfsubjectmaintype', '#jfsubjectchildtype');
		});
		$('#dfsubjectmaintype').change(function() {
			getChildType('#dfsubjectmaintype', '#dfsubjectchildtype');
		});
		$('#dxjfsubjectmaintype').change(function() {
			getChildType('#dxjfsubjectmaintype', '#dxjfsubjectchildtype');
		});
		$('#dxdfsubjectmaintype').change(function() {
			getChildType('#dxdfsubjectmaintype', '#dxdfsubjectchildtype');
		});

		$('#jfsubjectchildtype').change(function() {
			getSubject('#jfsubjectchildtype', '#jfsubject');
		});
		$('#dfsubjectchildtype').change(function() {
			getSubject('#dfsubjectchildtype', '#dfsubject');
		});
		$('#dxjfsubjectchildtype').change(function() {
			getSubject('#dxjfsubjectchildtype', '#dxjfsubject');
		});
		$('#dxdfsubjectchildtype').change(function() {
			getSubject('#dxdfsubjectchildtype', '#dxdfsubject');
		});
		$('input:radio').click(function() {
			this.blur();
			this.focus();
		});
		$('input:radio').change(function() {
			queryObject(this);
		});

		$("#dddate1").val(new Date().format("yyyy/MM/dd hh:mm"));
		$("#tddddate1").html($("#dddate1").val());

		$("#account").change(function() {
			var backname = $(this).find("option:selected").attr("backname");
			var accountname = $(this).find("option:selected").attr("accountname");
			$("#bankname").val(backname);
			$("#username").val(accountname);
			$("#tdbankname").html(backname);
			$("#tdusername").html(accountname);
		});
	});
	function getChildType(maintype, chidtype) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getChildType",
			data : "type=" + $(maintype).val(),
			success : function(data) {
				$(chidtype).empty();
				$("<option value=''>選擇子類別</option>").appendTo(chidtype);
				var json = eval(data);
				if (!json)
					return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo(chidtype);
				});
			}
		});
	}
	function getSubject(childtype, subject) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "__URL__/getSubject",
			data : "ct=" + $(childtype).val(),
			success : function(data) {
				$(subject).empty();
				$("<option value=''>選擇科目</option>").appendTo(subject);
				var json = eval(data);
				if (!json)
					return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['subjectname']) + "</option>").appendTo(subject);
				});
			}
		});
	}
	function getObject(url, object) {
		$.ajax({
			type : "POST",
			dataType : "json",
			url : url,
			success : function(data) {
				$(object).empty();
				$("<option value=''>選擇</option>").appendTo(object);
				var json = eval(data);
				if (!json)
					return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo(object);
				});
			}
		});
	}
	function queryObject(selObj) {
		var url;
		if (selObj.value == '廠商') {
			url = '__URL__/getManufacturer';
		} else if (selObj.value == '客戶') {
			url = '__URL__/getClient';
		} else if (selObj.value == '專案') {
			url = '__URL__/getCase';
		} else {
			$('#objectselect').empty().append('<option value="請選擇">請選擇</option>');
		}
		getObject(url, '#objectselect');
	}
	function check() {
		if ($("#objectselect")[0].selectedIndex != 0) {
			$("#objectid").val($("#objectselect").val());
			var v=$("#objectselect").find("option:selected").text();
			$("#objectname").val(v);
		} else {
			$("#objectid").val($("#objectselect").val());
			$("#objectname").val($("#objecttext").val());
		}
		return validator.index('jfsubject', '選擇科目');
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


			<div class="topic">會計系統- 支付管理</div>
			<div class="mainInfo">
				<form action="__URL__/addPay" method="post" enctype="multipart/form-data" name="form1" onsubmit="return check()" id="form1">
					<input type="hidden" name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>" />
					<div class="topic2">新增紀錄</div>
					<table width="695" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th scope="row">日期</th>
							<td><input type="text" name="indate"  class="Wdate" onfocus="WdatePicker()" /></td>
						</tr>
						<tr>
							<th width="131" scope="row">所屬部門</th>
							<td width="561"><input type="hidden" name="departname" id="departname" />
							<select id="depart" name="depart" onchange="$('#departname').val($(this).find('option:selected').text())" style="width: 120px">
									<option value="選擇部門">選擇部門</option>
									<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<th width="131" scope="row">對象類別</th>
							<td width="561"><input name="objecttype" type="radio" value="廠商" checked="checked" /> 廠商 <input name="objecttype" type="radio" value="客戶" /> 客戶 <input name="objecttype" type="radio" value="專案" /> 專案 <input name="objecttype" type="radio" value="其他" /> 其他</td>
						</tr>
						<tr>
							<th scope="row">對象</th>
							<td>
							<input type="hidden" id="objectid" name="objectid" />
							 <input type="hidden" id="objectname" name="objectname"/>
							  <select name="objectselect" id="objectselect">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" id="objecttext" /></td>
						</tr>
						<tr>
							<th scope="row">借方科目</th>
							<td><select name="jfsubjectmaintype" id="jfsubjectmaintype">
									<option>選擇主類別</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="jfsubjectchildtype" id="jfsubjectchildtype">
									<option value="選擇子類別">選擇子類別</option>
							</select> <select name="jfsubject" id="jfsubject">
									<option value="選擇科目">選擇科目</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">貸方科目</th>
							<td><select name="dfsubjectmaintype" id="dfsubjectmaintype">
									<option>選擇主類別</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="dfsubjectchildtype" id="dfsubjectchildtype">
									<option value="選擇子類別">選擇子類別</option>
							</select> <select name="dfsubject" id="dfsubject">
									<option value="選擇科目">選擇科目</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">預計兌現日期</th>
							<td><input type="text" name="estimateclearancedate" class="Wdate" onfocus="WdatePicker()" /></td>
						</tr>
						<tr>
							<th scope="row">實際兌現日期</th>
							<td><input type="text" name="actualclearancedate" class="Wdate" onfocus="WdatePicker()" /></td>
						</tr>
						<tr>
							<th scope="row">退票日期</th>
							<td><input type="text" name="backbilldate" class="Wdate" onfocus="WdatePicker()" /></td>
						</tr>
						<tr>
							<th scope="row">兌現借方科目</th>
							<td><select name="dxjfsubjectmaintype" id="dxjfsubjectmaintype">
									<option>選擇主類別</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="dxjfsubjectchildtype" id="dxjfsubjectchildtype">
									<option value="選擇子類別">選擇子類別</option>
							</select> <select name="dxjfsubject" id="dxjfsubject">
									<option value="選擇科目">選擇科目</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">兌現貸方科目</th>
							<td><select name="dxdfsubjectmaintype" id="dxdfsubjectmaintype">
									<option>選擇主類別</option>
									<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="dxdfsubjectchildtype" id="dxdfsubjectchildtype">
									<option value="選擇子類別">選擇子類別</option>
							</select> <select name="dxdfsubject" id="dxdfsubject">
									<option value="選擇科目">選擇科目</option>
							</select></td>
						</tr>
						<tr>
							<th colspan="2" scope="row"><div align="center">
									<strong>票據資料</strong>
								</div></th>
						</tr>
						<tr>
							<th scope="row">支票號碼</th>
							<td><input type="text" name="billcode" /></td>
						</tr>
						<tr>
							<th scope="row">支票抬頭</th>
							<td><input type="text" name="billtitle"  /></td>
						</tr>
						<tr>
							<th scope="row">支票金額</th>
							<td><input type="text" name="billmoney"   /></td>
						</tr>
						<tr>
							<th scope="row">支票到期日</th>
							<td><input type="text" name="billexpiredate" class="Wdate" onfocus="WdatePicker()" /></td>
						</tr>
						<tr>
							<th scope="row">支付銀行帳號</th>
							<td><input type="text" name="paybankaccount" /></td>
						</tr>
						<tr>
							<th colspan="2" scope="row"><div align="center">
									<strong>款項入帳 帳戶資料</strong>
								</div></th>
						</tr>
						<tr>
							<th scope="row">帳戶</th>
							<td><select name="account" id="account">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($accs)): $i = 0; $__LIST__ = $accs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><option backname="<?php echo ($item["bankname"]); ?>" accountname="<?php echo ($item["accountname"]); ?>" value="<?php echo ($item["id"]); ?>"><?php echo ($item["account"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select></td>
						</tr>
						<tr>
							<input type="hidden" id="bankname" name="bankname" />
							<th scope="row">銀行名稱</th>
							<td id="tdbankname">系統帶出</td>
						</tr>
						<tr>
							<input type="hidden" id="username" name="username" />
							<th scope="row">戶名</th>
							<td id="tdusername">系統帶出</td>
						</tr>
						<tr>
							<th scope="row">金額</th>
							<td><input type="text" name="incomemoney" /></td>
						</tr>
						<tr>
							<th scope="row">付款方式</th>
							<td><select name="paymode" id="paymode">
									<option>請選擇</option>
									<option value="現金">現金</option>
									<option value="匯款">匯款</option>
									<option value="票據">票據</option>
							</select></td>
						</tr>
						<tr>
							<th scope="row">狀態</th>
							<td><select name="paystate" id="paystate">
									<option>請選擇</option>
									<option value="兌現">兌現</option>
									<option value="未兌現">未兌現</option>
									<option value="退票">退票</option>
							</select></td>
						</tr>
						<tr>
							<input type="hidden" id="dddate1" name="dddate1" />
							<th scope="row">登打時間</th>
							<td id="tddddate1"></td>
						</tr>
						<tr>
							<input type="hidden" id="ddperson1" name="ddperson1" value="<?php echo $_SESSION["SESSION_USER"]["name"];?>" />
							<th scope="row">登打人</th>
							<td id="tdddperson1"><?php echo $_SESSION["SESSION_USER"]["name"];?></td>
						</tr>
						<tr>
							<th scope="row">實收金額</th>
							<td><input type="text" name="actualreceivemoney"   /></td>
						</tr>
						<tr>
							<th scope="row">差額科目</th>
							<td><input type="text" name="cesubject" /></td>
						</tr>
						<tr>
							<th scope="row">差額</th>
							<td><input type="text" name="ce"  /></td>
						</tr>
						<tr>
							<input type="hidden" id="dddate2" name="dddate2" />
							<th scope="row">登打時間</th>
							<td></td>
						</tr>
						<tr>
							<input type="hidden" id="ddperson2" name="ddperson2" />
							<th scope="row">登打人</th>
							<td></td>
						</tr>
						<tr>
							<th scope="row">備註</th>
							<td><textarea name=remark rows="6" style="width: 400px"></textarea></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td><input type="submit" name="Submit" value="確定" /> <input type="reset" name="Submit22" value="取消" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>