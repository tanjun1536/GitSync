(function($){
	SelImg = {};
	SelImg.show=function(callback){
		$.dialog({id:'SelImageID', title:"图片选择器", lock:true, width: '900px', height: '500px', content: ('url:jsp/imgcontent/selimg.jsp?fun=' + callback)});
	};
	SelImg.closeDialog=function(){
		$.dialog({id:'SelImageID'}).close();
	};
	
	
})(jQuery);

window.document.writeln("<script type=\"text/javascript\" src=\"javascript/lhgdialog/lhgcore.lhgdialog.min.js?skin=blue\"></script>");

function browse(callback)
{
	SelImg.show(callback);
}