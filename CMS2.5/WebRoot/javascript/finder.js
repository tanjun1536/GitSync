(function() {
	window.sector = new Object();
	window.sector.openOnlyVideo=function(video)
	{
		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();

		// The path for the installation of CKFinder (default = "/ckfinder/").
		//finder.basePath = '/';

		//Startup path in a form: "Type:/path/to/directory/"
		finder.startupPath = 'Files:/videos';

		// Name of a function which is called when a file is selected in CKFinder.
		finder.selectActionFunction = function(url,data){
			$(video).attr("src",url);
		};

		// Additional data to be passed to the selectActionFunction in a second argument.
		// We'll use this feature to pass the Id of a field that will be updated.
		//finder.selectActionData = functionData;

		// Name of a function which is called when a thumbnail is selected in CKFinder.
		//finder.selectThumbnailActionFunction = ShowThumbnails;

		// Launch CKFinder
		finder.popup();
	},
	window.sector.openOnlyImage=function(image)
	{
		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();

		// The path for the installation of CKFinder (default = "/ckfinder/").
		//finder.basePath = '/';

		//Startup path in a form: "Type:/path/to/directory/"
		finder.startupPath = 'Files:/images';

		// Name of a function which is called when a file is selected in CKFinder.
		finder.selectActionFunction = function(url,data){
			$(image).attr("src",url);
		};

		// Additional data to be passed to the selectActionFunction in a second argument.
		// We'll use this feature to pass the Id of a field that will be updated.
		//finder.selectActionData = functionData;

		// Name of a function which is called when a thumbnail is selected in CKFinder.
		//finder.selectThumbnailActionFunction = ShowThumbnails;

		// Launch CKFinder
		finder.popup();
	},
	window.sector.open=function(start,input,image)
	{
		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();

		// The path for the installation of CKFinder (default = "/ckfinder/").
		//finder.basePath = '/';

		//Startup path in a form: "Type:/path/to/directory/"
		finder.startupPath = 'Files:/'+start;

		// Name of a function which is called when a file is selected in CKFinder.
		finder.selectActionFunction = function(url,data){
			$(input).val(url);
			$(image).attr("src",url);
		};

		// Additional data to be passed to the selectActionFunction in a second argument.
		// We'll use this feature to pass the Id of a field that will be updated.
		//finder.selectActionData = functionData;

		// Name of a function which is called when a thumbnail is selected in CKFinder.
		//finder.selectThumbnailActionFunction = ShowThumbnails;

		// Launch CKFinder
		finder.popup();
	},
	window.sector.openForEditor=function(start,callback)
	{
		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();

		// The path for the installation of CKFinder (default = "/ckfinder/").
		//finder.basePath = '/';

		//Startup path in a form: "Type:/path/to/directory/"
		finder.startupPath = 'Files:/'+start;

		// Name of a function which is called when a file is selected in CKFinder.
		finder.selectActionFunction = callback;

		// Additional data to be passed to the selectActionFunction in a second argument.
		// We'll use this feature to pass the Id of a field that will be updated.
		//finder.selectActionData = functionData;

		// Name of a function which is called when a thumbnail is selected in CKFinder.
		//finder.selectThumbnailActionFunction = ShowThumbnails;

		// Launch CKFinder
		finder.popup();
	}

})(jQuery);
