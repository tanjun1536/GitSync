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
			jQuery(function($) {
			  	<c:if test="${imgContent.section ne null}">
					$("#section\\.parent\\.id").combotree('setValue', ${imgContent.section.id});
				</c:if>
			}); 
			function onSubmit(){
				if($("#section\\.parent\\.id").combotree('getValue') == ''){
					alert("请选择栏目");
					return false;
				}
				if($("#imgs").find("tr").length <= 1){
					alert("请选择栏图片");
					return false;
				}
				return true;
			}
			
			function slectImg(){
				SelImg.show("onSelected");
			}
			
			function onSelected(img){
				$("#imgs").append("<tr><td><img src='" + img.path + "' width='150px' height='100px' /><button type='button' onClick='onDelete(this)'>删除</button><input type='hidden' name='paths' value='" + img.path + "' /></td><td><textarea name='descs' style='height:100px'></textarea></td></tr>");
			}
			
			function onDelete(btn){
				$(btn.parentNode.parentNode).remove();
			}
		</script>
		
	</head>
	<body>
		<center>
			<form name="form1" action="PadImageContentAction!update.action" method="post" onsubmit="return onSubmit()">
				<input type="hidden" name="imgContent.id" value="${imgContent.id }"/>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							栏目:
						</td>
						<td>
							<input id="section.parent.id" name="imgContent.section.id" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;"/>
						</td>
					</tr>
					<tr>
						<td>
							选择模版：${imgContent.template.id}
						</td>
						<td>
							<select id="article.template.id" name="imgContent.template.id">
								<c:forEach var="item" items="${templates }">
									<option value="${item.id }" ${imgContent.template.id eq item.id?'selected':'' }>
										${item.name }
									</option>
								</c:forEach>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							当前状态：
						</td>
						<td>
							正在编辑&nbsp;&nbsp;&nbsp;修改状态：
							<select id="focus.state.id" name="imgContent.state.id">
									<c:forEach var="item" items="${states }">
									<c:choose>
										<c:when test="${item.id==imgContent.state.id }">
											<option value="${item.id }" selected="selected">
												${item.name }
											</option>
										</c:when>
										<c:otherwise>
											<option value="${item.id }">
												${item.name }
											</option>
										</c:otherwise>
									</c:choose>
								</c:forEach>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							标题:
						</td>
						<td>
							<input type="text" name="imgContent.title" style="width: 200px" value="${imgContent.title }" required="true"/>
						</td>
					</tr>
					<tr>
						<td>
							副标题:
						</td>
						<td>
							<input type="text" name="imgContent.subTitle" style="width: 200px" value="${imgContent.subTitle }" required="true"/>
						</td>
					</tr>
					<tr>
						<td>
							关键字:
						</td>
						<td>
							<input type="text" name="imgContent.keywords" style="width: 200px" value="${imgContent.keywords }" required="true"/>
						</td>
					</tr>
					<tr>
						<td>
							来源:
						</td>
						<td>
							<input type="text" name="imgContent.source" value="${imgContent.source }" style="width: 200px" required="true"/>
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
									<tr><td><img src='${img.path}' width='150px' height='100px' /><button type='button' onClick='onDelete(this)'>删除</button><input type='hidden' name='paths' value='${img.path }' /></td><td><textarea name='descs' style='height:100px'>${img.des}</textarea></td></tr>
								</c:forEach>
							</table>
							<button type="button" onclick="slectImg()">添加图片</button>
						</td>
					</tr>
					<tr>
						<td>
							摘要:
						</td>
						<td>
							<textarea name="imgContent.summary" style="width: 200px" required="true">${imgContent.summary }</textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" id="btnSave" value="保存">
						</td>
						<td>
							<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/imgcontent/PadImageContentList.jsp')" value="返回">
						</td>
					</tr>
				</table>
			</form>
		</center>
	</body>
</html>
