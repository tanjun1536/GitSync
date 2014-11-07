function initCheck() {
}
function init() {
	$("#summary").keyup(function() {
		$("#charCount").html("当前字数：" + $("#summary").val().length + "个");
	});
	$("#title").keyup(function() {
		$("#charTitleCount").html("当前字数：" + $("#title").val().length + "个");
	});
}
function imagecallback(data) {
	editor.loadBookmark();
	editor.pasteHTML('<img border="0"  src="' + data.path + '" />');
	return false;
}
function save() {
	if (CKEDITOR.instances['content']) {
        delete CKEDITOR.instances['content'];
    }
	$("#ContentForm").attr('action', 'ArticleMobileLinkAction!save.action');
	$("#ContentForm").submit();
}
function update() {
	if (CKEDITOR.instances['content']) {
        delete CKEDITOR.instances['content'];
    }
	$("#ContentForm").attr('action', 'ArticleMobileLinkAction!update.action');
	$("#ContentForm").submit();
}
