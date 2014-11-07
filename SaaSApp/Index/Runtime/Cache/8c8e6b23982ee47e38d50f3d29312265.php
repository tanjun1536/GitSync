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
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="201" height="22">和新機電管理股份有限公司</td>
    <td width="314" rowspan="3" align="center"><h1><?php echo ($typename); ?></h1></td>
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
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="61" height="22">廠商名稱：</td>
    <td width="269"><?php echo ($obj["mname"]); ?></td>
    <td width="62">廠商統編：</td>
    <td width="136"><?php echo ($obj["mcode"]); ?></td>
    <td width="61">單位名稱：</td>
    <td width="69"><?php echo ($obj["unit1"]); ?></td>
    <td width="61">貨單日期：</td>
    <td width="81"><?php echo ($date); ?></td>
  </tr>
  <tr>
    <td height="22">廠商地址：</td>
    <td><?php echo ($obj["provName"]); ?><?php echo ($obj["cityName"]); ?><?php echo ($obj["maddress"]); ?></td>
    <td>廠商電話：</td>
    <td><?php echo ($obj["linkerphone1"]); ?></td>
    <td>聯絡人：</td>
    <td><?php echo ($obj["linker1"]); ?></td>
    <td>出貨單號：</td>
    <td><?php echo ($code); ?></td>
  </tr>
  <tr>
    <td height="22">送貨案場：</td>
    <td><?php echo ($obj["maddress"]); ?></td>
    <td>廠商傳真：</td>
    <td><?php echo ($obj["mfax"]); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>發票號碼：</td>
    <td><?php echo ($sc["billcode"]); ?></td>
  </tr>
  <tr>
    <td height="22">送貨地址：</td>
    <td><?php echo ($obj["invoiceprovName"]); ?><?php echo ($obj["invoicecityName"]); ?><?php echo ($obj["invoiceaddress"]); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="800" border="0" cellpadding="0" cellspacing="0" class="tab_pdlist">
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
			<td colspan="8" rowspan="3" align="center" class="tdline"><table
					width="100%" border="0" cellspacing="0" cellpadding="0"
					style="margin: 0; border: none">
					<tr>
						<td width="10%">發票類型：</td>
						<td><?php echo ($sc["billtype"]); ?></td>
						<td width="11%">合計金額：</td>
					</tr>
					<tr>
						<td>付款方式：</td>
						<td><?php echo ($sc["paymethod"]); ?></td>
						<td>營業稅5%：</td>
					</tr>
					<tr>
						<td>送貨方式：</td>
						<td><?php echo ($sc["delivermethod"]); ?></td>
						<td>總計金額：</td>
					</tr>
				</table></td>
			<td class="tdline"><?php echo ($totalmoney); ?></td>
			<td class="tdline">&nbsp;</td>
			<td class="tdline">&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo ($taxmoney); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo ($allmoney); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<td colspan="2" class="tdline">備註說明：</td>
		<td colspan="9" class="tdline"><?php echo ($sc["remark"]); ?></td>
		</tr>
	</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="border:none; margin-top:15px">
  <tr>
    <td width="37">製表： </td>
    <td width="113">呂宜穎 </td>
    <td width="37">倉庫： </td>
    <td width="113">陳升豪 </td>
    <td width="39">司機： </td>
    <td width="111">蔡俊賢 </td>
    <td width="38">會計： </td>
    <td width="112">林晏芬 </td>
    <td width="67">客戶簽收： </td>
    <td width="133">方大同 </td>
  </tr>
</table>
</body>
</html>