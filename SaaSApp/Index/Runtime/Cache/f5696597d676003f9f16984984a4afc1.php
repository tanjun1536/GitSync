<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工程報價單</title>
<style type="text/css">
<!--
body {
	font-size: 15px;
	margin: 0px;
	padding: 0px;
	font-family: Arial, Helvetica, sans-serif;
}

.title {
	display: block;
	margin: 0px auto;
	padding: 0px;
	width: 950px;
	text-align: center;
}

.title h1 {
	font-size: 24px;
}

.title p {
	margin: 0px 0px 6px;
}

.top {
	display: block;
	margin: 0px auto;
	width: 950px;
	font-size: 15px;
	line-height: 22px;
}

.top h1 {
	text-align: center;
	letter-spacing: 20px;
}

.top .tab1 {
	border-bottom-width: 3px;
	border-bottom-style: double;
	border-bottom-color: #666666;
}

.top .tab1 th {
	padding: 4px;
}

.top .tab1 td {
	padding: 4px;
}

.main {
	margin: 0px auto;
	padding: 0px;
	width: 950px;
}

.tab2 {
	background-color: #000000;
}

.tab2 th {
	background-color: #FFFFFF;
	padding: 4px 2px;
}

.tab2 td {
	background-color: #FFFFFF;
	padding: 4px 2px;
}
-->
</style>
</head>

<body>
	<div class="title">
		<h1>和新機電管理股份有限公司</h1>
		<div>
			<p>HO-SHIN ELECTRICITY MACHINERY CO.,LTD</p>
			<p>地址：台北市中山區明水路593號B1F</p>
			<p>TEL：02-25327050 FAX：02-85091370</p>
		</div>
	</div>
	<div class="top">
		<h1>報 價 單</h1>
		<table width="950" border="0" cellpadding="0" cellspacing="0"
			class="tab1">
			<tr>
				<th width="98" align="right" scope="row">等 級：</th>
				<td width="377"><input type="checkbox" name="checkbox"
					value="checkbox" /> A <input type="checkbox" name="checkbox2"
					value="checkbox" /> B <input type="checkbox" name="checkbox3"
					value="checkbox" /> C <input type="checkbox" name="checkbox4"
					value="checkbox" /> D <input type="checkbox" name="checkbox5"
					value="checkbox" /> E</td>
				<th width="133" align="right" scope="row">報價單日期：</th>
				<td width="342"><?php echo (formatDate($price["pricedate"])); ?></td>
			</tr>
			<tr>
				<th align="right" scope="row">分 項：</th>
				<td><input type="checkbox" name="checkbox8" value="checkbox" />
					急件 <input type="checkbox" name="checkbox7" value="checkbox" /> 速件
					<input type="checkbox" name="checkbox6" value="checkbox" /> 普通</td>
				<th align="right" scope="row">報價單單號：</th>
				<td><?php echo ($price["pricecode"]); ?></td>
			</tr>
		</table>
		<table width="950" border="0" cellpadding="0" cellspacing="0"
			class="tab1">
			<tr>
				<th width="98" align="right" scope="row">客戶名稱：</th>
				<td width="376"><?php echo ($price["clientname"]); ?></td>
				<th width="133" align="right" scope="row">客戶電話：</th>
				<td width="343"><?php echo ($price["clientphone"]); ?></td>
			</tr>
			<tr>
				<th align="right" scope="row">客戶地址：</th>
				<td><?php echo ($price["clientprovincename"]); ?><?php echo ($price["clientcityname"]); ?><?php echo ($price["clientaddress"]); ?></td>
				<th align="right" scope="row">客戶傳真：</th>
				<td><?php echo ($price["clientfax"]); ?></td>
			</tr>
			<tr>
				<th align="right" scope="row">統一編號：</th>
				<td><?php echo ($price["clientcode"]); ?></td>
				<th align="right" scope="row">(送貨)工程地點：</th>
				<td><?php echo ($price["projectprovincename"]); ?><?php echo ($price["projectcityname"]); ?><?php echo ($price["projectaddress"]); ?></td>
			</tr>
			<tr>
				<th align="right" scope="row">聯絡人：</th>
				<td><?php echo ($price["linker"]); ?></td>
				<th align="right" scope="row">工程名稱：</th>
				<td><?php echo ($price["projectname"]); ?></td>
			</tr>
		</table>
		<div style="margin: 10px 0px">
			＊本報價單有效期限為30天。<br /> ＊本報價單經業方確認同意後請簽名或蓋章回覆。<br /> ＊付款方式：<br />
			1.本報價單貨到後，月底結帳一次付清，支票以7天票期為限。<br />
			2.本報價單工程完工驗收後，月底結帳一次付清，支票以7天票期為限。
		</div>
	</div>
	<div class="main">
		<table width="950" border="0" cellpadding="0" cellspacing="1"
			class="tab2">
			<tr>
				<th width="40" scope="col">項次</th>
				<th width="439" scope="col">品名/項目</th>
				<th width="47" scope="col">數量</th>
				<th width="57" scope="col">單位</th>
				<th width="86" scope="col">單價</th>
				<th width="82" scope="col">複價</th>
				<th width="191" scope="col">備註/規格</th>
			</tr>
			<?php if(is_array($details)): $i = 0; $__LIST__ = $details;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr>
				<?php else: ?>
				<tr class="trcolor"><?php endif; ?>
			<td align="center"><?php echo ($i); ?></td>
			<td><?php echo ($item["productname"]); ?></td>
			<td align="center"><?php echo ($item["productquantity"]); ?></td>
			<td align="center"><?php echo ($item["productunit"]); ?></td>
			<td align="center"><?php echo ($item["productprice"]); ?></td>
			<td align="center"><?php echo ($item["productfj"]); ?></td>
			<td align="center"><?php echo ($item["remark"]); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			<tr>
				<td colspan="7" align="center"><strong>(以下空白)</strong></td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right"><strong>合計</strong></td>
				<td>$<?php echo ($price["total"]); ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right"><strong>稅(5%)</strong></td>
				<td>$<?php echo ($price["taxprice"]); ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right"><strong>總計</strong></td>
				<td>$<?php echo ($price["totalprice"]); ?></td>
				<td>(含稅)</td>
			</tr>
			<tr>
				<td align="center"><strong>備註</strong></td>
				<td colspan="6"><?php echo ($price["priceremark"]); ?></td>
			</tr>
		</table>
		<table width="950" border="0" cellpadding="0" cellspacing="2"
			class="tab2">
			<tr>
				<th scope="col">客戶確認簽章欄</th>
				<th scope="col">和新機電報價章</th>
				<th scope="col">承辦業務</th>
			</tr>
			<tr>
				<td height="150">&nbsp;</td>
				<td>&nbsp;</td>
				<td valign="top"><p>承辦人：<?php echo ($price["undertakername"]); ?></p>
					<p>聯絡電話：<?php echo ($price["phone"]); ?></p>
					<p>E-MAIL：<?php echo ($price["email"]); ?></p></td>
			</tr>
		</table>
		<div>
			<p>
				<strong>BU單位：</strong><?php echo ($price["BUunitName"]); ?>
			</p>
		</div>
	</div>
</body>
</html>