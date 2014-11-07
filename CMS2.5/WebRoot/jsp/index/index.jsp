<%@page import="com.gang.entity.user.BackUser"%>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.gang.service.system.SystemService"%>
<%@page import="com.gang.comms.SpringContextUtil"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
 	BackUser user=	(BackUser)request.getSession().getAttribute("BackLoginUser");
	if(user==null) 
	{
		response.sendRedirect(request.getContextPath() + "/jsp/index/login.jsp");
	}
%>
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<base href="<%=basePath%>" target="mainFrame">
<title>移动城市容发布管理平台</title>
<link rel="stylesheet" type="text/css"  href="css/framestyle.css" />
<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="javascript/menu.js"></script>
<script type="text/javascript" src="javascript/jquery.iframe.js"></script>
<script type="text/javascript" src="javascript/jquery.center.js"></script>
<style type="text/css">
#loading {
<%--	width: 100%;--%>
<%--	height: 100%;--%>
	top: 0px;
	left: 0px;
	position: fixed;
	display: block;
	opacity: 0.7;
<%--	background-color: #fff;--%>
	z-index: 99;
	text-align: center;
}

#loading-image {
	position: absolute;
	top: 100px;
	left: 240px;
	z-index: 100;
}
</style>
		<script type="text/javascript">
	//加载loading效果	
function changeLocation(url)
{
	$("#loading").center({inside:"#mainframe",offsetY:-80,offsetX:-50}); 
	 $('#loading').show(); 
	$("#mainframe").src(url, function(duration) { 
		//  alert("That took " + duration + " millis.");
		  $('#loading').hide(); 
		}, {
		  timeout: function() { /*alert("oops! timed out.");*/ },
		  timeoutDuration: 1000000
		});

}

	function changePwd() {
		changeLocation('<%=basePath%>index/alterpwd.jsp');
	}
	function changeJqGridWidth(w) {
		$("#mainframe").each(function(index) {
			try {
				this.contentWindow.changeJqGridWidth(w);
			} catch (e) {
			}
		});
	}
</script>
</head>

<body>
  <div class="header"> 
     <div class="logo"> </div>
     <div class="top"><span><img src="images/user_32.png" > 当前用户：<b style="color:#cb130e"><%=user.getName() %>！</b></span>
       <span><a href="jsp/index/alterpwd.jsp"><img src="images/admin_32.png" > 修改密码</a></span>
       <span><a href="LoginAction!logOut.action"><img src="images/close_32.png" > 安全退出</a></span>
     </div>
     <div class="clear"> </div>
</div>
 <div id="loading" style="display: none;">   <img id="loading-image" src="images/ajax-loader.gif" alt="Loading..." /> </div> 
<div class="side_a" id="side">
 <div id="menu">
   <div class="menutop"></div>
   <%
		SystemService sevices = (SystemService) SpringContextUtil.getBean("SystemService");
	%>
	<c:set scope="page" var="menus" value="<%=sevices.getMenus(sevices.getRoleIds(session))%>"></c:set>
	<c:forEach var="menu" items="${menus}">
		<%-- 第一级 --%>
		<c:if test="${menu.parent eq null}">
			<h4>${menu.name}</h4>
			<ul>
			<c:forEach var="cmenu" items="${menus}">
				<c:if test="${cmenu.parent ne null && cmenu.parent.id eq menu.id}">
				<li><a href="#" onclick="changeLocation('${cmenu.link }');return false;" target="mainFrame">${cmenu.name }</a></li>
				</c:if>
			</c:forEach>
			</ul>
		</c:if>
	</c:forEach>
 </div>
     <script type="text/javascript">
    //<![CDATA[
      var o = new neverModules.ui.outlookMenu("menu", "o")
      .setStyle("menu")
      .setAnimate({delay:10, increase:40, decrease:30})
      .render();
    //]]>
    </script>
</div>

<div class="main_a" id="main" >
<div class="roundCorder" >
    <div class="close_a" onclick="showTreeMenu();if(this.className=='close_a'){changeJqGridWidth(-216);}else{changeJqGridWidth(216);}" id="close"> </div>
 <iframe frameborder="0" src="" name="mainFrame" style="min-height: 700px;overflow: scroll;"  id="mainframe" ></iframe>
</div>
</div>

</body>
</html>

