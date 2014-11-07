//编辑器
var editor;
function initCheck() {
	editor = CKEDITOR.replace("content", {
		toolbar : 'MyBasic',
		height : 300,
		width : 575,
		fullPage : true,
		allowedContent : true
	});
	setTimeout(function() {
		editor.setReadOnly(true);
	}, 1000);
}
function init() {
	$("#summary").keyup(function() {
		$("#charCount").html("当前字数：" + $("#summary").val().length + "个");
	});
	$("#title").keyup(function() {
		$("#charTitleCount").html("当前字数：" + $("#title").val().length + "个");
	});
	$( '#content' ).ckeditor(function(){},{
		toolbar : 'MyBasic',
		height : 300,
		width : 575,
		fullPage : true,
		allowedContent : true
	});

	/*$("input[type='radio'][name='textType']").click(function() {
		if ($(this).val() == 0) {
			$( '#content' ).ckeditor(function(){},{
				toolbar : 'MyBasic',
				height : 300,
				width : 575,
				fullPage : false,
				allowedContent : true
			});
		} else {
			$( '#content' ).ckeditor(function(){},{
				toolbar : 'MyBasic',
				height : 300,
				width : 575,
				fullPage : true,
				allowedContent : true
			});
		}
	});*/
}

// function imagecallback(data) {
// editor.loadBookmark();
// editor.pasteHTML('<img border="0" src="' + data.path + '" />');
// return false;
// }
function addRelated(title, container) {
	$.dialog.data('container', container);
	var url = 'url:jsp/article/ArticleSelctor.jsp';
	// if (container == '#newsContainer')
	// url = 'url:jsp/article/NewsSelctor.jsp';
	$.dialog({
		title : title,
		width : '900px',
		height : '500px',
		content : url,
		max : false,
		min : false
	});
}
function adjustRelated() {
	$("#container li").each(
			function(index) {
				$(this).append(
						'<input type="hidden" value="' + $(this).attr('id')
								+ '" name="relatedArticles[' + index
								+ '].id" />');
			});
}
function save() {
	adjustRelated();
	$("#ContentForm").attr('action', 'ArticleMobileNewsAction!save.action');
	$("#ContentForm").submit();
}
function update() {
	$("#ContentForm").attr('action', 'ArticleMobileNewsAction!update.action');
	$("#ContentForm").submit();
}
