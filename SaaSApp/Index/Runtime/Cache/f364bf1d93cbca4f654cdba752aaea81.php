<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>年度叫修數量統計表</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
</head>

<body>
	<div class="txt_w" style="margin: 10px 20px 20px">
		<strong><?php echo ($year); ?> 年</strong> 年度完工明細統計表
	</div>
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
		<div style="margin: 10px 20px 20px">
			西元 <input type="text" name="year" style="width: 100px" /> 年 <input type="submit" name="Submit2" value="搜尋" />
		</div>
	</form>
	<div style="margin: 0px 10px">
		<table width="800" border="0" cellpadding="0" cellspacing="1" class="tab_month">
			<tr>
				<th colspan="2" scope="col"><div style="width: 300px">項目 / 月份</div></th>
				<th width="40" scope="col">1月</th>
				<th width="40" scope="col">2月</th>
				<th width="40" scope="col">3月</th>
				<th width="40" scope="col">4月</th>
				<th width="40" scope="col">5月</th>
				<th width="40" scope="col">6月</th>
				<th width="40" scope="col">7月</th>
				<th width="40" scope="col">8月</th>
				<th width="40" scope="col">9月</th>
				<th width="40" scope="col">10月</th>
				<th width="40" scope="col">11月</th>
				<th width="40" scope="col">12月</th>
				<th width="40" class="thcolor3" scope="col">總計</th>
				<th width="70" scope="col">設備比例</th>
			</tr>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
				<?php if($item["n"] == '累計' ): ?><th colspan="2" class="thcolor1" scope="row">累計</th>
				<td class="tdcolor1"><?php echo ($item["m1"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m2"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m3"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m4"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m5"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m6"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m7"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m8"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m9"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m10"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m11"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["m12"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["rt"]); ?></td>
				<td>&nbsp;</td>
				<?php elseif($item["n"] == '叫修比例%'): ?>
				<th colspan="2" class="thcolor2" scope="row"><?php echo ($item["n"]); ?></th>
				<td><?php echo ($item["m1"]); ?></td>
				<td><?php echo ($item["m2"]); ?></td>
				<td><?php echo ($item["m3"]); ?></td>
				<td><?php echo ($item["m4"]); ?></td>
				<td><?php echo ($item["m5"]); ?></td>
				<td><?php echo ($item["m6"]); ?></td>
				<td><?php echo ($item["m7"]); ?></td>
				<td><?php echo ($item["m8"]); ?></td>
				<td><?php echo ($item["m9"]); ?></td>
				<td><?php echo ($item["m10"]); ?></td>
				<td><?php echo ($item["m11"]); ?></td>
				<td><?php echo ($item["m12"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["rt"]); ?></td>
				<td><?php echo ($item["rb"]); ?></td>
				<?php else: ?>
				<th><?php echo ($item["n"]); ?></th>
				<th><?php echo ($item["cn"]); ?></th>
				<td><?php echo ($item["m1"]); ?></td>
				<td><?php echo ($item["m2"]); ?></td>
				<td><?php echo ($item["m3"]); ?></td>
				<td><?php echo ($item["m4"]); ?></td>
				<td><?php echo ($item["m5"]); ?></td>
				<td><?php echo ($item["m6"]); ?></td>
				<td><?php echo ($item["m7"]); ?></td>
				<td><?php echo ($item["m8"]); ?></td>
				<td><?php echo ($item["m9"]); ?></td>
				<td><?php echo ($item["m10"]); ?></td>
				<td><?php echo ($item["m11"]); ?></td>
				<td><?php echo ($item["m12"]); ?></td>
				<td class="tdcolor2"><a target="_blank" href="__URL__/statisticscompletedetail?case=<?php echo $_SESSION["case"];?>&year=<?php echo ($year); ?>&maintype=<?php echo ($item["mt"]); ?>&childtype=<?php echo ($item["ct"]); ?>"><?php echo ($item["rt"]); ?></a></td>
				<td><?php echo ($item["rb"]); ?></td><?php endif; ?>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</body>
</html>