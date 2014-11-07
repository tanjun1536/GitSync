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
				<!--弹出窗口-->
				<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
				<script type="text/javascript">
				$(function() {
					jqGrid.createJqGrid({
					            	table:"#gridTable",
					            	pager:"#gridPager",
					                url: "OrdersAction!getList.action",
					                editUrl: "OrdersAction!edit.action?id=",
					                deleteUrl: "OrdersAction!ajaxDelete.action",
					                colNames: ["编号", "完成","账户名","商品名称","下单时间","订单状态"],
					                colModel: [
					                    { name: "id", fixed: true, width: 40, hidden: true, align: "center" },
					                    { name: "complete", width: 50, align: "center",hidden: false, fixed: true, sortable: false },
					                    { name: "user.loginName", width: 250,align: "center",fixed:true},
					                    { name: "product.name" },
					                    { name: "orderDate",width: 150,fixed:true,align: "center" },
					                    { name: "status",width: 100,fixed:true,align: "center" }
					                ],
					                buttons: [
					                { column: 'complete', html: '<button onclick=\"complete(\'{id}\')\">完成</button>',condition:"data['status']=='已完成'",text:'已完成'}
					                ],
					                caption: "订单列表"
					            });
					        });
					      
					function complete(id) {
						$.ajax({
							type : "POST",
							url : "OrdersAction!Complete.action",
							datatype : "json",
							data : {
								'id' : id
							},
							success : function(msg) {
								jqGrid.refresh('#gridTable');
							},
							error : function() {
								alert('出错了!');
							}
						});
					}
		
					function query() {
						var productName = $("#productName").val();
						var url = "OrdersAction!getList.action?productName="
								+ productName;
						jqGrid.reLoad('#gridTable', url);
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
			当前位置：订单管理 > 订单列表
		</div>
		<div class="sreachdiv">
			<div style="padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1px dotted #CCC">
				<li><label class="label"> 商品名称: </label><input id="productName" type="text" />
				<input type="button" onclick="query();" value="筛选" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				
<!-- 				<input type="button" onclick="addPrize();" value="添加商品" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" /> -->
			</div>
		</div>
		<div>
			<table id="gridTable">
			</table>
			<div id="gridPager"></div>
		</div>
	</body>
</html>
