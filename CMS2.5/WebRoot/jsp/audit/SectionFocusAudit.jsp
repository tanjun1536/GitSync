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
	<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="javascript/lhgdialog/lhgcore.lhgdialog.min.js"></script>
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
			var urls = ["SectionFocusAuditAction!auditNext.action", "SectionFocusAuditAction!reject.action"];
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
			<input type="hidden" name="id" value="${focus.id }"/>
			<div class="formdiv">
				<ol>
					<li>
						<label for="" class="label">
							栏目:
						</label>
						<input id="section.parent.id" disabled="disabled" value="${focus.section.name }" autofocus style="width: 202px"/>
					</li>
					<li>
						<label for="" class="label">
							标题:
						</label>
						<input id="title" type="text" disabled="disabled" style="font-size: 22px; font-weight: 600; width: 570px" required="true" value="${focus.title }"/>
					</li>
					<li>
						<label for="" class="label">
							焦点图片:
						</label>
						<img src="${focus.imagePath }"/>
					</li>
					<li>
						<label for="" class="label">
							外链地址:
						</label>
						<input id="artTitle" type="text" value="${focus.linkAddress}" style="width: 570px" disabled="disabled"/>
					</li>
					<li>
						<label for="" class="label">
							关联文章:
						</label>
						<input id="artTitle" type="text" value="${focus.article.title}" style="width: 570px" disabled="disabled"/>
					</li>
					<li>
						<label for="" class="label">
							焦点描述:
						</label>
						<textarea id="focus.content"disabled="disabled" rows="8" style="width: 570px; font-size: 14px">${focus.content}</textarea>
					</li>
<!--					<li>-->
<!--						<label for="" class="label">-->
<!--							焦点描述:-->
<!--						</label>-->
<!--						<textarea disabled="disabled" style="width: 570px" required="true">${imgContent.summary }</textarea>-->
<!--					</li>-->
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
				<input type="hidden" name="id" value="${focus.id }"/>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							栏目:
						</td>
						<td>
							<input id="section.parent.id" disabled="disabled" value="${focus.section.name }"/>
						</td>
					</tr>
					<tr>
						<td>
							标题:
						</td>
						<td>
							<input id="title" type="text" disabled="disabled" style="width: 200px" required="true" value="${focus.title }"/>
						</td>
					</tr>
					<tr>
						<td>
							焦点图片:
						</td>
						<td>
							<img src="${focus.imagePath }"/>
						</td>
					</tr>
					<tr>
						<td>
							关联文章内容:
						</td>
						<td>
							<input id="c" type="checkbox" disabled="disabled" ${focus.article ne null?'checked':'' }>
						</td>
					</tr>
					<tr id="art" style="display: ${focus.article ne null?'block':'none' }">
						<td>
							关联文章:
						</td>
						<td>
							 <input id="artTitle" type="text" value="${focus.article.title}" disabled="disabled"/>
						</td>
					</tr>
					<tr id="con" style="display: ${focus.article ne null?'none':'block' }">
						<td>
							内容:
						</td>
						<td>
							<textarea id="focus.content"disabled="disabled">${focus.content}</textarea>
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
							<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/audit/SectionFocusAuditList.jsp')" value="返回">
						</td>
					</tr>
				</table>
			</form>
		</center>
		--%>
	</body>
</html>
