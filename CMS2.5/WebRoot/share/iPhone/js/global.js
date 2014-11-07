function down() {
	var imgs = new Array();
	$("img").each(function(index) {
		imgs.push($(this).attr('data'));
	});
	// 要下载的图片
	var s = imgs.join(':');

	return s;
}

// 要显示图片的名字
function show(name) {
	$("img[data='" + name + "']").attr("src", name);
}