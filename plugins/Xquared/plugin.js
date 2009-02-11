
function loadXq() {
	var xed = new xq.Editor('post_body');
	xed.config.autoFocusOnInit = true;
	xed.config.urlValidationMode = 'host_relative';
	xed.config.changeCursorOnLink = true;
	xed.config.imagePathForDefaultToolbar = XquaredPluginUri + '/xquared/images/toolbar/';
	xed.config.imagePathForContent = XquaredPluginUri + '/xquared/images/content/';
	xed.config.imagePathForDialog = XquaredPluginUri + '/xquared/images/dialogs/';
	xed.config.imagePathForEmoticon = XquaredPluginUri + '/xquared/images/dialogs/emoticon/';
	xed.config.contentCssList = [XquaredPluginUri + '/xquared/stylesheets/xq_contents.css'];

	xed.addPlugin('Springnote');
	xed.addPlugin('EditorResize');
	xed.addPlugin('Macro');
	xed.addPlugin('FlashMovieMacro');
	xed.addPlugin('IFrameMacro');
//	xed.addPlugin('JavascriptMacro');

	xed.setEditMode('wysiwyg');

	setPostAttribute(document.getElementById('post_body').form, 'format', 'xquared-html');
	xed.focus();
}

if(Event && Event.observe)
	Event.observe(window, 'load', loadXq);
else if(window.addEvent)
	window.addEvent('domready', loadXq);
else {
	window.__old_onload = window.onload;
	window.onload = function() {
		var r = window.__old_onload && window.__old_onload();
		loadXq();
		return r;
	};
}
