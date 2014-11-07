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
		<!-- ckfinder-->
		<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
		<script src="javascript/finder.js" type="text/javascript"></script>
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<script type="text/javascript" src="javascript/xheditor-1.1.13/xheditor-1.1.13-zh-cn.min.js"></script>
		<link href="css/xheditor.css" rel="stylesheet" type="text/css" />
		<script src="javascript/base.js" type="text/javascript"></script>

		<script type="text/javascript">
	$(function() {
		$('#article\\.section\\.id').combotree({
			url : 'SectionAction!getSectionTreeJSON.action',
			onSelect : function(node) {
				var tree = $('#article\\.section\\.id').combotree('tree');
				var text = node.text;
				var cnode = tree.tree('getParent', node.target);
				while (cnode != null) {
					text = cnode.text + '—' + text;
					cnode = tree.tree('getParent', cnode.target);
				}
				setTimeout(function(){$('#article\\.section\\.id').combotree('setText', text);}, 1);
			}

		});
	
		$("#article\\.section\\.id").combotree('setValue', ${article.section.id==null?1:article.section.id});
		 $("#article\\.summary").keyup(function(){
		    	$("#charCount").html("当前字数："+$("#article\\.summary").val().length+"个");
		    });
		     $("#article\\.title").keyup(function(){
		    	$("#charTitleCount").html("当前字数："+$("#article\\.title").val().length+"个");
		    });
		init();
	});
	function onTitleImageSelected(data)
	{
		$("#article\\.titleImage").val(data.path);
		$("#titleImagePreview").attr("src",data.path);
	}
	function onFocusImageSelected(data)
	{
		$("#article\\.focusImage").val(data.path);
		$("#focusImagePreview").attr("src",data.path);
	}
	//编辑器
		var editor;
	function init() {
		var plugins = {
			insertImage : {
				c : 'xheditor_tool_image',
				t : '插入图片',
				s : 'ctrl+1',
				e : function() {
					var _this=this;
					window.sector.openForEditor('images',function(url,data){editor.loadBookmark();editor.pasteHTML('<img border="0"  src="'+url+'" />');});
					_this.saveBookmark();
				}
			},
			insertVideo : {
				c : 'xheditor_tool_video',
				t : '插入视频',
				s : 'ctrl+1',
				e : function() {
					var _this=this;
					browse('imagecallback');
					_this.saveBookmark();
				}
			},
			insertAudio : {
				c : 'xheditor_tool_audio',
				t : '插入音频',
				s : 'ctrl+1',
				e : function() {
					var _this=this;
					browse('imagecallback');
					_this.saveBookmark();
				}
			}
			
		};
		editor = $('#article\\.content').xheditor({
			plugins : plugins,
			tools : 'insertImage,insertVideo,insertAudio,Source,Fullscreen',
			loadCSS : '<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>'}
			);
				editor.exec('Fullscreen');
			setTimeout(function(){editor.exec('Fullscreen');}, 100);
		}
	function imagecallback(data)
	{
		editor.loadBookmark();
		editor.pasteHTML('<img border="0"  src="'+data.path+'" />');
		return false;
	}
</script>
		
	</head>
	<body>
	<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 平板文章内容发布
		</div>
		<div class="clear"></div>
		</header>
		<form action="ArticlePadAction!save.action" id="frm" method="post">
			<input type="hidden" value="${article.id }" name="article.id">
			<div class="formdiv">

				<ol>
				
					<li>
						<label for="article.section.id" class="label">
							所属栏目:
						</label>
						<input id="article.section.id" name="article.section.id" type="hidden" class="easyui-combotree" url="SectionAction!getSectionTreeJSON.action" style="width: 200px;">
					</li>
						<li>
						<label for="article.template.id" class="label">
							选择模板:
						</label>
						<select id="article.template.id" name="article.template.id" required autofocus style="width: 202px">
							<c:forEach var="item" items="${templates }">
								<option value="${item.id }">
									${item.name }
								</option>
							</c:forEach>
						</select>
					</li>
					<li>
						<label for="article.title" class="label">
							文章标题：
						</label>
						<input id="article.title" name="article.title" type="text" value="${fn:escapeXml(article.title)}" style="font-size: 22px; font-weight: 600; width: 570px" required>
						<label  id="charTitleCount">
							当前字数：0 个
						</label>
					</li>
<!--					<li>-->
<!--						<label for="article.subTitle" class="label">-->
<!--							副标题：-->
<!--						</label>-->
<!--						<input id="article.subTitle" name="article.subTitle" type="text" value="${article.subTitle }" style="font-size: 16px; font-weight: 400; width: 570px" required>-->
<!--					</li>-->
<!--					<li>-->
<!--						<label for="article.keywords" class="label">-->
<!--							关键词：-->
<!--						</label>-->
<!--						<input id="article.keywords" name="article.keywords" value="${article.keywords}" type="text" size="60" required>-->
<!--					</li>-->
					<li>
						<label for="article.source" class="label">
							内容来源：
						</label>
						<input id="article.source" name="article.source" value="${article.source }" type="text" size="60" required>
					</li>
<!--					<li>-->
<!--						<label for="article.isHot" class="label">-->
<!--							热门文章：-->
<!--						</label>-->
<!--						<c:if test="${article==null }">-->
<!--							<input type="checkbox" name="article.isHot" value="true" />-->
<!--						</c:if>-->
<!--						<c:if test="${article.isHot==false }">-->
<!--							<input type="checkbox" name="article.isHot" value="true" />-->
<!--						</c:if>-->
<!--						<c:if test="${article.isHot==true }">-->
<!--							<input type="checkbox" checked="checked" name="article.isHot" value="true" />-->
<!--						</c:if>-->
<!--					</li>-->
					<li>
						<label for="article.state.id" class="label">
							当前状态：
						</label>
						<select id="article.state.id" name="article.state.id">
							<c:forEach var="item" items="${states }">
								<c:choose>
									<c:when test="${item.id==article.state.id }">
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
						<label for="article.summary" class="label">
							摘要：
						</label>
						<textarea id="article.summary" name="article.summary" rows="3" style="width: 570px">${article.summary}</textarea>
						<label  id="charCount">
							当前字数：0 个
						</label>
					</li>
					<li>
						<label for="article.content" class="label">
							正文内容：
						</label>
<!--						<textarea id="article.content" name="article.content" rows="8" style="width: 570px; font-size: 14px" placeholder="请编辑正文内容">${article.content}</textarea>-->
							<textarea id="article.content" name="article.content" rows="8" style="width: 575px; font-size: 14px" placeholder="请编辑正文内容">${article.content}</textarea>
					</li>
					<li>
						<label for="article.titleImage" class="label">
							标题图片：<br/><font color="blue">(445px*270px) </font>
						</label>
						<c:choose>
							<c:when test="${article==null||article.titleImage=='' }">
								<img src="images/img230_180.png" id="titleImagePreview" width="230" height="180" alt="标题图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC" />
							</c:when>
							<c:otherwise>
								<img src="${article.titleImage}" id="titleImagePreview" width="230" height="180" alt="标题图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC"/>
							</c:otherwise>
						</c:choose>
						<input type="button" value="浏览图库" onclick="window.sector.open('images','#article\\.titleImage','#titleImagePreview')" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
						<input type="button" value="删除图片" onclick="$('#titleImagePreview').attr('src','images/imgOccupying.png');$('#article\\.titleImage').val('images/imgOccupying.png')" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />

						<input type="hidden" id="article.titleImage" name="article.titleImage" value="${article.titleImage }" />




					</li>
				</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="window.fn.openURL('jsp/article/ArticlePadList.jsp');" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
		</form>
	</body>
</html>
