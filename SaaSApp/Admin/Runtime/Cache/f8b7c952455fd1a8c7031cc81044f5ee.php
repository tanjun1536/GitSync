<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業管理系統 後台管理</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/basic.css" />
</head>

<body>
	<div class="webpage">

		<div class="top">
  <div class="top_logo">
    <h1>物業管理系統　後台管理</h1>
  </div>
</div>
  <div class="text_signin">顯示帳號，您好!　<a href="__APP__/Index/logout">登出</a></div>

		<table width="980" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="180" valign="top" bgcolor="#FFFFFF"><div class="menu">
  <ul>
    <li>公司管理
        <ul>
          <li><a href="__APP__/Company/index">公司列表</a></li>
          <li><a href="__APP__/Company/add">新增公司</a></li>
        </ul>
    </li>
  </ul>
</div>

</td>
				<td width="800" valign="top"><div class="mainPage">
						<div class="topic">公司列表</div>
						<form id="form1" name="form1" method="post" action="">
							<div class="search">
								<input name="textfield" type="text" value="輸入公司名稱" /> 狀態： <select name="select">
									<option value="所有狀態">所有狀態</option>
									<option value="正常">正常</option>
									<option value="過期">過期</option>
									<option value="封鎖">封鎖</option>
								</select> <input type="submit" name="Submit" value="搜尋" />
							</div>
						</form>
						<div>
							<table width="800" border="0" cellpadding="0" cellspacing="1" class="tab_basic">
								<tr>
									<th scope="col">公司名稱</th>
									<th scope="col">聯絡人</th>
									<th scope="col">聯絡人電話</th>
									<th scope="col">可建帳號數</th>
									<th scope="col">使用期限</th>
									<th scope="col">狀態</th>
									<th scope="col">操作</th>
								</tr>
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($i%2 == 1): ?><tr class="trcolor1">
									<?php else: ?>
									<tr class="trcolor2"><?php endif; ?>
								<tr class="trcolor1">
									<td><?php echo ($item["name"]); ?></td>
									<td align="center"><?php echo ($item["linker"]); ?></td>
									<td align="center"><?php echo ($item["phone"]); ?></td>
									<td align="center"><?php echo ($item["usercount"]); ?></td>
									<td align="center"><?php echo (date('Y/n/d',strtotime($item["period"]))); ?></td>
									<td align="center"><?php echo ($item["state"]); ?></td>
									<td align="center"><a href="__URL__/edit?id=<?php echo ($item["id"]); ?>">修改</a>| <a onclick="return confirm('確認要刪除選擇的數據?');" href="__URL__/delete?id=<?php echo ($item["id"]); ?>">刪除</a> | <a href="__URL__/close?id=<?php echo ($item["id"]); ?>">封鎖</a></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</table>
						</div>
					</div></td>
			</tr>
		</table>
		<div class="foot">台灣達奈股份有限公司　版權所有</div>


	</div>
</body>
</html>