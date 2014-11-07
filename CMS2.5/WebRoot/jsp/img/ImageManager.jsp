<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>
<%@taglib uri="http://www.ctags.com/tags" prefix="tag"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>图片管理</title>
    
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<script type="text/javascript" src="javascript/ckfinder/ckfinder_v1.js"></script>
	<script type="text/javascript">
		/*function BrowseServer()
		{
			var finder = new CKFinder();
			finder.BasePath = 'javascript/ckfinder';
			finder.SelectFunction = SetFileField;
			finder.Skin = 'v1';
			finder.Popup();
		}
		
		function SetFileField( fileUrl )
		{
			alert(fileUrl);
		}*/
	</script>
	<style type="text/css">
		/* By defining CKFinderFrame, you are able to customize the CKFinder frame style */
		.CKFinderFrame
		{
			border: solid 2px #e3e3c7;
			background-color: #f1f1e3;
		}
	</style>
  </head>
  
  <body >
  <div>
 <!--<tag:sections id="mysel" name="mysql" style="width:500px;text-align: right;font-weight: bold" sessName="BackLoginUser"></tag:sections>
  	 <tag:selectImgButton></tag:selectImgButton>
  	<input type="button" value="Browse Server" onclick="BrowseServer();" />-->
		<script type="text/javascript">

			// This is a sample function which is called when a file is selected in CKFinder.
			function ShowFileInfo( fileUrl, data )
			{
				var msg = 'The selected file URL is: ' + fileUrl + '\n\n';
				// Display additional information available in the "data" object.
				// For example, the size of a file (in KB) is available in the data["fileSize"] variable.
				msg += 'File size: ' + data['fileSize'] + 'KB\n';
				msg += 'Last modified: ' + data['fileDate'];

				alert( msg );
			}

			// You can use the "CKFinder" class to render CKFinder in a page:
			var finder = new CKFinder();
			finder.BasePath = 'javascript/ckfinder';	// The path for the installation of CKFinder (default = "/ckfinder/").
			// The default height is 400.
			finder.Height = 540;
			finder.SelectFunction = ShowFileInfo;
			// It is not required to use the "v1" skin.
			finder.Skin = 'v1';
			finder.Create(); 

			// It can also be done in a single line, calling the "static"
			// Create( basePath, width, height, selectActionFunction ) function:
			// CKFinder.Create( '../', null, null, ShowFileInfo );
			//
			// The "Create" function can also accept an object as the only argument.
			// CKFinder.Create( { BasePath : '../', Skin : 'v1', SelectActionFunction : ShowFileInfo } );

		</script>
	</div>
  </body>
</html>
