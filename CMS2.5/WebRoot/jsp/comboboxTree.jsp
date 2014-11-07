<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<base href="<%=basePath%>">
		<title>ComboTree - jQuery EasyUI Demo</title>
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css">
		<!--		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/icon.css">-->

		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<script>
	$(function() {

		/*  $('#cc').combotree( {
			//获取数据URL
			url : 'SectionAction!getSectionTreeJSON.action',
			//选择树节点触发事件
			onSelect : function(node) {
				//返回树对象
				var tree = $(this).tree;
				//选中的节点是否为叶子节点,如果不是叶子节点,清除选中
				var isLeaf = tree('isLeaf', node.target);
				if (!isLeaf) {
					//清除选中
					$('#cc').combotree('clear');
				}
				setTimeout("$('#cc').combotree('setText','FUCK')",1);
				//$("#cc").combotree('setText','FUCK');
			}
		});*/

		$('#cc').combotree({
			url : 'SectionAction!getSectionTreeJSON.action',
			onSelect : function(node) {
				var tree = $('#cc').combotree('tree');
				var text = node.text;
				var cnode = tree.tree('getParent', node.target);
				while (cnode != null) {
					text = cnode.text + '—' + text;
					cnode = tree.tree('getParent', cnode.target);
				}
				setTimeout("$('#cc').combotree('setText','" + text + "')", 1);
			}

		});

	});

	function reload() {
		$('#cc').combotree('reload');
	}
	function setValue() {
		$('#cc').combotree('setValue', 2);
	}
	function getValue() {
		var val = $('#cc').combotree('getValue');
		alert(val);
	}
	function disable() {
		$('#cc').combotree('disable');
	}
	function enable() {
		$('#cc').combotree('enable');
	}
</script>
	</head>
	<body>
		<h2>
			ComboTree
		</h2>
		<div class="demo-info">
			<div class="demo-tip icon-tip"></div>
			<div>
				Click the right arrow button to show the tree.
			</div>
		</div>

		<div style="margin: 10px 0;">
			<a href="#" class="easyui-linkbutton" onclick="reload()">Reload</a>
			<a href="#" class="easyui-linkbutton" onclick="setValue()">SetValue</a>
			<a href="#" class="easyui-linkbutton" onclick="getValue()">GetValue</a>
			<a href="#" class="easyui-linkbutton" onclick="disable()">Disable</a>
			<a href="#" class="easyui-linkbutton" onclick="enable()">Enable</a>
		</div>
		<p>
			Single Select
		</p>
		<input id="cc" class="easyui-combotree" style="width: 200px;">
	</body>
</html>