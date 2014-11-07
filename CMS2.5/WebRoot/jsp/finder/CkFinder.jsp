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
		<meta name="generator" content="HTML Tidy, see www.w3.org">
			<base href="<%=basePath%>">
				<!--引入Grid样式		-->
				<link href="css/style.css" rel="stylesheet" type="text/css" />
				<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
				<script src="javascript/base.js" type="text/javascript"></script>
				<script type="text/javascript">
	
</script>
	</head>
	<body>
		<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 图片管理
		</div>
		<div class="clear"></div>
		</header>
		<div class="Imgdiv">
			<script type="text/javascript">
	// This is a sample function which is called when a file is selected in CKFinder.
	function showFileInfo(fileUrl, data) {
		var msg = 'The selected URL is: <a href="' + fileUrl + '">' + fileUrl + '</a><br /><br />';
		// Display additional information available in the "data" object.
		// For example, the size of a file (in KB) is available in the data["fileSize"] variable.
		if (fileUrl != data['fileUrl'])
			msg += '<b>File url:</b> ' + data['fileUrl'] + '<br />';
		msg += '<b>File size:</b> ' + data['fileSize'] + 'KB<br />';
		msg += '<b>Last modified:</b> ' + data['fileDate'];

		// this = CKFinderAPI object
		this.openMsgDialog("Selected file", msg);
	}

	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.basePath = '/';
	// The default height is 400.
	finder.height = 600;
	// This is a sample function which is called when a file is selected in CKFinder.
	finder.selectActionFunction = showFileInfo;
	finder.create();

	// It can also be done in a single line, calling the "static"
	// create( basePath, width, height, selectActionFunction ) function:
	// CKFinder.create( '../', null, null, showFileInfo );

	// The "create" function can also accept an object as the only argument.
	// CKFinder.create( { basePath : '../', selectActionFunction : showFileInfo } );
</script>
		</div>

	</body>
</html>