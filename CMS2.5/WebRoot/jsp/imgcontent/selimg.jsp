<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="generator" content="HTML Tidy, see www.w3.org">
	<base href="<%=basePath%>">
	<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
	<!--引入jquery	-->
	<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
	<!-- jquery easyui-->
	<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		jQuery(function(){$('#sectiontree').tree({
			checkbox: false,
			url: 'SectionAction!getSections.action',
			//左键鼠标事件
			onClick:function(node){
//				$(this).tree('toggle', node.target);
				$("#ImgContent").attr("src","ImageInfoAction!listSel.action?imgInfo.section.id=" + node.id + "&fun=${param.fun }");
			},
			//右键鼠标事件
			onContextMenu: function(e, node){ 
				e.preventDefault();
				$('#sectiontree').tree('select', node.target);
			}
		});});
	</script>
  </head>
<body>
<!-- Insert title here <a href="#" onclick="parent.${param.fun }(); return flase;">click</a> -->
	<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" width="170">
				我的栏目
				<ul id="sectiontree"></ul>
			</td>
			<td>
				<iframe id="ImgContent" src="" height="480" frameborder="0" style="width: 100%;"></iframe>
			</td>
		</tr>
	</table>
</body>
</html>