<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
<title>差勤表</title>

</head>

<body>
	<form action="__URL__attendanceImportAgain?case=<?php echo $_SESSION["case"];?>&id=<?php echo ($attendance["id"]); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
		<div class="txt_w" style="margin: 10px 20px 20px">
			<?php echo ($year); ?> 年 <?php echo ($month); ?> 月 狀態：未排 <strong>EXCEL匯入</strong>： <input type="file" name="file" /> <input type="submit" name="Submit" value="匯入" />
		</div>
	</form>
	<div style="margin: 0px 10px">
		<table width="1774" border="0" cellpadding="0" cellspacing="1" class="tab_m">
			<tr>
				<th width="71" rowspan="2" scope="col"><div style="width: 63px">日期</div></th>
				<th scope="col">1</th>
				<th scope="col">2</th>
				<th scope="col">3</th>
				<th scope="col">4</th>
				<th scope="col">5</th>
				<th scope="col">6</th>
				<th scope="col">7</th>
				<th scope="col">8</th>
				<th scope="col">9</th>
				<th scope="col">10</th>
				<th scope="col">11</th>
				<th scope="col">12</th>
				<th scope="col">13</th>
				<th scope="col">14</th>
				<th scope="col">15</th>
				<th scope="col">16</th>
				<th scope="col">17</th>
				<th scope="col">18</th>
				<th scope="col">19</th>
				<th scope="col">20</th>
				<th scope="col">21</th>
				<th scope="col">22</th>
				<th scope="col">23</th>
				<th scope="col">24</th>
				<th scope="col">25</th>
				<th scope="col">26</th>
				<th scope="col">27</th>
				<th scope="col">28</th>
				<th scope="col">29</th>
				<th scope="col">30</th>
				<th scope="col">31</th>
			</tr>
			<tr>
				<?php if(is_array($dates)): $i = 0; $__LIST__ = $dates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><td bgcolor="#DFFFF7"><?php echo (getWeek($item)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
			</tr>
			<?php if(is_array($details)): $i = 0; $__LIST__ = $details;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
				<th scope="row"><?php echo ($item["username"]); ?></th>
				<td bgcolor="#FFFFFF"><?php echo ($item["day1"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day2"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day3"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day4"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day5"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day6"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day7"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day8"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day9"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day10"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day11"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day12"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day13"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day14"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day15"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day16"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day17"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day18"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day19"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day20"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day21"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day22"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day23"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day24"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day25"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day26"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day27"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day28"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day29"]); ?></td>
				<td bgcolor="#FFFFFF"><?php echo ($item["day30"]); ?></td>
				<td bgcolor="#FFFFEC"><?php echo ($item["day31"]); ?></td>
			</tr>
			<?php else: ?>
			<tr>
				<th scope="row"><?php echo ($item["username"]); ?></th>
				<td bgcolor="#F2F2F2"><?php echo ($item["day1"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day2"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day3"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day4"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day5"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day6"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day7"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day8"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day9"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day10"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day11"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day12"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day13"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day14"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day15"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day16"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day17"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day18"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day19"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day20"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day21"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day22"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day23"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day24"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day25"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day26"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day27"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day28"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day29"]); ?></td>
				<td bgcolor="#F2F2F2"><?php echo ($item["day30"]); ?></td>
				<td bgcolor="#F1F2E3"><?php echo ($item["day31"]); ?></td>
			</tr><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>

		</table>
	</div>
</body>
</html>