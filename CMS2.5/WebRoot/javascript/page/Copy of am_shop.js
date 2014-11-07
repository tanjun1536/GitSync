function init(edit) {
	initTab(false);
	if (edit)
		initIV();
}
function initCheck() {
	initTab(true);
	initIV();
}
function initTab(isCheck) {
	var option = {
		fx : {
			opacity : 'toggle'
		},
		add : addEventHandler,
		selected : 2
	};
	if (isCheck)
		option = {
			fx : {
				opacity : 'toggle'
			},
			selected : 2
		};
	$("#images").tabs(option);
	$("#videos").tabs(option);
}

function initIV() {
	var group;
	if (imagesGroups) {
		for ( var i = 0; i < imagesGroups.length; i++) {
			group = imagesGroups[i];
			addGroupByName('images', group.name);
			if (group.images) {
				for ( var j = 0; j < group.images.length; j++) {
					addFileByURLAndDesc('images', group.images[j].url, group.images[j].des);
				}
			}
		}
	}
	if (videosGroups) {
		for ( var i = 0; i < videosGroups.length; i++) {
			group = videosGroups[i];
			addGroupByName('videos', group.name);
			if (group.videos) {
				for ( var j = 0; j < group.videos.length; j++) {
					addFileByURLAndDesc('videos', group.videos[j].url, group.videos[j].des);
				}
			}
		}
	}
}
function addGroupByName(container, group) {
	var jqContainer = '#' + container;
	var tabCount = $(jqContainer).tabs("length") + 1;
	var index = tabCount - 1;
	if (group != null) {
		$('<div id="' + container + '-' + tabCount + '" style="height:140px;" class="list_carousel"><ul class="mvbox"></ul><div class="clearfix"></div><a id="' + container + '-prev' + tabCount + '" class="prev hidden" href="#" style="display:none;">&lt;</a> <a id="' + container + '-next' + tabCount + '" class="next hidden" style="display:none;" href="#">&gt;</a><div id="' + container + '-pager' + tabCount + '" class="pager"></div></div>').appendTo(jqContainer);
		$(jqContainer).tabs("add", jqContainer + "-" + tabCount, group);
		tabCount--;
		$(jqContainer).tabs("select", tabCount);
	}

}
function addGroup(container) {
	var jqContainer = '#' + container;
	var tabCount = $(jqContainer).tabs("length") + 1;
	var index = tabCount - 1;
	$.dialog.prompt('请输入分组名称', function(group) {
		if (group != null) {
			$('<div id="' + container + '-' + tabCount + '" style="height:140px;" class="list_carousel"><ul class="mvbox"></ul><div class="clearfix"></div><a id="' + container + '-prev' + tabCount + '" class="prev hidden" href="#" style="display:none;">&lt;</a> <a id="' + container + '-next' + tabCount + '" class="next hidden" style="display:none;" href="#">&gt;</a><div id="' + container + '-pager' + tabCount + '" class="pager"></div></div>').appendTo(jqContainer);
			$(jqContainer).tabs("add", jqContainer + "-" + tabCount, group);
			tabCount--;
			$(jqContainer).tabs("select", tabCount);
		}
	}, '');

}
function addFileByURLAndDesc(container, url, desc) {
	var jqContainer = '#' + container;
	var selected = $(jqContainer).tabs('option', 'selected');
	selected++;
	var prev = jqContainer + '-prev' + selected;
	var next = jqContainer + '-next' + selected;
	var pager = jqContainer + '-pager' + selected;
	var content = '<li  style="width:60px;"><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;" /><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;" /><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;" /><img  width="60" height="80" src="' + url + '" alt="picture"> <span>' + desc + '</span></li>';
	if (container == 'videos')
		content = '<li  style="width:60px;"><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;" /><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;" /><img onclick="$(this).parent().remove();" title="删除图片" src="images/close.png" style="cursor:pointer;" /><video preload="auto" width="60" height="80" src="' + url + '" ></video> <span>' + desc + '</span></li>';
	$(jqContainer + '-' + selected + ' .mvbox').append(content).carouFredSel({
		width : "575px",
		height : "122px",
		circular : false,
		infinite : false,
		direction : "left",
		auto : false,
		prev : prev,
		next : next,
		pagination : pager,
		mousewheel : true,
		scroll : 6,
		swipe : {
			onMouse : true,
			onTouch : true
		}
	});
	$(".caroufredsel_wrapper").height(122).width(575);
	$(".mvbox").height(122).width(575);
}
function addFile(container) {
	var jqContainer = '#' + container;
	var selected = $(jqContainer).tabs('option', 'selected');
	selected++;
	$.dialog.data('tabObj', $(jqContainer + '-' + selected + ' .mvbox'));
	$.dialog.data('tabIndex', selected);
	var url = 'url:jsp/article/ImageSelctor.jsp';
	if (container == 'videos')
		url = 'url:jsp/article/VideoSelctor.jsp';
	$.dialog({
		title : '图片选择',
		width : '450px',
		height : '400px',
		content : url,
		max : false,
		min : false
	});
}
function addEventHandler(event, ui) {
	var li = $(ui.tab).parent();
	var tabs = li.parent().parent();
	// if(li.find('a').text()=='添加') return;
	$('<img src="images/close.png"/>') // 关闭按钮
	.appendTo(li).hover(function() {
		var img = $(this);
		img.attr('src', 'images/close.png');
	}, function() {
		var img = $(this);
		img.attr('src', 'images/close.png');
	}).click(function() { // 关闭按钮,关闭事件绑定
		var li = $(ui.tab).parent();
		var index = $('#tabs li').index(li.get(0));
		tabs.tabs("remove", index);
		var tabCount = tabs.tabs("length");
		tabs.tabs('select', tabCount);
	});
	$(ui.tab).dblclick(function() { // 双击关闭事件绑定
		var li = $(ui.tab).parent();
		var index = $('#tabs li').index(li.get(0));
		tabs.tabs("remove", index);
		var tabCount = tabs.tabs("length");
		tabs.tabs('select', tabCount);
	});

}
function adjust() {
	adjustGroup('images');
	adjustImageFile();
	adjustGroup('videos');
	adjustVideoFile();
}
function adjustGroup(container) {
	$("#" + container + " ul li").each(function(index) {
		var span = $(this).find("a span");
		if (span.length > 0) {
			var idx = index - 2;
			$('<input type="hidden" name="' + container + 'Groups[' + idx + '].name" value="' + span.html() + '" />').appendTo(this);
			// alert($(this).html());
		}

	});
}
function adjustImageFile() {
	$("#images div .caroufredsel_wrapper").each(function(j) {
		$(this).find("ul li").each(function(k) {
			var url = $(this).find("img:last").attr("src");
			var desc = $(this).find("span").html();
			$('<input type="hidden" name="imagesGroups[' + j + '].images[' + k + '].url" value="' + url + '"/>').appendTo(this);
			$('<input type="hidden" name="imagesGroups[' + j + '].images[' + k + '].des" value="' + desc + '"/>').appendTo(this);

		});

	});
}
function adjustVideoFile() {
	$("#videos div .caroufredsel_wrapper").each(function(j) {
		$(this).find("ul li").each(function(k) {
			var url = $(this).find("video").attr("src");
			var desc = $(this).find("span").html();
			$('<input type="hidden" name="videosGroups[' + j + '].videos[' + k + '].url" value="' + url + '"/>').appendTo(this);
			$('<input type="hidden" name="videosGroups[' + j + '].videos[' + k + '].des" value="' + desc + '"/>').appendTo(this);

		});

	});
}
function addRelated(title, container) {
	$.dialog.data('container', container);
	var url = 'url:jsp/article/GoodsSelctor.jsp';
	if (container == '#newsContainer')
		url = 'url:jsp/article/NewsSelctor.jsp';
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
	$("#newsContainer li").each(function(index) {
		$(this).append('<input type="hidden" value="' + $(this).attr('id') + '" name="relatedNews[' + index + '].id" />');
	});
	$("#goodsContainer li").each(function(index) {
		$(this).append('<input type="hidden" value="' + $(this).attr('id') + '" name="relatedGoods[' + index + '].id" />');
	});
}

function save() {
	adjust();
	adjustRelated();
	$("#ContentForm").attr('action', 'ArticleMobileShopAction!save.action');
	$("#ContentForm").submit();
}
function update() {
	adjust();
	adjustRelated();
	$("#ContentForm").attr('action', 'ArticleMobileShopAction!update.action');
	$("#ContentForm").submit();
}