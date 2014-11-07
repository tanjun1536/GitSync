(function(win){ 
	window.SectionTree = {};
	window.SectionTree.init = function(id){
		$('#'+id).tree({
			checkbox: false,
			url: 'SectionAction!getSections.action',
			//左键鼠标事件
			onClick:function(node){
//				$(this).tree('toggle', node.target);
//				alert('xx');
//				document.getElementById('ImgContent').src="ImageInfoAction!list.action?imgInfo.section.id=" + node.id;
				$("#ImgContent").attr("src","ImageInfoAction!list.action?imgInfo.section.id=" + node.id);
				//window.open("ImageInfoAction!list.action?imgInfo.section.id=" + node.id, "ImgContent");
			},
			//右键鼠标事件
			onContextMenu: function(e, node){ 
				e.preventDefault();
				$('#tt2').tree('select', node.target);
			}
		});
	};
})(window);