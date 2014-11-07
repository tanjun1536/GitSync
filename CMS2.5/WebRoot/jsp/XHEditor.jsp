<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<base href="<%=basePath%>">
		<title>jQuery Adapter &mdash; CKEditor Sample</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<link rel="stylesheet" href="common.css" type="text/css" media="screen" />
		<style type="text/css">
<!--
.testClassName {
	background: transparent url(javascript/xheditor-1.1.13/demos/img/plugin.gif) no-repeat 16px 16px;
	background-position: 2px 2px;
}

.btnCode {
	background: transparent url(prettify/code.gif) no-repeat 16px 16px;
	background-position: 2px 2px;
}
-->
</style>
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<script type="text/javascript" src="javascript/xheditor-1.1.13/xheditor-1.1.13-zh-cn.min.js"></script>
		<script type="text/javascript" src="jsp/imgcontent/selimg.js"></script>
		<script type="text/javascript">
	var editor;
	$(pageInit);
	function pageInit() {
		var allPlugin = {
			test2 : {
				c : 'testClassName',
				t : '插入图片',
				s : 'ctrl+1',
				e : function() {
					var _this = this;
					var callback=function(data){_this.loadBookmark();
						_this.pasteHTML("");
						return false;};
					browse('callback');
					_this.saveBookmark();
				}
			}
		};
		editor = $('#elm1').xheditor({
			plugins : allPlugin,
			tools : 'test2,Source,Fullscreen',
			loadCSS : '<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>',
			shortcuts : {
				'ctrl+enter' : submitForm
			}
		});
		$('#btnSubscript').click(function() {
			editor.exec('subscript');
		});
		$('#btnTest2').click(function() {
			editor.exec('test2');
		});
	}
	function submitForm() {
		$('#frmDemo').submit();
	}
</script>
	</head>
	<body>
		<div id="header-nav">
			<ul>
				<li>
					<a href="demo01.html"><span>默认模式</span>
					</a>
				</li>
				<li>
					<a href="demo02.html"><span>自定义按钮</span>
					</a>
				</li>
				<li>
					<a href="demo03.html"><span>皮肤选择</span>
					</a>
				</li>
				<li>
					<a href="demo04.html"><span>其它选项</span>
					</a>
				</li>
				<li>
					<a href="demo05.html"><span>API交互</span>
					</a>
				</li>
				<li>
					<a href="demo06.html"><span>非utf-8编码调用</span>
					</a>
				</li>
				<li>
					<a href="demo07.html"><span>UBB可视化</span>
					</a>
				</li>
				<li>
					<a href="demo08.html"><span>Ajax上传</span>
					</a>
				</li>
				<li>
					<a href="demo09.html"><span>插件扩展</span>
					</a>
				</li>
				<li>
					<a href="demo10.html"><span>iframe调用上传</span>
					</a>
				</li>
				<li>
					<a href="demo11.html"><span>异步加载</span>
					</a>
				</li>
				<li>
					<a href="demo12.html"><span>远程抓图</span>
					</a>
				</li>
				<li>
					<a href="../wizard.html" target="_blank"><span>生成代码</span>
					</a>
				</li>
			</ul>
		</div>
		<form id="frmDemo" method="post" action="showplugin.php">
			<h3>
				xhEditor demo9 : 自定义按钮之插件扩展
			</h3>
			<textarea id="elm1" name="elm1" rows="12" cols="80" style="width: 80%">
&lt;p&gt;&lt;strong&gt;插件初始化参考代码：&lt;/strong&gt;&lt;br /&gt;&lt;/p&gt;&amp;lt;script type=&amp;quot;text/javascript&amp;quot;&amp;gt;&lt;br /&gt;var editor;&lt;br /&gt;$(pageInit);&lt;br /&gt;function pageInit()&lt;br /&gt;{&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;var allPlugin={&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; subscript:{c:'testClassName',t:'下标:调用execCommand(subscript)'},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; superscript:{c:'testClassName',t:'上标:调用execCommand(superscript)'},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test1:{c:'testClassName',t:'测试1：加粗 (Ctrl+1)',s:'ctrl+1',e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; this._exec('Bold');&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test2:{c:'testClassName',t:'测试2：普通对话框 (Ctrl+2)',s:'ctrl+2',h:1,e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var _this=this;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var jTest=$('&amp;lt;div&amp;gt;测试showDialog&amp;lt;/div&amp;gt;&amp;lt;div style=&amp;quot;text-align:right;&amp;quot;&amp;gt;&amp;lt;input type=&amp;quot;button&amp;quot; id=&amp;quot;xheSave&amp;quot; value=&amp;quot;确定&amp;quot; /&amp;gt;&amp;lt;/div&amp;gt;');&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var jSave=$('#xheSave',jTest);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; jSave.click(function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.pasteHTML('点击了确定按钮');&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.hidePanel();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; return false;&amp;nbsp;&amp;nbsp; &amp;nbsp;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; });&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.saveBookmark();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.showDialog(jTest);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test3:{c:'testClassName',t:'测试3：需要转移焦点的对话框 (Ctrl+3)',s:'ctrl+3',h:1,e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var _this=this;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var jTest=$('&amp;lt;div&amp;gt;测试需要转移焦点的showDialog&amp;lt;/div&amp;gt;&amp;lt;div&amp;gt;&amp;lt;textarea id=&amp;quot;xheTestInput&amp;quot; style=&amp;quot;width:260px;height:100px;&amp;quot;&amp;gt;当互动界面中有input或者textarea等会产生焦点的表单项时，必需在插入内容前用loadBookmark函数加载之前保存的光标焦点。&amp;lt;/textarea&amp;gt;&amp;lt;/div&amp;gt;&amp;lt;div style=&amp;quot;text-align:right;&amp;quot;&amp;gt;&amp;lt;input type=&amp;quot;button&amp;quot; id=&amp;quot;xheSave&amp;quot; value=&amp;quot;确定&amp;quot; /&amp;gt;&amp;lt;/div&amp;gt;');&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var jTestInput=$('#xheTestInput',jTest),jSave=$('#xheSave',jTest);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; jSave.click(function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.loadBookmark();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.pasteText('您输入了：'+jTestInput.val());&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.hidePanel();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; return false;&amp;nbsp;&amp;nbsp; &amp;nbsp;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; });&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.saveBookmark();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.showDialog(jTest);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test4:{c:'testClassName',t:'测试4：面板界面 (Ctrl+4)',s:'ctrl+4',h:1,e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var _this=this;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var jTest=$('&amp;lt;div style=&amp;quot;padding:5px;&amp;quot;&amp;gt;测试showPanel&amp;lt;/div&amp;gt;');&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.showPanel(jTest);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test5:{c:'testClassName',t:'测试5：菜单调用 (Ctrl+5)',s:'ctrl+5',h:1,e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var _this=this;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var arrMenu=[{s:'菜单1',v:'menu1',t:'这是菜单1'},{s:'菜单2',v:'menu2',t:'这是菜单2'},{s:'菜单3',v:'menu3',t:'这是菜单3'}];&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.saveBookmark();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.showMenu(arrMenu,function(v){_this.pasteHTML(v);});&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test6:{c:'testClassName',t:'测试6：showModal (Ctrl+6)',s:'ctrl+6',e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var _this=this;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.saveBookmark();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.showModal('测试showModal接口','&amp;lt;div style=&amp;quot;padding:5px;&amp;quot;&amp;gt;模式窗口主体内容&amp;lt;/div&amp;gt;',500,300);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }},&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; test7:{c:'testClassName',t:'测试7：showIframeModal (Ctrl+7)',s:'ctrl+7',e:function(){&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; var _this=this;&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.saveBookmark();&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; _this.showIframeModal('测试showIframeModal接口','uploadgui.php',function(v){_this.loadBookmark();_this.pasteText('返回值：\r\n'+v);},500,300);&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; }}&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;};&lt;br /&gt;&amp;nbsp;&amp;nbsp; &amp;nbsp;editor=$('#elm1').xheditor({plugins:allPlugin,tools:'subscript,superscript,test1,test2,test3,test4,test5,test6,test7,|,Source,Fullscreen,About'});&lt;br /&gt;}&lt;br /&gt;&amp;lt;/script&amp;gt;&lt;p&gt;&lt;strong&gt;插件对象的属性解释：&lt;/strong&gt;&lt;br /&gt;&lt;br /&gt;c：样式表名称　t：插件名字(鼠标在按钮上方时显示)　s：快捷方式(例如：Esc、Ctr+B)　h：是否鼠标悬停直接执行,1:直接执行(省略当前值代表不直接执行)　e：按钮点击后需要执行的代码(省略执行代码，则把当前的插件名作为参数，调用浏览器的execCommand函数)&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;strong&gt;特别说明：&lt;/strong&gt;&lt;br /&gt;如果您希望样式表存储在系统自带的模板目录ui.css中，请将插件对象的样式名留空，则会自动按照插件名来调用相应的样式，例如：xhEdtBtnCut、xhEdtBtnCopy，其中的Cut和Copy是插件名&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;
	</textarea>
			<br />
			<br />
			<input type="submit" name="save" value="Submit" />
			<input type="reset" name="reset" value="Reset" />
			<input type="button" id="btnSubscript" value="外部调用下标插件" />
			<input type="button" id="btnTest2" value="外部调用插件2" />
		</form>
	</body>
</html>