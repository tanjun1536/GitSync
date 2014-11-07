<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
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
		<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
		<script src="javascript/finder.js" type="text/javascript"></script>
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<!-- ckfinder-->
		<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
		<script type="text/javascript">
	$(function() {
		$("#section\\.parent\\.id").combotree('setValue', ${section.parent.id==null?1:section.parent.id});
	});
	function onMobileTitleImageSelected(data)
		{
			$("#section\\.mobileTitleImage").val(data.path);
			$("#mobileTitleImagePreview").attr("src",data.path);
		}
	function onPadTitleImageSelected(data)
		{
			$("#section\\.padTitleImage").val(data.path);
			$("#padTitleImagePreview").attr("src",data.path);
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
			当前位置：系统管理 > 添加/编辑栏目节点
		</div>
		<div class="clear"></div>
		</header>
		<form name="form1" enctype="multipart/form-data" action="SectionAction!save.action" method="post">
			<input type="hidden" name="section.id" id="section.id" value="${section.id }">

				<div class="formdiv">

					<ol>
						<li>
							<label class="label">
								上级栏目:
							</label>
							<input id="section.parent.id" name="section.parent.id" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
						</li>
						<li>
							<label class="label">
								栏目名称:
							</label>
							<input type="text" name="section.text" style="width: 200px" value="${section.text }" required="true">
						</li>
						<li>
							<label class="label">
								栏目分类:
							</label>
							<select name="section.sectionType.id" style="width: 200px">
								<c:forEach var="item" items="${types}">
									<c:choose>
										<c:when test="${section.sectionType.id==item.id }">
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
						</li>
						<li>
							<label class="label">
								是否显示:
							</label>
							<select name="section.shown" style="width: 200px">
								<c:choose>
									<c:when test="${section==null||section.shown==true }">
										<option value="true" selected="selected">
											是
										</option>
										<option value="false">
											否
										</option>
									</c:when>

									<c:otherwise>
										<option value="true">
											是
										</option>
										<option value="false" selected="selected">
											否
										</option>
									</c:otherwise>

								</c:choose>

							</select>
						</li>
						<li>
							<label class="label">
								评论是否需要审核:
							</label>
							<select name="section.commentAudit" style="width: 200px">
								<c:choose>
									<c:when test="${section==null||section.commentAudit==true }">
										<option value="true" selected="selected">
											是
										</option>
										<option value="false">
											否
										</option>
									</c:when>

									<c:otherwise>
										<option value="true">
											是
										</option>
										<option value="false" selected="selected">
											否
										</option>
									</c:otherwise>

								</c:choose>

							</select>
						</li>
						<li>
							<label class="label">
								适用终端:
							</label>
							<select name="section.adapterTerminal.id" style="width: 200px">
								<c:forEach var="item" items="${adapters}">
									<c:choose>
										<c:when test="${section.adapterTerminal.id==item.id }">
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
						</li>
						<li>
							<label class="label">
								展示类别:
							</label>
							<select name="section.showType.id" style="width: 200px">
								<c:forEach var="item" items="${showtypes}">
									<c:choose>
										<c:when test="${section.showType.id==item.id }">
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
						</li>
						<li>
							<label class="label">
								排列顺序:
							</label>
							<input type="text" name="section.orderNumber" style="width: 200px" value="${section.orderNumber}">
						</li>
						<li>
							<label class="label">
								是否热点:
							</label>
								<select name="section.isHot" style="width: 200px">
								<c:choose>
									<c:when test="${section==null||section.isHot==false }">
										<option value="true" >
											是
										</option>
										<option value="false" selected="selected">
											否
										</option>
									</c:when>

									<c:otherwise>
										<option value="true" selected="selected">
											是
										</option>
										<option value="false" >
											否
										</option>
									</c:otherwise>

								</c:choose>

							</select>
						</li>
						<li>
							<label class="label">
								手机图片:<br/><font color="blue">(100px*100px) </font>
							</label>
							<c:choose>
								<c:when test="${section==null||section.mobileTitleImage=='' }">
									<img src="images/img70_70.png" id="mobileTitleImagePreview" width="100" height="100" alt="焦点图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC"/>
								</c:when>
								<c:otherwise>
									<img src="${section.mobileTitleImage }" id="mobileTitleImagePreview" width="100" height="100" alt="焦点图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC"/>
								</c:otherwise>
							</c:choose>
							<input type="button" value="浏览图库" onclick="window.sector.open('images','#section\\.mobileTitleImage','#mobileTitleImagePreview')" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
							<input type="hidden" id="section.mobileTitleImage" name="section.mobileTitleImage" value="${section.mobileTitleImage }" />
						</li>
						<li>
							<label class="label">
								平板图片:<br/><font color="blue">(230px*180px) </font>
							</label>
							<c:choose>
								<c:when test="${section==null||section.padTitleImage=='' }">
									<img src="images/img230_180.png" id="padTitleImagePreview" width="230" height="180" alt="焦点图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC"/>
								</c:when>
								<c:otherwise>
									<img src="${section.padTitleImage }" id="padTitleImagePreview" width="230" height="180" alt="焦点图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC"/>
								</c:otherwise>
							</c:choose>
							<input type="button" value="浏览图库" onclick="window.sector.open('images','#section\\.padTitleImage','#padTitleImagePreview')" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
							<input type="hidden" id="section.padTitleImage" name="section.padTitleImage" value="${section.padTitleImage }" />
						</li>
					</ol>
					<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
						<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
						<input type="button" value="返回" onclick="fn.openURL('<%=basePath%>jsp/section/SectionList.jsp')" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					</div>
				</div>
		</form>
	</body>
</html>
