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
		function onSubmitForm(){
			if($("#imgfile").val() == ""){
				alert("请选择图片");
				return false;
			}
			if($.trim($("#imgName").val()) == ""){
				alert("请填写图片名称");
				return false;
			}
			return true;
		}
		
		function onSelectedFile(path){
			var pos=path.lastIndexOf("\\");
			if(pos>0)
			$("#imgName").val(path.substring(pos+1, path.lastIndexOf('.')));
			else
			
			$("#imgName").val(path.substring(0, path.lastIndexOf('.')));
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
			当前位置：采编管理 > 上传图片
		</div>
		<div class="clear"></div>
		</header>
		<form name="form1" enctype="multipart/form-data" action="ImageInfoAction!save.action" method="post" onsubmit="return onSubmitForm()">
			<input type="hidden" name="imgInfo.section.id" value="${imgInfo.section.id }" />
			<div class="formdiv">
				<ol>
					<li style="font-size: 14px; font-weight: 600">
						<label class="label">
							栏目名称:
						</label>
						${section.text }
					</li>
					<li style="font-size: 14px; font-weight: 600">
						<label class="label">
							图片:
						</label>
						<input id="imgfile" type="file" name="img" style="width: 208px" required="true" onchange="onSelectedFile(value)" />
					</li>
					<li style="font-size: 14px; font-weight: 600">
						<label class="label">
							图片名称:
						</label>
						<input id="imgName" type="text" name="imgInfo.name" style="font-size: 16px; font-weight: 400; width: 500px" required="true">
					</li>
					<li style="font-size: 14px; font-weight: 600">
						<label class="label">
							图片说明:
						</label>
						<textarea id="imgInfo.des" name="imgInfo.des" rows="3" style="width: 502px"></textarea>
					</li>
					<li style="font-size: 14px; font-weight: 600">
						<label class="label">
							图片排序:
						</label>
						<input type="text" name="imgInfo.sort" style="font-size: 18px; font-weight: 400; width: 140px" required="true">
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="history.go(-1)" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
	</body>
</html>
