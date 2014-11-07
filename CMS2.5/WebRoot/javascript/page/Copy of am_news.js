//编辑器
var editor;
function initCheck() {
	var plugins = {

	};
	editor = $('#content').xheditor({
		plugins : plugins,
		tools : '',
		loadCSS : '<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>'
	});
}
function init() {
	$("#summary").keyup(function() {
		$("#charCount").html("当前字数：" + $("#summary").val().length + "个");
	});
	$("#title").keyup(function() {
		$("#charTitleCount").html("当前字数：" + $("#title").val().length + "个");
	});

	var plugins = {
		insertImage : {
			c : 'xheditor_tool_image',
			t : '插入图片',
			s : 'ctrl+1',
			e : function() {
				var _this = this;
				window.sector.openForEditor('images', function(url, data) {
					editor.loadBookmark();
					editor.pasteHTML('<a href="icity://image' + url + '" ><img border="0" data="'+url+'"  src="' + url + '" /></a>');
				});
				_this.saveBookmark();
			}
		},
		insertVideo : {
			c : 'xheditor_tool_video',
			t : '插入视频',
			s : 'ctrl+1',
			e : function() {
				var _this = this;
				window.sector.openForEditor('images', function(url, data) {
					editor.loadBookmark();
					editor.pasteHTML('<video preload="auto" width="60" height="80" src="'+url+'" ></video>');
				});
				_this.saveBookmark();
			}
		},
		insertAudio : {
			c : 'xheditor_tool_audio',
			t : '插入音频',
			s : 'ctrl+1',
			e : function() {
				var _this = this;
				window.sector.openForEditor('images', function(url, data) {
					editor.loadBookmark();
					editor.pasteHTML('<video preload="auto" width="60" height="80" src="'+url+'" ></video>');
				});
				_this.saveBookmark();
			}
		}

	};
	editor = $('#content').xheditor({
		plugins : plugins,
		tools : 'insertImage,insertVideo,insertAudio,Source,Fullscreen',
		loadCSS : '<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>'
	});
}
//function imagecallback(data) {
//	editor.loadBookmark();
//	editor.pasteHTML('<img border="0"  src="' + data.path + '" />');
//	return false;
//}
function addRelated(title, container) {
	$.dialog.data('container', container);
	var url = 'url:jsp/article/ArticleSelctor.jsp';
//	if (container == '#newsContainer')
//		url = 'url:jsp/article/NewsSelctor.jsp';
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
	$("#container li").each(function(index) {
		$(this).append('<input type="hidden" value="' + $(this).attr('id') + '" name="relatedArticles[' + index + '].id" />');
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
