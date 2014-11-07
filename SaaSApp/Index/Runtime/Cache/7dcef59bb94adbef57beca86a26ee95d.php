<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>物業資源決策系統</title>



<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.json-2.3.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
	$(function() {
		$("dt input[type=checkbox]").change(function() {
			$(this).parent().next().find("input[type=checkbox]").attr('checked', $(this).attr('checked') == 'checked');
		});
	});
	var rms=new Array();
	function check() {
		//根据div里面的dt dd de查找

		$("dl").each(function(i) {
			$(this).find("div").each(function(j) {
				//主菜单
				var mmc = $(this).find("dt input[type=checkbox]")[0];
				// 				alert(mmc);
				if (mmc['checked'] == true) {
					var mm = new Object();
					mm.mi = mmc.value;
					mm.ext = null;
					//主菜单权限
					var exts = new Array();
					var selector = "#ext"+mmc.value+" input[type=checkbox]:checked";
					$(this).find(selector).each(function(x) {
						exts.push($(this).val());
					});
					mm.ext=exts.length == 0 ? null : exts.join(',');

					rms.push(mm);
					//子菜单
					$(this).find("dd input[type=checkbox]:checked ").each(function(k) {
						if ($(this).attr('menu')) {
							var exts = new Array();
							var selector = "#ext"+$(this).val()+" input[type=checkbox]:checked";
							$(this).parent().find(selector).each(function(x) {
								exts.push($(this).val());
							});
							rms.push({
								'mi' : $(this).val(),
								'ext' : exts.length == 0 ? null : exts.join(',')
							});
						}

					});

				}
			});
		});
		$("#menus").val($.toJSON(rms));
		//alert($("#menus").val());
		return window.validator.empty("name", "請輸入組別名稱") && window.validator.length("請選擇功能權限");
	}
</script>
</head>
<body>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/basic.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/calendar.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/<?php echo $_SESSION["style"];?>/css/nav-h.css" />
<div class="top">
	<div class="top_tempcolor">
		<a href="__APP__/Index/ChangeStyle?style=blue"
			class="color1 select"></a><a
			href="__APP__/Index/ChangeStyle?style=red"
			class="color2"></a><a
			href="__APP__/Index/ChangeStyle?style=green"
			class="color3"></a>
	</div>
	<div class="top_id">
		您好，<?php echo $_SESSION["SESSION_USER"]["name"];?> ! <a href="__APP__/Index/logout"><strong>登出</strong></a>
		<a href="__APP__/Work/index">回首頁</a>
	</div>
</div>



	<div class="webPage">
		<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<div class="sideLeft">
	<div>
		<a href="__APP__/User/profile"> <img src="__PUBLIC__/<?php if(empty($_SESSION['SESSION_USER']['userimage'])) echo 'images/3_03.jpg';  else echo 'Uploads/'.$_SESSION['SESSION_USER']['userimage']; ?>" alt="" width="151" border="0" />
		</a>
	</div>
	<div class="name">
		<a href="__APP__/User/Profile"><?php echo $_SESSION['SESSION_USER']['name'] ?></a>
	</div>
	<div id="divdate">
		<script>
			WdatePicker({
				eCont : "divdate",
				skin:"twoer",
				onpicked : function(dp) {
					window.top.location.href='__APP__/Work/index?date=' + dp.cal.getDateStr();
				}
			})
		</script>
	</div>
	<div class="menuSide">
		<ul>
			<?php if(is_array($LeftMenu)): $i = 0; $__LIST__ = $LeftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(empty($item["children"])): ?><?php if($item["name"] == '提醒'): ?><li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?>(<?php echo $_SESSION["AWOKE_WORK"];?>)</a></li>
			<?php else: ?>
			<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a></li><?php endif; ?> <?php else: ?> <?php if($item["name"] == '專案管理'): ?><li><img src="__PUBLIC__/images/hire_me.png" alt="" width="23" height="23" /><a href="__APP__/Case/index">專案管理</a></li>
			<?php else: ?>
			<li><img src="<?php echo ($item["image"]); ?>" alt="" width="23" height="23" /><?php echo ($item["name"]); ?>
				<ul>
					<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><?php if($citem["name"] == '一般訊息'): ?><li><a href="__APP__/Msg/index">一般訊息</a>(<?php echo $_SESSION["MSG_COMM"];?>)</li>
					<?php elseif($citem["name"] == '我交辦事項'): ?>
					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_MINE_WORK']>0) echo '<font color="red">我交辦事項('.$_SESSION["MSG_MINE_WORK"].')</font>'; else echo '我交辦事項('.$_SESSION["MSG_MINE_WORK"].')'; ?></a></li>
					<?php elseif($citem["name"] == '他人交辦事項'): ?>
					<li><a href="__APP__/Msg/otherwork"><?php if($_SESSION['MSG_OTHER_WORK']>0) echo '<font color="red">他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')</font>'; else echo '他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')'; ?></a></li>
					<?php else: ?>
					<li><a href="<?php echo ($citem["link"]); ?>"><?php echo ($citem["name"]); ?></a></li><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul></li><?php endif; ?><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
			<!-- 			<li><img src="__PUBLIC__/images/icon_edit.gif" alt="" width="23" height="23" /><a href="__APP__/User/profile">編輯個人檔案</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/icon_mail.gif" alt="" width="23" height="23" />訊息 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Msg/index">一般訊息</a>(<?php echo $_SESSION["MSG_COMM"];?>)</li> -->
			<!-- 					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_MINE_WORK']>0) echo '<font color="red">我交辦事項('.$_SESSION["MSG_MINE_WORK"].')</font>'; else echo '我交辦事項('.$_SESSION["MSG_MINE_WORK"].')'; ?></a></li> -->
			<!-- 					<li><a href="__APP__/Msg/work"><?php if($_SESSION['MSG_OTHER_WORK']>0) echo '<font color="red">他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')</font>'; else echo '他人交辦事項('.$_SESSION["MSG_OTHER_WORK"].')'; ?></a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/icon_recommend.gif" alt="" width="23" height="23" /><a href="__APP__/Remind/index">提醒</a> (<?php echo $_SESSION["AWOKE_WORK"];?>)</li> -->
			<!-- 			<li><img src="__PUBLIC__/images/icon_friend.gif" alt="" width="23" height="23" /><a href="__APP__/User/friend">同事名單</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/company_32.png" alt="" width="23" height="23" />公司管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Company/edit?code=<?php echo $_SESSION["SESSION_USER"]["code"];?>">公司基本資料</a></li> -->
			<!-- 					<li><a href="__APP__/Depart/index">部門管理</a></li> -->
			<!-- 					<li><a href="__APP__/Team/index">組別管理</a></li> -->
			<!-- 					<li><a href="__APP__/Level/index">級別管理</a></li> -->
			<!-- 					<li><a href="__APP__/User/index">員工管理</a></li> -->
			<!-- 					<li><a href="__APP__/Limit/index">權限管理</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/document.png" alt="" width="23" height="23" /><a href="__APP__/Contract/index">合約管理</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/user_business_chart_32.png" alt="" width="23" height="23" /><a href="__APP__/Customer/index">客戶管理</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/page_text_chart_32.png" alt="" width="23" height="23" />業務管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Business/index">業務資料追蹤表</a></li> -->
			<!-- 					<li><a href="__APP__/Business/bid">業務報價管理</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/hire_me.png" alt="" width="23" height="23" /><a href="__APP__/Case/index">專案管理</a></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/pd_32.png" alt="" width="23" height="23" />商品管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Stock/productBigType">商品類別管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/product">商品列表</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/business_32.png" alt="" width="23" height="23" />廠商管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Stock/manufacturersType">廠商類別管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/manufacturers">廠商列表</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/stock.png" alt="" width="23" height="23" />進銷存管理 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Stock/stock">庫存管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/purchase">採購管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/stockCheck">驗貨管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/stockStorage">進貨管理</a></li> -->
			<!-- 					<li><a href="__APP__/Stock/stockChange">異動管理</a></li> -->
			<!-- 				</ul></li> -->
			<!-- 			<li><img src="__PUBLIC__/images/accounting.png" alt="" width="23" height="23" />會計系統 -->
			<!-- 				<ul> -->
			<!-- 					<li><a href="__APP__/Account/accountlist">常用帳號設定</a></li> -->
			<!-- 					<li><a href="__APP__/Account/subjectlist">科目設定</a></li> -->
			<!-- 					<li><a href="__APP__/Account/incomelist">收入管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/paylist">支付管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/billlist">傳票管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/caselist">專案管理</a></li> -->
			<!-- 					<li><a href="__APP__/Account/budgetlist">預算管理</a></li> -->
			<!-- 				</ul></li> -->
		</ul>
	</div>
</div>

		<div class="mainPage">
			<ul id="navmenu-h">
<?php if(is_array($TopMenu)): $i = 0; $__LIST__ = $TopMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(empty($item["children"])): ?><li><a href="<?php echo ($item["link"]); ?>"><?php echo ($item["name"]); ?></a></li>
			<?php else: ?>
			<li><a href="#"><?php echo ($item["name"]); ?></a>
				<ul>
					<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><li><a href="<?php echo ($citem["link"]); ?>"><?php echo ($citem["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					
				</ul></li><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
		<li><a href="__APP__/Favorite">我的最愛</a>  </li>
</ul>


			<div class="topic">權限管理</div>
			<div class="mainInfo">
				<form action="__URL__/insert" onsubmit="return check();" method="post" enctype="multipart/form-data" name="form1" id="form1">
					<div class="topic2">新增 / 修改組別</div>
					<input type="hidden"  id="menus" name="menus"/> 
					<input type="hidden"   name="code" value="<?php echo $_SESSION["SESSION_USER"]["code"];?>"/> 
					<input type="hidden" name="id" value="<?php echo ($role["id"]); ?>" id="id" /> 
					<table width="695" border="0" align="center" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th width="110" scope="row">組別名稱</th>
							<td width="582"> 
							 <input type="text" name="name" id="name" value="<?php echo ($role["name"]); ?>" /></td>
						</tr>
						<tr>
							<th width="110" scope="row">排序</th>
							<td width="582"> 
							 <input type="text" name="ordernumber" id="ordernumber" value="<?php echo ($role["ordernumber"]); ?>" /></td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tabThSide">
						<tr>
							<th colspan="2" scope="col">權限設定</th>
						</tr>
						<tr>
							<td width="48%" valign="top">
								<div class="txt_green">
									<strong>基本功能權限設定</strong>
								</div>
								<dl style="margin-top: 10px">
									<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($item["type"] == 0): ?><div>
										<dt>
											<?php if(in_array(($item["id"]), is_array($rm)?$rm:explode(',',$rm))): ?><input type="checkbox"  checked="checked" value="<?php echo ($item["id"]); ?>" menu="true" /> <?php else: ?>
											  <input type="checkbox"   value="<?php echo ($item["id"]); ?>" menu="true" /><?php endif; ?>
											<?php echo ($item["name"]); ?>
											<?php if(!empty($item["ext"])): ?>( <label id="ext<?php echo ($item["id"]); ?>">
											<?php $_result=explode(',',$item['ext']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ext): ++$i;$mod = ($i % 2 )?><?php 
												$hasExt=false;
												foreach($exts as $key=>$val)
												{
													if($val['id']===$item['id'])
													{
														if(count(explode(trim($ext),trim($val['ext']) ))>1)
															echo '<input type="checkbox" checked="checked"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
														else
															echo '<input type="checkbox"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
														$hasExt=true;
													}
												}
												if($hasExt==false)
												{
													echo '<input type="checkbox"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
												}
												$hasExt=false;
												?><?php endforeach; endif; else: echo "" ;endif; ?></label>)<?php endif; ?> <?php echo ($item["endtag"]); ?>
										</dt>
										<?php if(!empty($item["children"])): ?><dd>
											<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><?php if(in_array(($citem["id"]), is_array($rm)?$rm:explode(',',$rm))): ?><input type="checkbox"  checked="checked" value="<?php echo ($citem["id"]); ?>" menu="true" /> <?php else: ?>
											  <input type="checkbox"   value="<?php echo ($citem["id"]); ?>" menu="true" /><?php endif; ?> <?php echo ($citem["name"]); ?> 
										
											<?php if(!empty($citem["ext"])): ?>( <label id="ext<?php echo ($citem["id"]); ?>">
											<?php $_result=explode(',',$citem['ext']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ext): ++$i;$mod = ($i % 2 )?><?php 
												$hasExt=false;
												foreach($exts as $key=>$val)
												{
													
													if($val['id']===$citem['id'])
													{
														if(count(explode(trim($ext),trim($val['ext']) ))>1)
															echo '<input type="checkbox" checked="checked"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
														else
															echo '<input type="checkbox"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
														$hasExt=true;
													}
												}
												if($hasExt==false)
												{
													echo '<input type="checkbox"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
												}
												$hasExt=false;
												?><?php endforeach; endif; else: echo "" ;endif; ?></label>)<?php endif; ?> <?php echo ($citem["endtag"]); ?><?php endforeach; endif; else: echo "" ;endif; ?>
										</dd><?php endif; ?></div><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
								</dl>
							</td>
							<td width="52%" valign="top">
								<div class="txt_green">
									<strong>專案權限設定</strong>
								</div>
								<dl style="margin-top: 10px">
									<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if($item["type"] == 1): ?><div>
										<dt>
											<?php if(in_array(($item["id"]), is_array($rm)?$rm:explode(',',$rm))): ?><input type="checkbox"  checked="checked" value="<?php echo ($item["id"]); ?>" /> <?php else: ?>
											  <input type="checkbox"   value="<?php echo ($item["id"]); ?>" /><?php endif; ?>
											<?php echo ($item["name"]); ?>
										</dt>
										<?php if(!empty($item["children"])): ?><dd>
											<?php if(is_array($item["children"])): $i = 0; $__LIST__ = $item["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$citem): ++$i;$mod = ($i % 2 )?><?php if(in_array(($citem["id"]), is_array($rm)?$rm:explode(',',$rm))): ?><input type="checkbox"  checked="checked" value="<?php echo ($citem["id"]); ?>" menu="true" /> <?php else: ?>
											  <input type="checkbox"   value="<?php echo ($citem["id"]); ?>" menu="true" /><?php endif; ?> <?php echo ($citem["name"]); ?> 
										
											<?php if(!empty($citem["ext"])): ?>( <label id="ext<?php echo ($citem["id"]); ?>">
											<?php $_result=explode(',',$citem['ext']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ext): ++$i;$mod = ($i % 2 )?><?php 
												$hasExt=false;
												foreach($exts as $key=>$val)
												{
													
													if($val['id']===$citem['id'])
													{
														if(count(explode(trim($ext),trim($val['ext']) ))>1)
															echo '<input type="checkbox" checked="checked"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
														else
															echo '<input type="checkbox"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
														$hasExt=true;
													}
												}
												if($hasExt==false)
												{
													echo '<input type="checkbox"  value="'.$ext.'" />&nbsp;'.$ext.'&nbsp;';
												}
												$hasExt=false;
												?><?php endforeach; endif; else: echo "" ;endif; ?></label>)<?php endif; ?> <?php echo ($citem["endtag"]); ?><?php endforeach; endif; else: echo "" ;endif; ?>
										</dd><?php endif; ?></div><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
								</dl>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" valign="top">
							<input type="submit" name="Submit" value="確定" /> <input type="reset" name="Submit2" value="取消" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="foot">©2011 HO-HSIN ELECTRICITY MACHINERY. All Rights reserved.</div>

</body>
</html>