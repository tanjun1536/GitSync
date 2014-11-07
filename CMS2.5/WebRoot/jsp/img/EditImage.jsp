<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css">
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
	function onSubmitForm() {
		if ($.trim($("#imgName").val()) == "") {
			alert("请填写图片名称");
			return false;
		}
		return true;
	}
</script>
	</head>

	<body>
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 图片管理
		</div>
		<div class="clear"></div>
		</header>
		<!--编辑弹出-->
		<form name="form1" target="_self" action="ImageInfoAction!update.action" method="post" onsubmit="return onSubmitForm();">
			<input type="hidden" name="imgInfo.id" value="${imgInfo.id }" />
			<div class="tip_abox">
				<h3>
					栏目名称：${imgInfo.section.text }
				</h3>
				<img src="${imgInfo.path }" />
				<ul>
					<li>
						<label>
							图片名称：
						</label>
						<input id="imgName" type="text" name="imgInfo.name" value="${imgInfo.name }" style="font-size: 16px; font-weight: 400; width: 500px" />
					</li>
					<li>
						<label>
							图片说明：
						</label>
						<textarea name="imgInfo.des"  rows="3" style="width: 502px">${imgInfo.des }</textarea>
					</li>
					<li>
						<label>
							图片排序：
						</label>
						<input type="text" name="imgInfo.sort" required="true" value="${imgInfo.sort }" style="font-size: 18px; font-weight: 400; width: 140px">
					</li>
				</ul>
			</div>
			<div class="clear">
			</div>
			<div class="tip_abtom">
				<input type="submit" value="保存" class="btn" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" />
				<input type="button" value="返回" onclick="history.go(-1)" class="btn" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" />
			</div>
		</form>
	</body>
</html>
