<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/Jquery.Query.js"></script>
<script type="text/JavaScript">
<!--
	var dep = "<?php echo ($depart); ?>";
	var tm = "<?php echo ($team); ?>";
	var idInput = $.query.get('id');
	var nameInput = $.query.get('name');
	var selUsers="<?php echo ($selUsers); ?>";
	$(function() {
		$('#depart').change(function() {
			getTeam('#depart', '#team');
		});
		if (dep)
			$("#depart").val(dep).trigger('change');

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
				if (!json)
					return;
				$.each(json, function(k) {
					$("<option  value='"+json[k]['id']+"'>" + decodeURI(json[k]['name']) + "</option>").appendTo(teams);
				});
				if (tm)
					$('#team').val(tm);
			}
		});
	}

	function MM_jumpMenu(targ, selObj, restore) { //v3.0
		var url = '__URL__/usercheckbox?depart=' + $("#depart").val() + '&team=' + $('#team').val()+"&selUsers="+selUsers;
		if(idInput)url+='&id='+idInput;
		if(nameInput)url+='&name='+nameInput;
		
		eval(targ + ".location='" + url + "'");
		if (restore)
			selObj.selectedIndex = 0;
	}
	function closeWindow() {
		var ids = "";
		var names = "";
		var us = $("input[type=checkbox]:checked");//document.getElementsByName("users[]");
		var idname, idnamearr, id, name, code;
		var len = us.length;
		//var checkedlen = $("input[type=checkbox]:checked").length;
		for ( var i = 0; i < len; i++) {
			var checkbox = us[i];
			if (checkbox.checked) {
				idname = checkbox.value;
				idnamearr = idname.split("|");
				id = idnamearr[0];
				name = idnamearr[1];
				code = idnamearr[2];
				ids += id;
				names += name + '(' + code + ')';
				if (i < len - 1) {
					ids += ",";
					names += ",";
				}

			}
		}
		window.opener.document.getElementById(idInput).value = ids;
		window.opener.document.getElementById(nameInput).value = names;
		window.close();
	}
</script>
</head>
<body>
	<div class="mainPage" style="float: none">
		<div class="topic">同事名單</div>
		<div class="mainInfo">
			<div align="right" style="margin-right: 20px">
				<form id="form1" name="form1" method="post" action="">
					部門： <select name="depart" id="depart">
						<option value="__URL__/usercheckbox" selected="selected">所有同事</option>
						<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dept): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($dept["id"]); ?>"><?php echo ($dept["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select> 單位: <select name="team" id="team" onchange="MM_jumpMenu('parent',this,false)">
						<option selected="selected">所有同事</option>
						</volist>
					</select>
				</form>
				<table width="675" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><div class="friend_list">
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><div class="freind_box">
									<div>
										<a href="#"> <?php if(empty($item["userimage"])): ?><img src="__PUBLIC__/images/no_picture.jpg" alt="" width="100" height="100" border="0" /> <?php else: ?> <img src="__PUBLIC__/Uploads/<?php echo ($item["userimage"]); ?>" alt="" width="100" height="100" border="0" /><?php endif; ?>
										</a>
									</div>
									<div>
										<a href="#"><?php echo ($item["name"]); ?></a>
									</div>
									<div><?php echo ($item["ucode"]); ?></div>
									<?php if(in_array(($item["id"]), is_array($selUsers)?$selUsers:explode(',',$selUsers))): ?><input type="checkbox" checked="checked" name="users[]" value="<?php echo ($item["id"]); ?>|<?php echo ($item["name"]); ?>|<?php echo ($item["ucode"]); ?>" /> <?php else: ?> <input type="checkbox" name="users[]" value="<?php echo ($item["id"]); ?>|<?php echo ($item["name"]); ?>|<?php echo ($item["ucode"]); ?>" /><?php endif; ?>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
							</div></td>
					</tr>
					<tr>
						<td height="50" align="center"><input type="button" name="sel" onclick="closeWindow();" value="確定加入" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	</div>
</body>
</html>