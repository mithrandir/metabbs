var Animation = Class.create();
Animation.prototype = {
	initialize: function (element) {
		this.element = $(element);
	},
	animate: function () {
		this.start();
		this.timer = window.setInterval(this.step.bind(this), this.interval);
	},
	stop: function () {
		window.clearInterval(this.timer);
	},
	start: function () {
		// implement this
	},
	step: function () {
		// implement this
	}
};

var Effect = {};
Effect.Pulsar = Class.create();
Effect.Pulsar.prototype = Object.extend(Animation.prototype, {
	interval: 15,
	pos: 0.0,

	initialize: function (element) {
		this.element = $(document.createElement('div'));
		this.element.setStyle({backgroundColor: '#fff', position: 'absolute', opacity: 0.0, padding: '1px'});
		document.body.appendChild(this.element);
		Position.clone($(element), this.element);
	},
	step: function () {
		if (this.pos >= 2.0) {
			this.stop();
			this.element.hide();
		} else {
			this.element.setStyle({opacity: Math.sin(this.pos*Math.PI)});
		}
		this.pos += 0.01;
	}
});

Element.addMethods({
	animate: function (element, effect) {
		var effect = new effect(element);
		effect.animate();
		return element;
	}
});

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
		submitButton.disable();
		new Insertion.After(submitButton, '<span id="sending">Sending...</span>');
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
				$$('#comments-list li').last().scrollTo().animate(Effect.Pulsar);
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

function addFileEntry() {
	new Insertion.Bottom('uploads', '<li><input type="file" name="upload[]" size="50" class="ignore" /></li>');
}
