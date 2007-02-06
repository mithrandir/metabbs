function checkForm(form)
{
	elements = form.elements ? form.elements : form;
	valid = true;
	for (i = elements.length; i > 0; i--) {
		field = $(elements[i-1]);
		if (!field.name) continue;
		if (field.value == '' && !field.hasClassName('ignore')) {
			field.addClassName('blank').focus();
			valid = false;
		} else {
			field.removeClassName('blank');
		}
	}
	return valid;
}

function sendForm(form, id, func) {
	if (checkForm(form)) {
		sendingRequest();
		$(form).ajax.value = '1';
		el = new Element('ul');
		el.setOpacity(0).setStyle('width', '100%').injectInside($(id));
		$(form).send({onComplete: function () {
			$(this.options.update).effect('opacity').custom(0, 1);
			sendingDone();
			func(); }, update: el});
	}
	return false;
}
function toggleAll(form, bit) {
	elements = form.elements ? form.elements : form;
	for (i = 0; i < elements.length; i++) {
		el = elements[i];
		if (el.tagName.toLowerCase() == 'input' && el.type == 'checkbox') {
			el.checked = bit;
		}
	}
}

function sendingRequest() {
	$('sending').style.display = 'inline';
}
function sendingDone() {
	$('sending').style.display = 'none';
}

Element.extend({
	apply: function (source) {
		for (attribute in source) this[attribute] = source[attribute];
		return this;
	}
});
function addFileEntry() {
	new Element('input').apply({type: 'file', name: 'upload[]', size: 50}).addClassName('ignore').injectInside(new Element('li').injectInside($('uploads')));
}

function highlight(id, keyword)
{
	if (!keyword) return;
	document.getElementsBySelector(id).each(function (el) {
	el.innerHTML = el.innerHTML.replace(new RegExp("("+keyword+")", "gi"), "<span class=\"highlight\">$1</span>");
	});
}
