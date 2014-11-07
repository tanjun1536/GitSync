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
		<title>意见反馈</title>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<!--引入jquery-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<script type="text/javascript">
	function addFeedBack() {
		if ($.trim($("#content").val()) == "") {
			alert("请填写意见");
			return ;
		}
		if ($.trim($("#linkmethod").val()) == "") {
			alert("请填写联系方式");
			return ;
		}
	
	$.ajax({
			url : '<%=basePath%>FeedBackAction!addFeedBack.action',
			type : 'POST',
			dataType : 'json',
			data : {
				"fd.linkmethod" : $("#linkmethod").val(),
				"fd.content" : $("#content").val(),
				"fd.clientType" : "pad"
			},
			timeout : 30000,
			async : true,//使用同步
			beforeSend : function() {
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("操作失败!");
			},
			success : function(msg) {
			$("#linkmethod").val('');
			$("#content").val('');
				alert("操作成功!");
			},
			complete : function(XMLHttpRequest, textStatus) {
				//this; // 调用本次AJAX请求时传递的options参数
			}
		});

	}
</script>
	</head>
	<style>
* {margin:0px auto; padding:0}
body{font-family:"微软雅黑", "宋体", Terminal; font-size:64px;}
fieldset{list-style:none; border:none; width:90%; text-align:center; margin-top:20px}
li {padding-top:24px; list-style:none; color:#494949; width:90%}
input, textarea{ color:#666;vertical-align:middle;width:100%;padding:12px; font-size:56px}
label {width:100%; text-align:left; display:block;vertical-align:middle; padding-bottom:5px}

.button {font-size:64px; font-weight:bold; margin-top:40px; padding:18px;display: inline-block; color:#FFFFFF;border-radius:12px;border-color:#0f6dbb; border-width:1px;background-color:#207cca;background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#2882ce), color-stop(100%,#0c6abc)); cursor:pointer}
.button:hover{background-color:#4499e1;background:-webkit-gradient(linear, left top, left bottom, color-stop(1%,#4499e1), color-stop(99%,#2882ce)); cursor:pointer}
</style>

	<body>
		<form action="<%=basePath%>FeedBackAction!addFeedBack.action" method="POST" onsubmit="return validate();">
		<input type="hidden" value="pad" name="fd.clientType" />
		<fieldset>
			<ol>
				<li>
					<label for="content">
						输入意见:
					</label>
					<textarea name="fd.content" id="content" cols="" rows=""></textarea>
				</li>
				<li>
					<label for="linkmethod">
						联系方式:
					</label>
					<input id="linkmethod" name="fd.linkmethod" type="text" placeholder="电话、QQ号码、邮箱" required />
				</li>
			</ol>
		</fieldset>
		<fieldset style="margin-top: 30px">
			<button type="submit"  class="button">
				提 交
			</button>
		</fieldset>
		</form>
	</body>
</html>
