<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
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
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<script type="text/javascript">
		
			var urls = ["MobileImageContentAuditAction!auditNext.action", "MobileImageContentAuditAction!reject.action"];
			function onSubmit(){
				if($("#r").attr("checked") == "checked"){
					$("#auditForm").attr("action", urls[0]);
				}
				else{
					$("#auditForm").attr("action", urls[1]);
				}
				return confirm("是否要提交？");
			}
			
			function changeState(){
				if($("#r").attr("checked") == "checked"){
					$("#reason").val("");
					$("#reason").attr("readonly", true);
				}
				else{
					$("#reason").attr("readonly", false);
				}
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
			当前位置：手机审核管理 > 内容审核
		</div>
		<div class="clear"></div>
		</header>
		<form id="auditForm" action="" method="post" onsubmit="return onSubmit()">
			<input type="hidden" name="id" value="${imgContent.id}"/>
			<div class="formdiv">
				<ol>
					<li>
						<label for="" class="label">
							栏目:
						</label>
						<input id="section.parent.id" disabled="disabled" value="${imgContent.section.name }" required autofocus style="width: 202px"/>
					</li>
					<li>
						<label for="" class="label">
							标题:
						</label>
						<input type="text" disabled="disabled" style="font-size: 22px; font-weight: 600; width: 570px" value="${imgContent.title }" required="true"/>
					</li>
					<li>
						<label for="" class="label">
							副标题:
						</label>
						<input type="text" disabled="disabled" value="${imgContent.subTitle }" style="font-size: 16px; font-weight: 600; width: 570px" required="true"/>
					</li>
					<li>
						<label for="" class="label">
							关键字:
						</label>
						<input type="text" disabled="disabled" size="60" value="${imgContent.keywords }" required="true"/>
					</li>
					<li>
						<label for="" class="label">
							来源:
						</label>
						<input type="text" disabled="disabled" value="${imgContent.source }" style="width: 570px" required="true"/>
					</li>
					<li>
						<label for="" class="label">
							图片:
						</label>
						<div style="display: inline;">
							<c:forEach items="${imgContent.images }" var="img">
								<img src='${img.path}' width='150px' height='100px' alt="${img.des}"/><!-- <textarea disabled="disabled" style='height:100px'>${img.des}</textarea> -->
							</c:forEach>
						</div>
					</li>
					<li>
						<label for="" class="label">
							摘要:
						</label>
						<textarea disabled="disabled" style="width: 570px" required="true">${imgContent.summary }</textarea>
					</li>
					<li>
						<label for="" class="label">
							审核状态:
						</label>
						<label>通过<input id="r" type="radio" name="r" checked="checked" onclick="changeState()" /></label>
						<label>驳回<input type="radio" name="r" onclick="changeState()"/></label>
					</li>
					<li>
						<label for="" class="label">
							退回原因:
						</label>
						<textarea id="reason" type="text" name="reason" readonly="readonly" style="width: 570px"></textarea>
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="提交" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="fn.openURL('<%=basePath%>jsp/audit/MobileImageContentAuditList.jsp')" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
		<%-- 
		<center>
			<form id="auditForm" action="" method="post" onsubmit="return onSubmit()">
			<input type="hidden" name="id" value="${imgContent.id}"/>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						栏目:
					</td>
					<td>
						<input id="section.parent.id" disabled="disabled" value="${imgContent.section.name }" style="width: 200px;"/>
					</td>
				</tr>
				<tr>
					<td>
						标题:
					</td>
					<td>
						<input type="text" disabled="disabled" style="width: 200px" value="${imgContent.title }" required="true"/>
					</td>
				</tr>
				<tr>
					<td>
						副标题:
					</td>
					<td>
						<input type="text" disabled="disabled" style="width: 200px" value="${imgContent.subTitle }" required="true"/>
					</td>
				</tr>
				<tr>
					<td>
						关键字:
					</td>
					<td>
						<input type="text" disabled="disabled" style="width: 200px" value="${imgContent.keywords }" required="true"/>
					</td>
				</tr>
				<tr>
					<td>
						来源:
					</td>
					<td>
						<input type="text" disabled="disabled" value="${imgContent.source }" style="width: 200px" required="true"/>
					</td>
				</tr>
				<tr>
					<td>
						图片:
					</td>
					<td>
						<table id="imgs">
							<tr><td>图片</td><td>描述</td></tr>
							<c:forEach items="${imgContent.images }" var="img">
								<tr><td><img src='${img.path}' width='150px' height='100px' /></td><td><textarea disabled="disabled" style='height:100px'>${img.des}</textarea></td></tr>
							</c:forEach>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						摘要:
					</td>
					<td>
						<textarea disabled="disabled" style="width: 200px" required="true">${imgContent.summary }</textarea>
					</td>
				</tr>
				<tr>
					<td><label>通过<input id="r" type="radio" name="r" checked="checked" onclick="changeState()" /></label></td>
					<td><label>驳回<input type="radio" name="r" onclick="changeState()"/></label></td>
				</tr>
				<tr>
					<td>
						退回原因:
					</td>
					<td>
						<textarea id="reason" type="text" name="reason" readonly="readonly" style="width: 200px"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" id="btnSave" value="提交">
					</td>
					<td>
						<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/audit/MobileImageContentAuditList.jsp')" value="返回">
					</td>
				</tr>
			</table>
			</form>
		</center>
		--%>
	</body>
</html>
