/**
 * Basic sample plugin inserting abbreviation elements into CKEditor editing
 * area.
 * 
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add('tanjun1536video', {

	// Register the icons.
	icons : 'tanjun1536video',

	// The plugin initialization logic goes inside this method.
	init : function(editor) {

		// Define an editor command that opens our dialog.
		editor.addCommand('tanjun1536video', {
			exec : function(editor) {
				window.sector.openForEditor('images', function(url, data) {
					var element = CKEDITOR.dom.element
							.createFromHtml('<a href="icity://image' + url
									+ '" ><img border="0" data="' + url
									+ '"  src="' + url + '" /></a>');
					editor.insertElement(element);
				});

			}
		});

		// Create a toolbar button that executes the above
		// command.
		editor.ui.addButton('tanjun1536video', {

			// The text part of the button (if available) and
			// tooptip.
			label : '插入视频',

			// The command to execute on click.
			command : 'tanjun1536video',

			// The button placement in the toolbar (toolbar
			// group name).
			toolbar : 'insert'
		});
	}
});
