function down() {
	var imgs = new Array();
	$("img[src='../../../resource/html_image_default.jpg']").each(function(index) {
		imgs.push($(this).attr('data'));
	});
	// 要下载的图片
	var s = imgs.join(':');

	return s;
}

// downname下载的全路径
// savename保存在本地的名字
function show(downname, savename) {
	var img=$("img[data='" + downname + "']");
	img.fadeToggle("fast");
	img.attr("src", 'images/' + savename);
	img.fadeToggle("slow");
}