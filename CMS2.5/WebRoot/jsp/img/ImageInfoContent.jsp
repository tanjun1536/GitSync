<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<!--引入Grid样式		-->
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
		function showOpation(tag,flag){
			$(tag).children().last().css("display",flag?"block":"none");
		}
		//删除
		function del(id) {
			if (confirm("是否删除该图片？")) {
				$.ajax({
					type : "POST",
					url : "ImageInfoAction!ajaxDelete.action",
					datatype : "json",
					data : {
						"imgInfo.id" : id
					},
					success : function(msg) {
						if(msg == "OK"){
							alert("删除成功");
							window.location.reload();
						}
						else{
							alert("删除失败");
						}
					},
					error:function(msg)
					{
						alert(msg);
					}
				});
			}
			return false;
		}
	</script>
		<style type="text/css">
ul {
	list-style: none;
}

ul li {
	float: left;
	width: 196px;
	height: 144px;
	margin: 5px;
}

ul li img {
	width: 196px;
	height: 124px;
}

ul li div {
	width: 196px;
	height: auto;
	text-align: right;
}
</style>
	</head>
	<body>
		<p class="title">
			<input type="button" value="上传图片" onclick="fn.openParentURL('<%=basePath%>ImageInfoAction!add.action?imgInfo.section.id=${imgInfo.section.id }')" class="btn" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" />
		</p>
		<div class="receipt">
			<ul>
				<c:forEach items="${res.rows }" var="img">
					<li onmouseover="showOpation(this,true);" onmouseout="showOpation(this,false);">
						<img src="${img.path }" alt="${img.name }" />
						<p>
							${img.name }
						</p>
						<p style="display: none;">
							<span><a href="#" onclick="fn.openParentURL('ImageInfoAction!edit.action?imgInfo.id=${img.id }');return false;">编辑</a> </span><span><a href="#" onclick="return del(${img.id })">删除</a> </span>
						</p>
					</li>
				</c:forEach>
			</ul>
		</div>
		<div class=" clear">
		</div>
		
	</body>
</html>