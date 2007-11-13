Form.getSubmitButton = function (form) {
	return form.getInputs('submit')[0];
}

function checkForm(form) {
	var valid = !$(form).getElements().collect(function (el) {
		if (!el.value && !el.hasClassName('ignore')) {
			el.addClassName('blank');
			return false;
		} else {
			el.removeClassName('blank');
			return true;
		}
	}).include(false);

	if (valid) {
		var submitButton = Form.getSubmitButton(form);
		new Insertion.After(submitButton, '<span id="sending">Sending...</span>');
		submitButton.disable();
	} else {
		document.getElementsByClassName('blank')[0].focus();
	}
	
	return valid;
}

function toggleAll(form, bit) {
	$(form).getInputs('checkbox').each(function (el) {
		el.checked = bit;
	});
}

function loadReplyForm(id, url) {
	var form = $('reply-form');
	if (form) {
		form.hide();
		var hide = form.parentNode.id == id;
		form.remove();
		if (hide) return false;
	}
	new Ajax.Updater($(id).getElementsByClassName('comment')[0], url, {
		method: 'GET',
		insertion: Insertion.After
	});
}

function addComment(form) {
	var data = Form.serialize(form);
	if (!checkForm(form)) return false;
	new Ajax.Updater({success: 'comments-list'}, form.action, {
		parameters: data,
		insertion: Insertion.Bottom,
		onFailure: function (transport) {
			alert(transport.responseText);
		},
		onComplete: function (transport) {
			$('sending').remove();
			Form.getSubmitButton($('comment-form')).enable();
			if (transport.status == 200) {
				$$('#comments-list li').last().scrollTo();
				$('comment_body').value = '';
			}
		}
	});
	return false;
}

function replyComment(form, id) {
	var data = Form.serialize(form);
	if (!checkForm(form)) return false;
	new Ajax.Updater({success: id}, form.action, {
		parameters: data,
		insertion: Insertion.Bottom,
		onFailure: function (transport) {
			alert(transport.responseText);
		},
		onComplete: function (transport) {
			Form.getSubmitButton(form).enable();
			$('sending').remove();
			if (transport.status == 200) {
				$('reply-form').remove();
			}
		}
	});
	return false;
}

function editComment(id, url) {
	new Ajax.Updater($(id).getElementsByClassName('comment')[0], url, {
		method: 'GET'
	});
}

function addFileEntry() {
	new Insertion.Bottom('uploads', '<li><input type="file" name="upload[]" size="50" class="ignore" /></li>');
}

function setPostAttribute(form, key, value) {
	var attr = $(form).getInputs(null, 'meta['+key+']');
	if (attr[0]) {
		attr[0].value = value;
	} else {
		new Insertion.Bottom(form, '<input type="hidden" name="meta['+key+']" value="'+value+'" />');
	}
}

function checkUserID(field) {
	var id = $F(field);
	if (!id) return;
	new Ajax.Updater('notification', location.href, {
		method: 'get',
		parameters: { user: id }
	});
}

function highlightText(text, element) {
	element.descendants().each(function (el) {
		$A(el.childNodes).each(function (node) {
			if (node.nodeType == 3) {
				var value = node.nodeValue;
				var re = new RegExp("("+text+")", "ig");
				var offset = 0;
				var lastNode = node;
				while (true) {
					var match = re.exec(value);
					if (!match) break;
					var a = lastNode.splitText(match.index - offset);
					var b = a.splitText(match[0].length);
					var span = document.createElement('span');
					span.appendChild(document.createTextNode(match[0]));
					span.style.backgroundColor = '#ff0';
					a.parentNode.replaceChild(span, b.previousSibling);
					lastNode = b;
					offset = re.lastIndex;
				}
			}
		});
	});
}
function highlightSearchKeyword() {
	var kw = location.search.toQueryParams()['keyword'];
	if (!kw) return;
	highlightText(kw, $('body'));
}

// dialog

function addDialogOverlay() {
	var overlay = document.createElement('div');
	var content = document.createElement('div');
	overlay.id = 'dialog-overlay';
	overlay.style.display = 'none';
	content.id = 'dialog';
	overlay.appendChild(content);
	$('meta').appendChild(overlay);
}

function addCloseButton() {
	new Insertion.Top('dialog', '<a href="#" class="dialog-close" id="dialog-close">X</a>');
}

function openDialog(href) {
	var overlay = $('dialog-overlay');
	if (document.documentElement && document.documentElement.scrollTop){
		overlay.style.top = document.documentElement.scrollTop + 'px';
	} else if (document.body) {
		overlay.style.top = document.body.scrollTop + 'px';
	}
	new Ajax.Updater('dialog', href, {method: 'get', onComplete: function () { addCloseButton(); triggerCloseLinks(); fixFormActions(href); overlay.show(); }});
}

function triggerDialogLinks() {
	$$('a.dialog').each(function (link) {
		Event.observe(link, 'click', function (ev) {
			openDialog(this.href);
			Event.stop(ev);
		});
	});
}

function triggerCloseLinks() {
	$$('#dialog a.dialog-close').each(function (link) {
		Event.observe(link, 'click', function (ev) {
			$('dialog-overlay').hide();
			Event.stop(ev);
		});
	});
}

function fixFormActions(href) {
	$$('#dialog form').each(function (form) {
		if (!form.action) form.action = href;
	});
}

Event.observe(window, 'load', function () {
	highlightSearchKeyword();
	addDialogOverlay();
	triggerDialogLinks();
	try { 
		document.execCommand('BackgroundImageCache', false, true); 
	} catch (e) {}
});
