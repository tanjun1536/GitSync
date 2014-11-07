<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
	response.setHeader("Pragma", "No-cache");
	response.setHeader("Cache-Control", "no-cache");
	response.setDateHeader("Expires", 0);
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<title>i南充内容发布管理平台</title>
		<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/xheditor.css" rel="stylesheet" type="text/css" />
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
</script>

	</head>
	<body>
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：系统管理 > 发布新版本
		</div>
		<div class="clear"></div>
		</header>
		<form action="VersionAction!save.action" id="frm" method="post" enctype="multipart/form-data">
			<input type="hidden" value="${version.id }" name="version.id">
			<div class="formdiv">

				<ol>
					<li>
						<label class="label">
							系统平台:
						</label>
						<select id="version.equType" name="version.equType">
						<c:choose>
							<c:when test="${version.equType =='iphone' }"><option value="iphone" selected="selected">iphone</option></c:when>
							<c:otherwise><option value="iphone">iphone</option></c:otherwise>
						</c:choose>
						<c:choose>
							<c:when test="${version.equType =='ipad' }"><option value="ipad" selected="selected">ipad</option></c:when>
							<c:otherwise><option value="ipad">ipad</option></c:otherwise>
						</c:choose>
						<c:choose>
							<c:when test="${version.equType =='androidphone' }"><option value="androidphone" selected="selected">androidphone</option></c:when>
							<c:otherwise><option value="androidphone">androidphone</option></c:otherwise>
						</c:choose>
						<c:choose>
							<c:when test="${version.equType =='androidpad' }"><option value="androidpad" selected="selected">androidpad</option></c:when>
							<c:otherwise><option value="androidpad">androidpad</option></c:otherwise>
						</c:choose>
						</select>
					</li>
					<li>
						<label class="label">
							版本名称:
						</label>
						<input id="version.name" name="version.name" type="text" value="${version.name}"  style="width: 200px;">
					</li>
					<li>
						<label class="label">
							版本代号:
						</label>
						<input id="version.name" name="version.version" type="text"  value="${version.version}"   style="width: 200px;">
					</li>
					<li>
						<label class="label">
							版本描述:
						</label>
						<textarea id="version.description" name="version.description" rows="5" cols="" style="width: 200px;">${version.description}</textarea>
					</li>
					<li>
						<label  class="label">
							程序文件:
						</label>
						<input id="version.downUrl" name="version.downUrl" type="hidden"  value="${version.downUrl}" >
						<input id="apkFile" name="apkFile"  type="file" value="version.downUrl" style="width: 200px;" >
						<c:if test="${version!=null && version.downUrl!=''}"><a href="${version.downUrl}">[已上传文件]</a></c:if>
					</li>
					
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="window.fn.openURL('jsp/version/VersionList.jsp');" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
	</body>
</html>
