/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.language = 'zh-cn';
	 
	config.toolbar_MyBasic = [
		['Source','Preview','Maximize' ],
		['-','Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
		['-','tanjun1536image','tanjun1536audio','tanjun1536video' ]
	];
 
	//config.extraPlugins += (config.extraPlugins ? ',abbr' : 'abbr');
	config.extraPlugins = 'tanjun1536image';
	config.extraPlugins += ',tanjun1536audio';
	config.extraPlugins += ',tanjun1536video';
	config.fullPage = true;
	config.protectedSource.push(/<\s*embed[\s\S]*?>/gi);
	config.protectedSource.push(/<\?[\s\S]*?\?>/g );                                           // PHP code
	config.protectedSource.push(/<%[\s\S]*?%>/g );   
	config.allowedContent=true;
	config.forceSimpleAmpersand = true;
};
