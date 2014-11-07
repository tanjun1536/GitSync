<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>同事名單</title>
<script type="text/JavaScript">
<!--
	function MM_jumpMenu(targ, selObj, restore) { //v3.0
		eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
		if (restore)
			selObj.selectedIndex = 0;
	}
//-->
</script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
<style type="text/css">
<!--
body {
	background-image: none;
}
-->
</style>
</head>

<body>
	<div class="mainPage" style="float: none">
		<div class="topic">同事名單</div>
		<div class="mainInfo">
			<div align="right" style="margin-right: 20px">
				<form id="form1" name="form1" method="post" action="">
					部門： <select name="請選擇" onchange="MM_jumpMenu('parent',this,false)">
						<option value="__URL__/viewreaders?id=<?php echo ($id); ?>" selected="selected">所有同事</option>
						<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dept): ++$i;$mod = ($i % 2 )?><?php if(!empty($depart)): ?><?php if(($depart)  ==  $dept["id"]): ?><option selected="selected" value="__URL__/viewreaders?id=<?php echo ($id); ?>&depart=<?php echo ($dept["id"]); ?>"><?php echo ($dept["name"]); ?></option>
						<?php else: ?>
						<option value="__URL__/viewreaders?id=<?php echo ($id); ?>&depart=<?php echo ($dept["id"]); ?>"><?php echo ($dept["name"]); ?></option><?php endif; ?> <?php else: ?>
						<option value="__URL__/viewreaders?id=<?php echo ($id); ?>&depart=<?php echo ($dept["id"]); ?>"><?php echo ($dept["name"]); ?></option><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</form>
				<table width="675" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><div class="friend_list">
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><div class="freind_box2">
									<div>
										<?php if(!empty($item["readerimage"])): ?><img src="__PUBLIC__/Uploads/<?php echo ($item["readerimage"]); ?>" alt="" width="40" height="40" border="0" align="left" /><?php echo ($item["readername"]); ?>(<?php echo ($item["readercode"]); ?>)
										<?php else: ?>
										<img src="images/no_picture.jpg" alt="" width="40" height="40" border="0" align="left" /><?php echo ($item["readername"]); ?>(<?php echo ($item["readercode"]); ?>)<?php endif; ?>
									</div>
									<div class="txt_lightblue"><?php echo (date('m/d H:i',strtotime($item["readerdate"]))); ?></div>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
							</div></td>
					</tr>
				</table>
			</div>
			<div class="pages">
			<?php echo ($page); ?>
			</div>
		</div>
	</div>
</body>
</html>