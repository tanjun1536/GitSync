<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<base href="<%=basePath%>">

<title>My JSP 'MyJsp.jsp' starting page</title>

<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
<meta http-equiv="description" content="This is my page">
<!--引入jquery	-->
<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
<script src="javascript/finder.js" type="text/javascript"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	var api = frameElement.api, W = api.opener, D = W.document; // api.opener 为载加lhgdialog.min.js文件的页面的window对象
	$(function(){
		var imageObj= W.$.dialog.data('imageObj');
		if(imageObj)
		{
			$("#video").attr("src", imageObj.src);
			$("#desc").val($(imageObj).next().text());
		}
		
	});
	function sure() {
		var tabObj = W.$.dialog.data('tabObj'); // 通过数据共享的方法获取调用页面文本框对象
		var tabIndex = W.$.dialog.data('tabIndex'); // 通过数据共享的方法获取调用页面文本框对象
		var fileCount = W.$.dialog.data('fileCount'); // 通过数据共享的方法获取调用页面文本框对象
		var imageObj= W.$.dialog.data('imageObj');
		var url = $("#video").attr("src");
		var desc = $("#desc").val();
		if(imageObj)//修改
		{
			$(imageObj).attr("src", url);
			$(imageObj).next().text(desc);
		}
		else
		{
			tabObj.append('<li  style="width:120px;"><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;padding-left:104px;" /><video preload="auto" width="120" height="80" src="'+url+'" ondblclick="editFile(\'videos\',this)" ></video> <span>' + desc + '</span></li>').carouFredSel({
				circular : false,
				infinite : false,
				direction : "left",
				auto : false,
				prev : '#videos-prev' + tabIndex,
				next : '#videos-next' + tabIndex,
				pagination : "#videos-pager" + tabIndex,
				mousewheel : true,
				scroll : 6,
				swipe : {
					onMouse : true,
					onTouch : true
				}
			});
		}
		api.close();
	}
</script>

</head>

<body>
	<div class="formdiv">
		<div>
			<ol>
				<li><label class="label"> 视频: </label> <video id="video" preload="auto"  onclick="window.sector.openOnlyVideo('#video')" src="/CMS/userfiles/files/videos/mov_bbb.mp4" type="video/mp4"></video></li>
				<li><label class="label"> 描述: </label> <input type="text" id="desc"></li>
		</div>

		</ol>
		<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
			<input type="button" value="确定" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" onclick="sure()" /> <input type="button" value="取消" onclick="api.close();" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
		</div>
	</div>
</body>
</html>
