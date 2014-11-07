<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>月叫修數量統計表</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
</head>

<body>
	<div class="txt_w" style="margin: 10px 20px 20px">
		<strong><?php echo ($year); ?> 年 <?php echo ($month); ?> 月</strong> 月保養明細統計表
	</div>
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
		<div style="margin: 10px 20px 20px">
			西元 <input type="text" name="year" style="width: 100px" /> 年 <select name="month">
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
			</select> 月 <input type="submit" name="Submit2" value="搜尋" />
		</div>
	</form>
	<div style="margin: 0px 10px">
		<table width="800" border="0" cellpadding="0" cellspacing="1" class="tab_month">
			<tr>
				<th scope="col">日期</th>
				<th scope="col">星期</th>
				<th scope="col">報修總數</th>
				<th scope="col">當天完修</th>
				<th scope="col">隔日完修</th>
				<th scope="col">2日以上完修</th>
				<th scope="col">尚未修復</th>
			</tr>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
				<?php if($item["dd"] == '統計' ): ?><th colspan="2" scope="row">統計</th>
				<td class="tdcolor2"><?php echo ($item["al"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["currday"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["afteraday"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["morethan2day"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["nonecomplete"]); ?></td>
				<?php elseif($item["dd"] == '比率' ): ?>
				<th colspan="2" scope="row">比率</th>
				<td class="tdcolor1"><?php echo ($item["al"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["currday"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["afteraday"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["morethan2day"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["nonecomplete"]); ?></td>
				<?php else: ?>
				<th scope="row"><?php echo (getDay($item["dd"])); ?></th>
				<th scope="row"><?php echo (getWeek($item["dd"])); ?></th>
				<td><?php echo ($item["al"]); ?></td>
				<td><?php echo ($item["currday"]); ?></td>
				<td><?php echo ($item["afteraday"]); ?></td>
				<td><?php echo ($item["morethan2day"]); ?></td>
				<td><?php echo ($item["nonecomplete"]); ?></td><?php endif; ?>

			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</body>
</html>