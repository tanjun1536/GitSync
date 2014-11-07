<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客戶出貨單</title>
<style type="text/css">
<!--
body {
	font-size: 12px;
}

table {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	margin-bottom: 5px;
	margin-top: 5px;
	margin-right: auto;
	margin-left: auto;
}

hr {
	width: 800px;
	display: block;
	margin: 2px auto;
	padding: 0px;
	color: #000000;
	font-size: 1px;
}

.tab_pdlist {
	width: 800px;
	line-height: 20px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}

.tab_pdlist th {
	font-weight: normal;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	text-align: left;
}

.tdline {
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: #000000;
}

.checkbox {
	border: 1px solid #000000;
	margin: 5px;
	height: 10px;
	width: 10px;
}
-->
</style>
</head>

<body>
	<table width="800" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<tr>
			<td width="193" height="22">和新機電管理股份有限公司</td>
			<td width="322" rowspan="3" align="center"><h1><?php echo ($typename); ?></h1></td>
			<td width="61">公司電話：</td>
			<td width="98">02-2532-7050</td>
			<td width="62">單位名稱：</td>
			<td width="64">耗材組</td>
		</tr>
		<tr>
			<td height="22">台北市中山區明水路593號B1F</td>
			<td>公司傳真：</td>
			<td>02-8509-8352</td>
			<td>業務：</td>
			<td>陳升豪</td>
		</tr>
		<tr>
			<td height="22">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>第1頁</td>
		</tr>
	</table>
	<table width="800" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<tr>
			<td width="67" height="22">倉庫代號：</td>
			<td width="733"><?php echo ($wh["stockcode"]); ?></td>
		</tr>
		<tr>
			<td height="22">倉庫名稱：</td>
			<td><?php echo ($wh["stockname"]); ?></td>
		</tr>
		<tr>
			<td height="22">倉庫類別：</td>
			<td><?php echo ($wh["type"]); ?></td>
		</tr>
	</table>

	<table width="800" border="0" cellpadding="0" cellspacing="0"
		class="tab_pdlist">
		<tr>
			<th width="27" scope="col"><div align="center">項次</div></th>
			<th width="68" scope="col">廠牌</th>
			<th width="168" scope="col">產品名稱</th>
			<th width="101" scope="col">產品規格/尺寸</th>
			<th width="112" scope="col">產品型號</th>
			<th width="48" scope="col">數量</th>
			<th width="46" scope="col">單位</th>
			<th width="48" scope="col">單價</th>
			<th width="57" scope="col">小計</th>
			<th width="52" scope="col">產地</th>
			<th width="73" scope="col">附註</th>
		</tr>
		<?php if(is_array($scd)): $i = 0; $__LIST__ = $scd;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
			<td align="center"><?php echo ($i); ?></td>
			<td><?php echo ($item["productcp"]); ?></td>
			<td><?php echo ($item["productname"]); ?></td>
			<td><?php echo ($item["productsize"]); ?></td>
			<td><?php echo ($item["productmodel"]); ?></td>
			<td><?php echo ($item["quantity"]); ?></td>
			<td><?php echo ($item["productunit"]); ?></td>
			<td><?php echo ($item["price"]); ?></td>
			<td><?php echo ($item["subtotal"]); ?></td>
			<td><?php echo ($item["productcd"]); ?></td>
			<td><?php echo ($item["remark"]); ?></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td colspan="2" class="tdline">備註說明：</td>
			<td colspan="9" class="tdline"><?php echo ($sc["remark"]); ?></td>
		</tr>
	</table>
	<table width="800" border="0" align="center" cellpadding="0"
		cellspacing="0" style="border: none; margin-top: 15px">
		<tr>
			<td width="40">製表：</td>
			<td width="359">呂宜穎</td>
			<td width="37">倉庫：</td>
			<td width="364">陳升豪</td>
		</tr>
	</table>
</body>
</html>