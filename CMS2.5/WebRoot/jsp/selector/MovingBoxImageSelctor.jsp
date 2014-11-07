<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
	String domain = request.getScheme() + "://"
			+ request.getServerName() 
			+ path ;
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
			$("#preview").attr("src", imageObj.src.replace('<%=domain%>',''));
			$("#desc").val($(imageObj).next().next().text());
		}
		
	});
	function sure() {
	    var fn =W.$.dialog.data('fn');
		var imageObj= W.$.dialog.data('imageObj');
		var url=$("#preview").attr("src");
		var desc=$("#desc").val();
		if(imageObj)//修改
		{
			$(imageObj).attr("src", url);
			$(imageObj).next().text(desc);
		}
		else
		{
			fn(url,desc);
		}
		api.close();
	}
</script>

</head>

<body>
	<div class="formdiv">
		<div>
			<ol>
				<li><label class="label"> 图片: </label> <img style="width: 120px;height: 80px" onclick="window.sector.openOnlyImage('#preview')" id="preview" alt="点击选择图片" src="images/addPic.gif"></li>
				<li><label class="label"> 描述: </label> <input id="desc" type="text" id="desc"></li>
		</div>

		</ol>
		<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
			<input type="button" value="确定" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" onclick="sure()" /> <input type="button" value="取消" onclick="api.close();" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
		</div>
	</div>
</body>
</html>
