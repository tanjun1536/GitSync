<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/basic.css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
$(function() {
	$('#province').change(function() {
		getCity()
	});
	//檢查用戶名是否重複
	$("#name").live("blur", function() {
		checkUser();
	});
	$.ajax({
		type : "POST",
		dataType : "json",
		url : "__URL__/getCity",
		data : "pid=" + $('#province').val(),
		async:false, 
		success : function(data) {
			$("#city").empty();
			$("<option value='請選擇'>請選擇</option>").appendTo("#city");
			var json = eval(data);
			$.each(json, function(k) {
				$("<option value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#city");
			});
			$("#city").val(<?php echo ($com["city"]); ?>);
		}
	});
	
	$("#onhour").val(<?php echo ($com["onhour"]); ?>);
	$("#onminute").val(<?php echo ($com["onminute"]); ?>);
	$("#downhour").val(<?php echo ($com["downhour"]); ?>);
	$("#downminute").val(<?php echo ($com["downminute"]); ?>);
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
				$("<option value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo("#city");
			});
		}
	});
}
function check() {
	return validator.empty('name', '請輸入公司名稱');
}
</script>
</head>

<body>
	<div class="webpage">
		<div class="top">
  <div class="top_logo">
    <h1>物業管理系統　後台管理</h1>
  </div>
</div>
  <div class="text_signin">顯示帳號，您好!　<a href="__APP__/Index/logout">登出</a></div>

		<table width="980" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="180" valign="top" bgcolor="#FFFFFF"><div class="menu">
  <ul>
    <li>公司管理
        <ul>
          <li><a href="__APP__/Company/index">公司列表</a></li>
          <li><a href="__APP__/Company/add">新增公司</a></li>
        </ul>
    </li>
  </ul>
</div>

</td>
				<td width="800" valign="top"><div class="mainPage">
						<div class="topic">修改公司</div>
			<form action="__URL__/update" onsubmit="return check();" method="post" enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name="id" value="<?php echo ($com["id"]); ?>" />
					<table width="695" border="0" align="center" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th scope="row">公司名稱</th>
							<td><input type="text" name="name" value="<?php echo ($com["name"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">負責人姓名</th>
							<td><input type="text" name="leader" value="<?php echo ($com["leader"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">統一編號</th>
							<td><input type="text" name="code" value="<?php echo ($com["code"]); ?>" /></td>
						</tr>
						<tr>
							<th width="110" scope="row">公司電話</th>
							<td width="587"><input type="text" name="phone" value="<?php echo ($com["phone"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">公司傳真</th>
							<td><input type="text" name="fax" value="<?php echo ($com["fax"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">公司地址</th>
							<td><select name="province" id="province">
									<option value="請選擇">請選擇</option>
									<?php if(is_array($provinces)): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(($item["id"])  ==  $com["province"]): ?><option selected="selected" value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option>
									<?php else: ?>
									<option value="<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?></option><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
							</select> <select name="city" id="city">
									<option value="請選擇">請選擇</option>
							</select> <input type="text" name="address" style="width: 300px" value="<?php echo ($com["address"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">聯絡人</th>
							<td><input type="text" name="linker" value="<?php echo ($com["linker"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">聯絡人電話</th>
							<td><input type="text" name="linkphone"  value="<?php echo ($com["linkphone"]); ?>" /> ；行動電話 <input type="text" name="mobile" value="<?php echo ($com["mobile"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">EMAIL</th>
							<td><input type="text" name="email"  value="<?php echo ($com["email"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">上下班時間</th>
							<td>上班 <select name="onhour" id="onhour">
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
							</select> 時 <input type="text" name="onminute" id="onminute" style="width: 20PX" /> 分 ；下班 <select name="downhour" id="downhour">
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
							</select> 時 <input type="text" name="downminute" id="downminute" style="width: 20PX" /> 分
							</td>
						</tr>
						<tr>
							<th scope="row">使用期限</th>
							<td><input type="text" name="period" value="<?php echo (date('Y-m-d',strtotime($com["period"]))); ?>" class="Wdate" onFocus="WdatePicker()" style="width: 120PX" /></td>
						</tr>
						<tr>
							<th scope="row">可建帳號數</th>
							<td><input type="text" name="usercount" value="<?php echo ($com["usercount"]); ?>" style="width: 20PX" /></td>
						</tr>
						<tr>
							<th scope="row">公司帳號</th>
							<td><input type="text" name="account" value="<?php echo ($com["account"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">密碼</th>
							<td><input type="password" name="password" value="<?php echo ($com["password"]); ?>" /></td>
						</tr>
						<tr>
							<th scope="row">&nbsp;</th>
							<td><input type="submit" name="Submit" value="確定" /> <input type="reset" name="Submit2" value="取消" /></td>
						</tr>
					</table>
				</form>
					</div></td>
			</tr>
		</table>
		<div class="foot">台灣達奈股份有限公司　版權所有</div>


	</div>
</body>
</html>