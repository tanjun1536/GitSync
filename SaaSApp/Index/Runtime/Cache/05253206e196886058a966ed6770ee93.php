<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>月叫修數量統計表</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
</head>

<body>
	<div class="txt_w" style="margin: 10px 20px 20px">
		<strong><?php echo ($year); ?> 年 <?php echo ($month); ?> 月</strong> 月保養數量統計表
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
		<table border="0" cellpadding="0" cellspacing="1" class="tab_month">
			<tr>
				<th colspan="1" rowspan="2" scope="col"><div style="width: 190px">項目/日期</div></th>
				<th width="30" scope="col">1</th>
				<th width="30" scope="col">2</th>
				<th width="30" scope="col">3</th>
				<th width="30" scope="col">4</th>
				<th width="30" scope="col">5</th>
				<th width="30" scope="col">6</th>
				<th width="30" scope="col">7</th>
				<th width="30" scope="col">8</th>
				<th width="30" scope="col">9</th>
				<th width="30" scope="col">10</th>
				<th width="30" scope="col">11</th>
				<th width="30" scope="col">12</th>
				<th width="30" scope="col">13</th>
				<th width="30" scope="col">14</th>
				<th width="30" scope="col">15</th>
				<th width="30" scope="col">16</th>
				<th width="30" scope="col">17</th>
				<th width="30" scope="col">18</th>
				<th width="30" scope="col">19</th>
				<th width="30" scope="col">20</th>
				<th width="30" scope="col">21</th>
				<th width="30" scope="col">22</th>
				<th width="30" scope="col">23</th>
				<th width="30" scope="col">24</th>
				<th width="30" scope="col">25</th>
				<th width="30" scope="col">26</th>
				<th width="30" scope="col">27</th>
				<th width="30" scope="col">28</th>
				<th width="30" scope="col">29</th>
				<th width="30" scope="col">30</th>
				<th width="30" scope="col">31</th>
				<th width="35" rowspan="2" class="thcolor3" scope="col">統計</th>
				<th width="40" rowspan="2" scope="col">備註</th>
			</tr>
			<tr>
				<?php if(is_array($dates)): $i = 0; $__LIST__ = $dates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><th scope="col"><?php echo (getWeek($item)); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
			</tr>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
				<?php if($item["n"] == '總數' ): ?><th colspan="1" class="thcolor1" scope="row">總數</th>
				<td class="tdcolor1"><?php echo ($item["day1"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day2"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day3"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day4"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day5"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day6"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day7"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day8"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day9"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day10"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day11"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day12"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day13"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day14"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day15"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day16"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day17"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day18"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day19"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day20"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day21"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day22"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day23"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day24"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day25"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day26"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day27"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day28"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day29"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day30"]); ?></td>
				<td class="tdcolor1"><?php echo ($item["day31"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["rt"]); ?></td>
				<td>&nbsp;</td>
				<?php elseif($item["n"] == '比例%'): ?>
				<th colspan="1" class="thcolor2" scope="row"><?php echo ($item["n"]); ?></th>
				<td><?php echo ($item["day1"]); ?></td>
				<td><?php echo ($item["day2"]); ?></td>
				<td><?php echo ($item["day3"]); ?></td>
				<td><?php echo ($item["day4"]); ?></td>
				<td><?php echo ($item["day5"]); ?></td>
				<td><?php echo ($item["day6"]); ?></td>
				<td><?php echo ($item["day7"]); ?></td>
				<td><?php echo ($item["day8"]); ?></td>
				<td><?php echo ($item["day9"]); ?></td>
				<td><?php echo ($item["day10"]); ?></td>
				<td><?php echo ($item["day11"]); ?></td>
				<td><?php echo ($item["day12"]); ?></td>
				<td><?php echo ($item["day13"]); ?></td>
				<td><?php echo ($item["day14"]); ?></td>
				<td><?php echo ($item["day15"]); ?></td>
				<td><?php echo ($item["day16"]); ?></td>
				<td><?php echo ($item["day17"]); ?></td>
				<td><?php echo ($item["day18"]); ?></td>
				<td><?php echo ($item["day19"]); ?></td>
				<td><?php echo ($item["day20"]); ?></td>
				<td><?php echo ($item["day21"]); ?></td>
				<td><?php echo ($item["day22"]); ?></td>
				<td><?php echo ($item["day23"]); ?></td>
				<td><?php echo ($item["day24"]); ?></td>
				<td><?php echo ($item["day25"]); ?></td>
				<td><?php echo ($item["day26"]); ?></td>
				<td><?php echo ($item["day27"]); ?></td>
				<td><?php echo ($item["day28"]); ?></td>
				<td><?php echo ($item["day29"]); ?></td>
				<td><?php echo ($item["day30"]); ?></td>
				<td><?php echo ($item["day31"]); ?></td>
				<td class="tdcolor2"><?php echo ($item["rt"]); ?></td>
				<td><?php echo ($item["rb"]); ?></td>
				<?php else: ?>
				<th><?php echo ($item["n"]); ?></th>
				<td><?php echo ($item["day1"]); ?></td>
				<td><?php echo ($item["day2"]); ?></td>
				<td><?php echo ($item["day3"]); ?></td>
				<td><?php echo ($item["day4"]); ?></td>
				<td><?php echo ($item["day5"]); ?></td>
				<td><?php echo ($item["day6"]); ?></td>
				<td><?php echo ($item["day7"]); ?></td>
				<td><?php echo ($item["day8"]); ?></td>
				<td><?php echo ($item["day9"]); ?></td>
				<td><?php echo ($item["day10"]); ?></td>
				<td><?php echo ($item["day11"]); ?></td>
				<td><?php echo ($item["day12"]); ?></td>
				<td><?php echo ($item["day13"]); ?></td>
				<td><?php echo ($item["day14"]); ?></td>
				<td><?php echo ($item["day15"]); ?></td>
				<td><?php echo ($item["day16"]); ?></td>
				<td><?php echo ($item["day17"]); ?></td>
				<td><?php echo ($item["day18"]); ?></td>
				<td><?php echo ($item["day19"]); ?></td>
				<td><?php echo ($item["day20"]); ?></td>
				<td><?php echo ($item["day21"]); ?></td>
				<td><?php echo ($item["day22"]); ?></td>
				<td><?php echo ($item["day23"]); ?></td>
				<td><?php echo ($item["day24"]); ?></td>
				<td><?php echo ($item["day25"]); ?></td>
				<td><?php echo ($item["day26"]); ?></td>
				<td><?php echo ($item["day27"]); ?></td>
				<td><?php echo ($item["day28"]); ?></td>
				<td><?php echo ($item["day29"]); ?></td>
				<td><?php echo ($item["day30"]); ?></td>
				<td><?php echo ($item["day31"]); ?></td>
				<td class="tdcolor2"><a target="_blank" href="__URL__/statisticsmaintenancedetail?case=<?php echo $_SESSION["case"];?>&year=<?php echo ($year); ?>&month=<?php echo ($month); ?>&maintype=<?php echo ($item["mt"]); ?>"><?php echo ($item["rt"]); ?></a></td>
				<td><?php echo ($item["rb"]); ?></td><?php endif; ?>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</body>
</html>