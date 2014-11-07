<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
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
		<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<!-- jquery easyui-->
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript" src="javascript/xheditor-1.1.13/xheditor-1.1.13-zh-cn.min.js"></script>
		<link href="css/xheditor.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script type="text/javascript">
		$(function(){init();});
			var urls = ["PadArticleAuditAction!auditNext.action", "PadArticleAuditAction!reject.action"];
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
				//编辑器
		var editor;
	function init() {
		var plugins = {
			
		};
		editor = $('#article\\.content').xheditor({
			plugins : plugins,
			tools : '',
			loadCSS : '<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>'}
			);
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
			当前位置：平板审核管理 > 内容审核
		</div>
		<div class="clear"></div>
		</header>
		<form id="auditForm" method="post" onsubmit="return onSubmit()">
			<input type="hidden" value="${article.id }" name="article.id">
			<div class="formdiv">
				<ol>
					<li>
						<label for="article.template.id" class="label">
							所属栏目：
						</label>
						<input id="article.section.id" value="${article.section.name }" disabled="disabled" required autofocus style="width: 202px">
					</li>
					<li>
						<label for="article.section.id" class="label">
							文章标题：
						</label>
						<input id="article.section.id" value="${fn:escapeXml(article.title)}" disabled="disabled" style="font-size: 22px; font-weight: 600; width: 570px" required>
					</li>
<!--					<li>-->
<!--						<label for="article.subTitle" class="label">-->
<!--							副标题：-->
<!--						</label>-->
<!--						<input id="article.subTitle" type="text" value="${article.subTitle }" disabled="disabled" style="font-size: 16px; font-weight: 600; width: 570px" required>-->
<!--					</li>-->
<!--					<li>-->
<!--						<label for="article.keywords" class="label">-->
<!--							文章关键词：-->
<!--						</label>-->
<!--						<input id="article.keywords" type="text" value="${article.keywords}" disabled="disabled" size="60" required>-->
<!--					</li>-->
					<li>
						<label for="article.summary" class="label">
							摘要：
						</label>
						<textarea id="article.summary" rows="5" cols="60" disabled="disabled" style="width: 570px" required>${article.summary}</textarea>
					</li>
					<li>
						<label for="article.content" class="label">
							正文内容：
						</label>
						<textarea id="article.content" rows="10" cols="80" disabled="disabled" readonly="readonly" style="width: 570px" required>${article.content}</textarea>
					</li>
					<li>
						<label for="article.source" class="label">
							内容来源：
						</label>
						<input id="article.source" type="text" value="${article.source }" disabled="disabled" style="width: 570px" required>
					</li>
					<li>
						<label for="titleImagePreview" class="label">
							标题图片：
						</label>
						<c:choose>
							<c:when test="${article==null||article.titleImage=='' }">
								<img src="images/defaultlist.png" id="titleImagePreview" width="70" height="70" alt="标题图片" />
							</c:when>
							<c:otherwise>
								<img src="${article.titleImage}" id="titleImagePreview" width="70" height="70" alt="标题图片" />
							</c:otherwise>
						</c:choose>
					</li>
<!--					<li>-->
<!--						<label for="" class="label">-->
<!--							热门文章：-->
<!--						</label>-->
<!--						<c:if test="${article==null }">-->
<!--							<input type="checkbox" value="true" disabled="disabled"/>-->
<!--						</c:if>-->
<!--						<c:if test="${article.isHot==false }">-->
<!--							<input type="checkbox" value="true" disabled="disabled"/>-->
<!--						</c:if>-->
<!--						<c:if test="${article.isHot==true }">-->
<!--							<input type="checkbox" checked="checked" value="true" disabled="disabled"/>-->
<!--						</c:if>-->
<!--					</li>-->
					<li>
						<label for="r" class="label">
							审核状态：
						</label>
						<label>通过<input id="r" type="radio" name="r" checked="checked" onclick="changeState()" /></label>
						<label>驳回<input type="radio" name="r" onclick="changeState()"/></label>
					</li>
					<li>
						<label for="r" class="label">
							退回原因:
						</label>
						<textarea id="reason" type="text" name="reason" readonly="readonly" style="width: 570px" required></textarea>
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="提交" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="window.fn.openURL('jsp/article/ArticleMobileList.jsp');" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
	</body>
</html>
