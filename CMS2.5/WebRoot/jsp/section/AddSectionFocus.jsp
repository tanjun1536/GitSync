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
		<script type="text/javascript" src="javascript/lhgdialog/lhgcore.lhgdialog.min.js\?skin=mac"></script>
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
		<script src="javascript/finder.js" type="text/javascript"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
			var selectedSection;
			$(function(){
				$("#section\\.parent\\.id").combotree({
					onSelect:function(node){
						selectedSection = node;
					}
				});
			})
			
			function onSubmit(){
				if(selectedSection == null){
					alert('请选择栏目!');
					return false;
				}
//				if(selectedSection.id != 1 && selectedSection.target.innerHTML.indexOf("tree-file") == -1){
//					alert('只能对第一级和最后一级节点添加！');
//					return false;
//				}
				if($.trim($("#title").val()) == ""){
					alert('请填写标题！');
					return false;
				}
				return true;
			}
			
			function changeState(checkbox){
				if($(checkbox).attr("checked") == "checked"){
					$("#art").css("display", "block");
					$("#con").css("display", "none");
				}
				else{
					$("#art").css("display", "none");
					$("#con").css("display", "block");
				}
			}
			
			function selectArt(){
				if(selectedSection==null) {
					alert('请选择栏目!');return;
				}
				var selectedItem=new Object();
				$.dialog.data('selectedItem',selectedItem); 
				$.dialog({id:'SelArtID', title:"文章选择器", lock:true, width: '900px', height: '500px', content:("url:jsp/article/MobileArtList.jsp?sectionId=" + selectedSection.id),  
				button:[{name:"确定",  callback: function(){if(typeof selectedItem.id == "undefined"){alert("请选择一行"); return false;} onSelectedArt(selectedItem); return true;}}, {name:"关闭", focus:true}]});
			}
			
			function onSelectedArt(selectedItem){
				$("#focus\\.article\\.id").val(selectedItem.id);
				$("#artTitle").val(selectedItem.title);
			}
			
			function slectImg(){
				SelImg.show("onSelectedImage");
			}
			
			function onSelectedImage(img){
				$("#imgpath").val(img.path);
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
			当前位置：采编管理 > 手机栏目焦点发布
		</div>
		<div class="clear"></div>
		</header>

		<form name="form1" enctype="multipart/form-data" action="SectionFocusAction!save.action" method="post" onsubmit="return onSubmit()">
			<div class="formdiv">

				<ol>
					<li>
						<label class="label">
							选择栏目:
						</label>
						<input id="section.parent.id" name="focus.section.id" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 202px;" />
					</li>
					<li>
						<label class="label">
							焦点标题:
						</label>
						<input id="title" type="text" name="focus.title" style="width: 200px" required="true" />
					</li>
					<li>
						<label class="label">
							当前状态:
						</label>
						<select id="focus.state.id" name="focus.state.id">
							<c:forEach var="item" items="${states }">
								<c:choose>
									<c:when test="${item.id==focus.state.id }">
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
							焦点图片:
						</label>
						<input id="imgpath" name="focus.imagePath" type="text" value="" readonly="readonly" />
						<input type="button" onclick="window.sector.open('images','#imgpath','')" value="浏览图片" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
					</li>
					<li>
						<label class="label">
							外链地址:
						</label>
						<input id="linkAddress" type="text" name="focus.linkAddress" style="width: 200px" />
					</li>
<!--					<li>-->
<!--						<label class="label">-->
<!--							关联文章:-->
<!--						</label>-->
<!--						<input type="checkbox" onclick="changeState(this)">-->
<!--					</li>-->
<!--					<li id="art" style="display: none;">-->
					<li id="art" >
						<label class="label">
							关联文章:
						</label>
						<input id="focus.article.id" name="focus.article.id" value="-1" type="hidden" />
						<input id="artTitle" type="text" value="" readonly="readonly" />
						<input type="button" onclick="selectArt()" value="选择文章" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
					</li>
					</li>
					<li id="con" style="display: block;">
						<label class="label">
							焦点描述:
						</label>
						<textarea name="focus.content" onpropertychange="if(value.length>200) value=value.substr(0,200)" rows="8" style="width: 570px; font-size: 14px" placeholder="请编辑正文内容"></textarea>
					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" id="btnSave" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/section/SectionFocusList.jsp')" value="返回" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
	</body>
</html>
