<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="generator" content="HTML Tidy, see www.w3.org">
	<base href="<%=basePath%>">
	<!--引入jquery	-->
	<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="javascript/lhgdialog/lhgcore.lhgdialog.min.js"></script>
	<script type="text/javascript">
		function closeDialog(){
			window.parent.parent.document.getElementById('mainframe').contentWindow.SelImg.closeDialog();
		}
	</script>
	<style type="text/css">
		ul{
			list-style: none;
		}
		ul li{
			float: left;
			width: 196px;
			height: 144px;
			margin: 5px;
		}
		ul li img{
			width: 196px;
			height: 124px;
		}
		ul li div{
			width: 196px;
			height: auto;
			text-align: right;
		}
	</style>
</head>
<body style="text-align: left">

	<ul>
		<c:forEach items="${res.rows }" var="img">
			<li>
				<img src="${img.path }"  onclick="window.parent.parent.document.getElementById('mainframe').contentWindow.${param.fun }({id:${img.id },name:'${img.name}', path:'${img.path }'}); closeDialog(); return false;" />
				<div>${img.name }--<a href="#" onclick="window.parent.parent.document.getElementById('mainframe').contentWindow.${param.fun }({id:${img.id },name:'${img.name}', path:'${img.path }'}); closeDialog(); return false;">选择</a></div>
			</li>
		</c:forEach>
	</ul>
	
</body>
</html>