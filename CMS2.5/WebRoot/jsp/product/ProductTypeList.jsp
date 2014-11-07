<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@page import="com.gang.entity.log.StateLog"%>
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
				<!--引入jquery	-->
				<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
				<!--引入Grid样式		-->
				<link href="javascript/jquery.jqGrid-4.5.2/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
				<link href="css/style.css" rel="stylesheet" type="text/css" />
				<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
				<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
				<script src="javascript/jquery.jqGrid-4.5.2/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
				<script src="javascript/jquery.jqGrid-4.5.2/js/jquery.jqGrid.min.js" type="text/javascript"></script>
				<!-- jquery easyui-->
				<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
				<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
				<script src="javascript/jqGrid3.0.js" type="text/javascript"></script>
				<script src="javascript/base.js" type="text/javascript"></script>
				<script type="text/javascript">
				$(function ()
       			 {
		            jqGrid.createJqGrid({
		            	table:"#gridTable",
		            	pager:"#gridPager",
		                url: "ProductTypeAction!getList.action",
		                editUrl: "ProductTypeAction!edit.action?id=",
		                deleteUrl: "ProductTypeAction!ajaxDelete.action",
		                colNames: ["编号", "编辑","删除","类型名称"],
		                colModel: [
		                    { name: "id", fixed: true, width: 40, hidden: true, align: "center" },
		                    { name: "edit", width: 50, align: "center", fixed: true, sortable: false },
		                    { name: "del", width: 50, align: "center", fixed: true, sortable: false },
		                    { name: "name" },
		                ],
		                buttons: [
		                { column: 'edit', html: '<button onclick=\"jqGrid.Edit(\'{id}\')\">编辑</button>'},
		                { column: 'del', html: '<button onclick=\"jqGrid.Delete(\'{id}\')\">删除</button>'}
		                ],
		                caption: "商品类别列表"
		            });
		        });
		        function addPrize()
		        {
		        	fn.openURL("ProductTypeAction!add.action");
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
			当前位置：商品管理 > 商品类型管理
		</div>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<input type="button" onclick="addPrize();" value="添加商品类型" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>
