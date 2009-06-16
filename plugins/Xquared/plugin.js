
function loadXq() {
	var xed = new xq.Editor('post_body');
	xed.config.autoFocusOnInit = true;
	xed.config.urlValidationMode = 'host_relative';
	xed.config.changeCursorOnLink = true;
	xed.config.imagePathForDefaultToolbar = XquaredPluginUri + '/images/toolbar/';
	xed.config.imagePathForContent = XquaredPluginUri + '/images/content/';
	xed.config.imagePathForDialog = XquaredPluginUri + '/images/dialogs/';
	xed.config.imagePathForEmoticon = XquaredPluginUri + '/images/dialogs/emoticon/';
	xed.config.contentCssList = [XquaredPluginUri + '/stylesheets/xq_contents.css'];

/* absolute path patch for Xquared Client 20090206 : start */
	if(xq.minorVersion == '20090206') {
		xed.config.defaultToolbarButtonGroups = {
			"color": [
				{className:"foregroundColor", title:"Foreground color", list:[
					{style: {backgroundColor:"#ffd8d8"}, handler:"xed.handleForegroundColor('#ffd8d8')"},
					{style: {backgroundColor:"#ffead9"}, handler:"xed.handleForegroundColor('#ffead9')"},
					{style: {backgroundColor:"#fef2dc"}, handler:"xed.handleForegroundColor('#fef2dc')"},
					{style: {backgroundColor:"#fff5da"}, handler:"xed.handleForegroundColor('#fff5da')"},
					{style: {backgroundColor:"#eefed9"}, handler:"xed.handleForegroundColor('#eefed9')"},
					{style: {backgroundColor:"#dafeda"}, handler:"xed.handleForegroundColor('#dafeda')"},
					{style: {backgroundColor:"#d8ffff"}, handler:"xed.handleForegroundColor('#d8ffff')"},
					{style: {backgroundColor:"#d9f7ff"}, handler:"xed.handleForegroundColor('#d9f7ff')"},
					{style: {backgroundColor:"#d5ebff"}, handler:"xed.handleForegroundColor('#d5ebff')"},
					{style: {backgroundColor:"#eed8ff"}, handler:"xed.handleForegroundColor('#eed8ff')"},
					{style: {backgroundColor:"#fed8ff"}, handler:"xed.handleForegroundColor('#fed8ff')"},
					{style: {backgroundColor:"#ffffff"}, handler:"xed.handleForegroundColor('#ffffff')"},

					{style: {backgroundColor:"#fe8c8c"}, handler:"xed.handleForegroundColor('#fe8c8c')"},
					{style: {backgroundColor:"#feba8d"}, handler:"xed.handleForegroundColor('#feba8d')"},
					{style: {backgroundColor:"#ffe88b"}, handler:"xed.handleForegroundColor('#ffe88b')"},
					{style: {backgroundColor:"#ffff8d"}, handler:"xed.handleForegroundColor('#ffff8d')"},
					{style: {backgroundColor:"#d0fc8d"}, handler:"xed.handleForegroundColor('#d0fc8d')"},
					{style: {backgroundColor:"#8efb8e"}, handler:"xed.handleForegroundColor('#8efb8e')"},
					{style: {backgroundColor:"#8bffff"}, handler:"xed.handleForegroundColor('#8bffff')"},
					{style: {backgroundColor:"#8ce8ff"}, handler:"xed.handleForegroundColor('#8ce8ff')"},
					{style: {backgroundColor:"#8b8cff"}, handler:"xed.handleForegroundColor('#8b8cff')"},
					{style: {backgroundColor:"#d18cff"}, handler:"xed.handleForegroundColor('#d18cff')"},
					{style: {backgroundColor:"#ff8bfe"}, handler:"xed.handleForegroundColor('#ff8bfe')"},
					{style: {backgroundColor:"#cccccc"}, handler:"xed.handleForegroundColor('#cccccc')"},

					{style: {backgroundColor:"#ff0103"}, handler:"xed.handleForegroundColor('#ff0103')"},
					{style: {backgroundColor:"#ff6600"}, handler:"xed.handleForegroundColor('#ff6600')"},
					{style: {backgroundColor:"#ffcc01"}, handler:"xed.handleForegroundColor('#ffcc01')"},
					{style: {backgroundColor:"#ffff01"}, handler:"xed.handleForegroundColor('#ffff01')"},
					{style: {backgroundColor:"#96f908"}, handler:"xed.handleForegroundColor('#96f908')"},
					{style: {backgroundColor:"#07f905"}, handler:"xed.handleForegroundColor('#07f905')"},
					{style: {backgroundColor:"#02feff"}, handler:"xed.handleForegroundColor('#02feff')"},
					{style: {backgroundColor:"#00ccff"}, handler:"xed.handleForegroundColor('#00ccff')"},
					{style: {backgroundColor:"#0100fe"}, handler:"xed.handleForegroundColor('#0100fe')"},
					{style: {backgroundColor:"#9801ff"}, handler:"xed.handleForegroundColor('#9801ff')"},
					{style: {backgroundColor:"#fc01fe"}, handler:"xed.handleForegroundColor('#fc01fe')"},
					{style: {backgroundColor:"#999999"}, handler:"xed.handleForegroundColor('#999999')"},

					{style: {backgroundColor:"#990002"}, handler:"xed.handleForegroundColor('#990002')"},
					{style: {backgroundColor:"#b65006"}, handler:"xed.handleForegroundColor('#b65006')"},
					{style: {backgroundColor:"#bf7900"}, handler:"xed.handleForegroundColor('#bf7900')"},
					{style: {backgroundColor:"#cca500"}, handler:"xed.handleForegroundColor('#cca500')"},
					{style: {backgroundColor:"#5a9603"}, handler:"xed.handleForegroundColor('#5a9603')"},
					{style: {backgroundColor:"#059502"}, handler:"xed.handleForegroundColor('#059502')"},
					{style: {backgroundColor:"#009997"}, handler:"xed.handleForegroundColor('#009997')"},
					{style: {backgroundColor:"#007998"}, handler:"xed.handleForegroundColor('#007998')"},
					{style: {backgroundColor:"#095392"}, handler:"xed.handleForegroundColor('#095392')"},
					{style: {backgroundColor:"#6a19a4"}, handler:"xed.handleForegroundColor('#6a19a4')"},
					{style: {backgroundColor:"#98019a"}, handler:"xed.handleForegroundColor('#98019a')"},
					{style: {backgroundColor:"#666666"}, handler:"xed.handleForegroundColor('#666666')"},

					{style: {backgroundColor:"#590100"}, handler:"xed.handleForegroundColor('#590100')"},
					{style: {backgroundColor:"#773505"}, handler:"xed.handleForegroundColor('#773505')"},
					{style: {backgroundColor:"#7f5000"}, handler:"xed.handleForegroundColor('#7f5000')"},
					{style: {backgroundColor:"#927300"}, handler:"xed.handleForegroundColor('#927300')"},
					{style: {backgroundColor:"#365802"}, handler:"xed.handleForegroundColor('#365802')"},
					{style: {backgroundColor:"#035902"}, handler:"xed.handleForegroundColor('#035902')"},
					{style: {backgroundColor:"#01595a"}, handler:"xed.handleForegroundColor('#01595a')"},
					{style: {backgroundColor:"#00485b"}, handler:"xed.handleForegroundColor('#00485b')"},
					{style: {backgroundColor:"#083765"}, handler:"xed.handleForegroundColor('#083765')"},
					{style: {backgroundColor:"#370159"}, handler:"xed.handleForegroundColor('#370159')"},
					{style: {backgroundColor:"#59005a"}, handler:"xed.handleForegroundColor('#59005a')"},
					{style: {backgroundColor:"#000000"}, handler:"xed.handleForegroundColor('#000000')"}
				]},
				
				{className:"backgroundColor", title:"Background color", list:[
					{style: {backgroundColor:"#FFF700"}, handler:"xed.handleBackgroundColor('#FFF700')"},
					{style: {backgroundColor:"#AEFF66"}, handler:"xed.handleBackgroundColor('#AEFF66')"},
					{style: {backgroundColor:"#FFCC66"}, handler:"xed.handleBackgroundColor('#FFCC66')"},
					{style: {backgroundColor:"#DCB0FB"}, handler:"xed.handleBackgroundColor('#DCB0FB')"},
					{style: {backgroundColor:"#B0EEFB"}, handler:"xed.handleBackgroundColor('#B0EEFB')"},
					{style: {backgroundColor:"#FBBDB0"}, handler:"xed.handleBackgroundColor('#FBBDB0')"},
					{style: {backgroundColor:"#FFFFFF"}, handler:"xed.handleBackgroundColor('#FFFFFF')"}
				]}
			],
			
			"font": [
				{className:"fontFace", title:"Font face", list:[
					{html:"Arial", style: {fontFamily: "Arial"}, handler:"xed.handleFontFace('Arial')"},
					{html:"Comic Sans MS", style: {fontFamily: "Comic Sans MS"}, handler:"xed.handleFontFace('Comic Sans MS')"},
					{html:"Courier New", style: {fontFamily: "Courier New"}, handler:"xed.handleFontFace('Courier New')"},
					{html:"Georgia", style: {fontFamily: "Georgia"}, handler:"xed.handleFontFace('Georgia')"},
					{html:"Tahoma", style: {fontFamily: "Tahoma"}, handler:"xed.handleFontFace('Tahoma')"},
					{html:"Times", style: {fontFamily: "Times"}, handler:"xed.handleFontFace('Times')"},
					{html:"Trebuchte MS", style: {fontFamily: "Trebuchte MS"}, handler:"xed.handleFontFace('Trebuchte MS')"},
					{html:"Verdana", style: {fontFamily: "Verdana"}, handler:"xed.handleFontFace('Verdana')"}
				]},
				
				{className:"fontSize", title:"Font size", list:[
					{html:"Lorem ipsum dolor (8pt)", style: {fontSize: "8pt", marginBottom: "3px"}, handler:"xed.handleFontSize('1')"},
					{html:"Lorem ipsum dolor (10pt)", style: {fontSize: "10pt", marginBottom: "3px"}, handler:"xed.handleFontSize('2')"},
					{html:"Lorem ipsum dolor (12pt)", style: {fontSize: "12pt", marginBottom: "6px"}, handler:"xed.handleFontSize('3')"},
					{html:"Lorem ipsum dolor (14pt)", style: {fontSize: "14pt", marginBottom: "10px"}, handler:"xed.handleFontSize('4')"},
					{html:"Lorem ipsum dolor (18pt)", style: {fontSize: "18pt", marginBottom: "16px"}, handler:"xed.handleFontSize('5')"},
					{html:"Lorem ipsum dolor (24pt)", style: {fontSize: "24pt", marginBottom: "6px"}, handler:"xed.handleFontSize('6')"}
				]}
			],
			"link": [
				{className:"link", title:"Link", handler:"xed.handleLink()"},
				{className:"removeLink", title:"Remove link", handler:"xed.handleRemoveLink()"}
			],
			"style": [
				{className:"strongEmphasis", title:"Strong emphasis", handler:"xed.handleStrongEmphasis()"},
				{className:"emphasis", title:"Emphasis", handler:"xed.handleEmphasis()"},
				{className:"underline", title:"Underline", handler:"xed.handleUnderline()"},
				{className:"strike", title:"Strike", handler:"xed.handleStrike()"},
				{className:"superscription", title:"Superscription", handler:"xed.handleSuperscription()"},
				{className:"subscription", title:"Subscription", handler:"xed.handleSubscription()"},
				{className:"removeFormat", title:"Remove format", handler:"xed.handleRemoveFormat()"}
			],
			"justification": [
				{className:"justifyLeft", title:"Justify left", handler:"xed.handleJustify('left')"},
				{className:"justifyCenter", title:"Justify center", handler:"xed.handleJustify('center')"},
				{className:"justifyRight", title:"Justify right", handler:"xed.handleJustify('right')"},
				{className:"justifyBoth", title:"Justify both", handler:"xed.handleJustify('both')"}
			],
			"indentation": [
				{className:"indent", title:"Indent", handler:"xed.handleIndent()"},
				{className:"outdent", title:"Outdent", handler:"xed.handleOutdent()"}
			],
			"block": [
				{className:"paragraph", title:"Paragraph", handler:"xed.handleApplyBlock('P')"},
				{className:"heading1", title:"Heading 1", list:[
					{html:"Heading1", style: {fontSize: "2.845em", marginBottom: "3px"}, handler:"xed.handleApplyBlock('H1')"},
					{html:"Heading2", style: {fontSize: "2.46em", marginBottom: "3px"}, handler:"xed.handleApplyBlock('H2')"},
					{html:"Heading3", style: {fontSize: "2.153em", marginBottom: "3px"}, handler:"xed.handleApplyBlock('H3')"},
					{html:"Heading4", style: {fontSize: "1.922em", marginBottom: "3px"}, handler:"xed.handleApplyBlock('H4')"},
					{html:"Heading5", style: {fontSize: "1.461em", marginBottom: "3px"}, handler:"xed.handleApplyBlock('H5')"},
					{html:"Heading6", style: {fontSize: "1.23em", marginBottom: "3px"}, handler:"xed.handleApplyBlock('H6')"}
				]},
				{className:"blockquote", title:"Blockquote", handler:"xed.handleApplyBlock('BLOCKQUOTE')"},
	//			{className:"code", title:"Code", handler:"xed.handleList('OL', 'code')"},
				{className:"division", title:"Division", handler:"xed.handleApplyBlock('DIV')"},
				{className:"unorderedList", title:"Unordered list", handler:"xed.handleList('UL')"},
				{className:"orderedList", title:"Ordered list", handler:"xed.handleList('OL')"}
			],
			"insert": [
				{className:"table", title:"Table", handler:"xed.handleTable({'rows':4, 'cols':4, 'headerPositions':'tl'})"},
				{className:"separator", title:"Separator", handler:"xed.handleSeparator()"},
				{className:"emoticon", title:"Emoticon", list: [
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/num1.gif' />", handler:"xed.handleEmoticon('num1.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/num2.gif' />", handler:"xed.handleEmoticon('num2.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/num3.gif' />", handler:"xed.handleEmoticon('num3.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/num4.gif' />", handler:"xed.handleEmoticon('num4.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/num5.gif' />", handler:"xed.handleEmoticon('num5.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/question.gif' />", handler:"xed.handleEmoticon('question.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/disk.gif' />", handler:"xed.handleEmoticon('disk.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/play.gif' />", handler:"xed.handleEmoticon('play.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/flag1.gif' />", handler:"xed.handleEmoticon('flag1.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/flag2.gif' />", handler:"xed.handleEmoticon('flag2.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/flag3.gif' />", handler:"xed.handleEmoticon('flag3.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/flag4.gif' />", handler:"xed.handleEmoticon('flag4.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/arrow_left.gif' />", handler:"xed.handleEmoticon('arrow_left.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/arrow_right.gif' />", handler:"xed.handleEmoticon('arrow_right.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/arrow_up.gif' />", handler:"xed.handleEmoticon('arrow_up.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/arrow_down.gif' />", handler:"xed.handleEmoticon('arrow_down.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/step1.gif' />", handler:"xed.handleEmoticon('step1.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/step2.gif' />", handler:"xed.handleEmoticon('step2.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/step3.gif' />", handler:"xed.handleEmoticon('step3.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/note.gif' />", handler:"xed.handleEmoticon('note.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/heart.gif' />", handler:"xed.handleEmoticon('heart.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/good.gif' />", handler:"xed.handleEmoticon('good.gif')"},
					{html:"<img src='" + XquaredPluginUri + "/images/dialogs/emoticon/bad.gif' />", handler:"xed.handleEmoticon('bad.gif')"}
				]}
			]
		};

		xed.config.defaultToolbarButtonMap = [
			xed.config.defaultToolbarButtonGroups.font,
			xed.config.defaultToolbarButtonGroups.color,
			xed.config.defaultToolbarButtonGroups.style,
			xed.config.defaultToolbarButtonGroups.justification,
			xed.config.defaultToolbarButtonGroups.indentation,
			xed.config.defaultToolbarButtonGroups.block,
			xed.config.defaultToolbarButtonGroups.link,
			xed.config.defaultToolbarButtonGroups.insert,
			[
				{className:"html", title:"Edit source", handler:"xed.toggleSourceAndWysiwygMode()"}
			],
			[
				{className:"undo", title:"Undo", handler:"xed.handleUndo()"},
				{className:"redo", title:"Redo", handler:"xed.handleRedo()"}
			]
		];

		if(!xq) xq = {};
		if(!xq.ui_templates) xq.ui_templates = {};

		xq.ui_templates.basicColorPickerDialog='<form action="#" class="xqFormDialog xqBasicColorPickerDialog">\n		<div>\n			<label>\n				<input type="radio" class="initialFocus" name="color" value="black" checked="checked" />\n				<span style="color: black;">Black</span>\n			</label>\n			<label>\n				<input type="radio" name="color" value="red" />\n				<span style="color: red;">Red</span>\n			</label>\n				<input type="radio" name="color" value="yellow" />\n				<span style="color: yellow;">Yellow</span>\n			</label>\n			</label>\n				<input type="radio" name="color" value="pink" />\n				<span style="color: pink;">Pink</span>\n			</label>\n			<label>\n				<input type="radio" name="color" value="blue" />\n				<span style="color: blue;">Blue</span>\n			</label>\n			<label>\n				<input type="radio" name="color" value="green" />\n				<span style="color: green;">Green</span>\n			</label>\n			\n			<input type="submit" value="Ok" />\n			<input type="button" class="cancel" value="Cancel" />\n		</div>\n	</form>';
		if(!xq) xq = {};
		if(!xq.ui_templates) xq.ui_templates = {};

		xq.ui_templates.basicIFrameDialog='<form id="iframeDialog" class="xqFormDialog modal">\n		<h3>Insert IFrame</h3>\n		<div class="dialog-content">\n			<p>IFrame src: <input type="text" class="initialFocus type-text" name="p_src" size="36" value="http://" /></p>\n			<p>Width: <input type="text" class="type-text" name="p_width" size="6" value="320" /></p>\n			<p>Height: <input type="text" class="type-text" name="p_height" size="6" value="200" /></p>\n			<p>Frame border:\n				<select name="p_frameborder">\n					<option value="0" selected="selected">No</option>\n					<option value="1">Yes</option>\n				</select></p>\n			<p>Scrolling: \n				<select name="p_scrolling">\n					<option value="0">No</option>\n					<option value="1" selected="selected">Yes</option>\n				</select></p>\n			<p>ID(optional): <input type="text" class="type-text" name="p_id" size="24" value="" /></p>\n			<p>Class(optional): <input type="text" class="type-text" name="p_class" size="24" value="" /></p>\n			\n			<div class="dialog-buttons">\n				<a href="#" class="button-white cancel">Close</a>\n				<a href="#" class="button-gray submit">Insert</a>\n			</div>\n		</div>\n		<a href="#" class="cancel close-dialog"><img src="' + XquaredPluginUri + '/images/dialogs/icon_close.gif" alt="close" /></a>\n	</form>';
		if(!xq) xq = {};
		if(!xq.ui_templates) xq.ui_templates = {};

		xq.ui_templates.basicLinkDialog='<form id="linkDialog" class="xqFormDialog lightweight" action="#">\n		<h3>link</h3>\n		<div class="dialog-content">\n			<p>Please enter the URL and label.</p>\n			<input type="text" name="text" class="type-text initialFocus" value="" />\n			<input type="text" name="url" class="type-text" value="http://" />\n			<div class="dialog-buttons">\n				<a href="#" class="button-white cancel">Cancel</a>\n				<a href="#" class="button-gray submit">Create</a>\n			</div>\n		</div>\n	</form>';
		if(!xq) xq = {};
		if(!xq.ui_templates) xq.ui_templates = {};

		xq.ui_templates.basicMovieDialog='<form id="videoDialog" class="xqFormDialog modal">\n		<h3>Insert Movie</h3>\n		<div class="dialog-content">\n			<p>Insert an Embed code to add a movie clip from YouTube, Yahoo video, vimeo and slideshare.</p>\n			<textarea class="initialFocus" name="html"></textarea>\n			<div class="dialog-buttons">\n				<a href="#" class="button-white cancel">Close</a>\n				<a href="#" class="button-gray submit">Insert</a>\n			</div>\n		</div>\n		<a href="#" class="cancel close-dialog"><img src="' + XquaredPluginUri + '/images/dialogs/icon_close.gif" alt="close" /></a>\n	</form>';
		if(!xq) xq = {};
		if(!xq.ui_templates) xq.ui_templates = {};

		xq.ui_templates.basicScriptDialog='<form id="scriptDialog" class="xqFormDialog modal">\n		<h3>Insert Script</h3>\n		<div class="dialog-content">\n			<p>Script URL:\n			<input type="text" class="initialFocus" class="type-text" name="url" size="36" value="http://" /></p>\n			<div class="dialog-buttons">\n				<a href="#" class="button-white cancel">Close</a>\n				<a href="#" class="button-gray submit">Insert</a>\n			</div>\n		</div>\n		<a href="#" class="cancel close-dialog"><img src="' + XquaredPluginUri + '/images/dialogs/icon_close.gif" alt="close" /></a>\n	</form>';
	}
/* absolute path patch for Xquared Client 20090206 : end */

	xed.addPlugin('Springnote');
	xed.addPlugin('EditorResize');
	xed.addPlugin('Macro');
	xed.addPlugin('FlashMovieMacro');
	xed.addPlugin('IFrameMacro');
//	xed.addPlugin('JavascriptMacro');
	xed.setEditMode('wysiwyg');

	setPostAttribute(document.getElementById('post_body').form, 'format', 'xquared-html');
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
