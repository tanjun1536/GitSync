<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>

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
<title>i南充内容发布管理平台dddd</title>
<!--引入jquery	-->
<script type="text/javascript"
	src="javascript/jquery/js/jquery-1.7.min.js"></script>
<!-- jquery easyui-->
<link rel="stylesheet" type="text/css"
	href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
<script type="text/javascript"
	src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
<script type="text/javascript" src="javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="javascript/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript"
	src="javascript/xheditor-1.1.13/xheditor-1.1.13-zh-cn.min.js"></script>
<link href="css/xheditor.css" rel="stylesheet" type="text/css" />
<script src="javascript/base.js" type="text/javascript"></script>
<script src="javascript/map.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
<script src="javascript/finder.js" type="text/javascript"></script>
<script type="text/javascript"
	src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
<link rel="stylesheet" type="text/css" media="screen"
	href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js"
	type="text/javascript"></script>
<!-- include jQuery + carouFredSel plugin -->
<script type="text/javascript" language="javascript"
	src="javascript/carouFredSel-6.1.0/jquery.carouFredSel-6.1.0-packed.js"></script>
<!-- optionally include helper plugins -->
<script type="text/javascript" language="javascript"
	src="javascript/carouFredSel-6.1.0/helper-plugins/jquery.mousewheel.min.js"></script>
<script type="text/javascript" language="javascript"
	src="javascript/carouFredSel-6.1.0/helper-plugins/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" language="javascript"
	src="javascript/carouFredSel-6.1.0/helper-plugins/jquery.ba-throttle-debounce.min.js"></script>
<link href="css/group.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	var map = new HashMap();
	var oldIndex = null;
	$(function() {
		$('#section\\.id').combotree({
			url : 'SectionAction!getSectionTreeJSON.action',
			onSelect : function(node) {
				var tree = $('#section\\.id').combotree('tree');
				var text = node.text;
				var cnode = tree.tree('getParent', node.target);
				while (cnode != null) {
					text = cnode.text + '—' + text;
					cnode = tree.tree('getParent', cnode.target);
				}
				setTimeout(function() {
					$('#section\\.id').combotree('setText', text);
				}, 1);
			}

		});
		oldIndex = $("#contentTemplate\\.id").val();
		$("#section\\.id").combotree('setValue', 1);

		$("#contentTemplate\\.id").change(function() {
			//if (confirm("改变模版将清空已经填写的数据,确认改变？")) {
			changeTemplate(this);
			//oldIndex = $("#contentTemplate\\.id").val();
			// 			} else
			// 				$("#contentTemplate\\.id").val(oldIndex);

		});
		changeTemplate($("#contentTemplate\\.id"));
		
		changeVisiableTempate("#contentType\\.id");
	});
	
	var option='<option value="2" showtypes=\'[{"name":"商家","code":"50","id":4}]\' script="javascript/page/am_shop.js">商家模版</option>';
	function changeVisiableTempate(type) {
		var selectedType = $(type).val();
		if (selectedType == 1 ||selectedType ==3) {
		 $("#contentTemplate\\.id").children("option[value='2']").each(function(){
                     $(this).remove();
                       //add a <span> around the <option> and hide the <span>.
                 }); $("#contentTemplate\\.id").trigger('change');
		} else  {
		 $("#contentTemplate\\.id").children("option[value='1']").each(function(){
                     $(this).after(option);
                       //add a <span> around the <option> and hide the <span>.
                 }); $("#contentTemplate\\.id").trigger('change');
		} 
		
	}
	function createShowType(templateObj) {
		var showtypes = $(templateObj).find('option:selected')
				.attr('showtypes');
		$("#contentShowType\\.id").empty();
		var json = eval(showtypes);
		if (json) {
			$.each(json, function(k) {
				$(
						"<option value='" + json[k]['id'] + "'>"
								+ decodeURI(json[k]['name']) + "</option>")
						.appendTo("#contentShowType\\.id");
			});
		}
	}
	function changeTemplate(thisObj) {
		var id = $(thisObj).find('option:selected').attr("value");
		var script = $(thisObj).find('option:selected').attr('script');
		$.getScript(script).done(function(script, textStatus) {
			createShowType("#contentTemplate\\.id");
			$("#contentContainer").html(map.get(id));
		  setTimeout(function(){	init(false);},1000);
		}).fail(function(jqxhr, settings, exception) {
			alert(script + ":加载失败!" + exception);
		});
	}
</script>

</head>
<body>
	<header>
	<div class="header_a"></div>
	<div class="header_b"></div>
	<div class="header_c">&lt;当前位置：采编管理 &gt; 手机文章内容发布</div>
	<div class="clear"></div>
	</header>
	<form id="ContentForm" method="post">
		<input type="hidden" id="sender" name="sender"
			value="${sessionScope.BackLoginUser.id}" />
		<div class="formdiv">

			<ol>
				<li><label class="label"> 所属栏目: </label> <input id="section.id"
					name="section.id" type="hidden" class="easyui-combotree"
					style="width: 200px;">
				</li>
				<li><label class="label"> 文章类型: </label> <select
					id="contentType.id" name="contentType.id" onchange="changeVisiableTempate(this)" required autofocus
					style="width: 202px">
						<c:forEach var="item" items="${contentTypes }">
							<option value="${item.id }">${item.name }</option>
						</c:forEach>
				</select></li>
				<li><label class="label"> 文章模板: </label> <select
					id="contentTemplate.id" name="contentTemplate.id" required
					autofocus style="width: 202px">
						<c:forEach var="item" items="${contentTemplates }">
							<script type="text/javascript">
								map.put("${item.id }", "${item.addTemplate}");
							</script>
							<option value="${item.id }" showtypes='${item.showTypeText}'
								script="${item.script }">${item.name }</option>
						</c:forEach>
				</select></li>
				<li><label class="label"> 展示方式: </label> <select
					id="contentShowType.id" name="contentShowType.id" required
					autofocus style="width: 202px">
				</select></li>
				<div id="contentContainer"></div>
			</ol>
			<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
				<input type="button" value="保存" class="btn" onfocus="this.blur()"
					onclick="save()" onMouseOver="this.className='btn_over'"
					onMouseOut="this.className='btn'" style="vertical-align: top" /> <input
					type="button" value="返回"
					onclick="window.fn.openURL('jsp/article/ArticlePadList.jsp');"
					class="btn" onfocus="this.blur()"
					onMouseOver="this.className='btn_over'"
					onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
	</form>
</body>
</html>
