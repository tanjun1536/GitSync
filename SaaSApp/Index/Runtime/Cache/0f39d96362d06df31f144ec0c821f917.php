<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>排程表</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
</head>

<body>
	<div class="txt_w" style="margin: 10px 20px 20px">
		<?php echo ($schedul["year"]); ?> 年 <?php echo ($schedul["month"]); ?> 月 <strong>排程表</strong>
	</div>
	<table width="1363" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366" class="tab_thtop">
		<tr>
			<th colspan="35" scope="col">排 程 表</th>
		</tr>

		<tr>
			<th width="32" rowspan="2" class="thcolor" scope="col"><div style="width: 35px">類別</div></th>
			<th rowspan="2" class="thcolor" scope="col"><div style="width: 70px">週期</div></th>
			<th rowspan="2" class="thcolor" scope="col"><div style="width: 70px">建物區域</div></th>
			<th rowspan="2" class="thcolor" scope="col"><div style="width: 250px">設備名稱</div></th>
			<?php if(is_array($dates)): $i = 0; $__LIST__ = $dates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><th class="thcolor2" scope="col"><?php echo ($i); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
		</tr>
		<tr>
			<?php if(is_array($dates)): $i = 0; $__LIST__ = $dates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><th class="thcolor2" scope="col"><?php echo (getWeek($item)); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr class="trcolor1">
			<?php else: ?>
			<tr class="trcolor2"><?php endif; ?>
		<td align="center"><?php echo ($item["tname"]); ?></td>
		<td align="center"><?php echo ($item["name"]); ?></td>
		<td>&nbsp;</td>
		<td><?php echo ($item["ctname"]); ?></td>
		<?php if(is_array($dates)): $i = 0; $__LIST__ = $dates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): ++$i;$mod = ($i % 2 )?><td align="center"><?php echo (getY($item,$d)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
</body>
</html>