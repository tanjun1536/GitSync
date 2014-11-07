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
		<title>jQuery Adapter &mdash; CKEditor Sample</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<script type="text/javascript" src="../javascript/jquery/js/jquery-1.7.min.js"></script>
		<script type="text/javascript" src="../javascript/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="../javascript/ckeditor/adapters/jquery.js"></script>
		<script type="text/javascript" src="../javascript/ckfinder/ckfinder.js"></script>
		<script type="text/javascript" src="../javascript/ckfinder/config.js"></script>
		<script type="text/javascript" src="../javascript/finder.js"></script>
		<script type="text/javascript">
	//   
	$(function() {
		var editor = CKEDITOR.replace("editor1", {
			toolbar : 'MyBasic',
			height : 300,
			width : 575
		});
		CKFinder.setupCKEditor(editor, '../javascript/ckfinder');
		
	  setTimeout(function(){editor.setReadOnly(true);}, 1000);	
	});

	//
</script>
	</head>
	<body>
		<textarea id="editor1" name="editor1" rows="10" cols="80"></textarea>
		<h1 class="samples">
			CKEditor Sample &mdash; Using jQuery Adapter
		</h1>
		<div class="description">
			<p>
				This sample shows how to load CKEditor and configure it using the
				<a class="samples" href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/jQuery_Adapter">jQuery adapter</a>. In this case the jQuery adapter is responsible for transforming a
				<code>
					&lt;textarea&gt;
				</code>
				element into a CKEditor instance and setting the configuration of the toolbar.
			</p>
			<p>
				CKEditor instance with custom configuration set in jQuery can be inserted with the following JavaScript code:
			</p>
			<pre class="samples">$(function()
{
	var config = {
		skin:'v2'
	};

	$('.<em>textarea_class</em>').ckeditor(config);
});</pre>
			<p>
				Note that
				<code>
					<em>textarea_class</em>
				</code>
				in the code above is the
				<code>
					class
				</code>
				attribute of the
				<code>
					&lt;textarea&gt;
				</code>
				element to be replaced with CKEditor. Any other jQuery selector can be used to match the target element.
			</p>
		</div>

		<!-- This <div> holds alert messages to be display in the sample page. -->
		<div id="alerts">
			<noscript>
				<p>
					<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript support, like yours, you should still see the contents (HTML data) and you should be able to edit it normally, without a rich editor interface.
				</p>
			</noscript>
		</div>
		<!-- This <fieldset> holds the HTML that you will usually find in your
	     pages. -->
		<form action="sample_posteddata.php" method="post">
			<p>
				<label for="editor1">
					Editor 1:
				</label>
				<textarea class="jquery_ckeditor" cols="80" id="editor1" name="editor1" rows="10">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href="http://ckeditor.com/"&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>
			</p>
			<p>
				<input type="submit" value="Submit" />
			</p>
		</form>
		<div id="footer">
			<hr />
			<p>
				CKEditor - The text editor for the Internet -
				<a class="samples" href="http://ckeditor.com/">http://ckeditor.com</a>
			</p>
			<p id="copy">
				Copyright &copy; 2003-2011,
				<a class="samples" href="http://cksource.com/">CKSource</a> - Frederico Knabben. All rights reserved.
			</p>
		</div>
	</body>
</html>

