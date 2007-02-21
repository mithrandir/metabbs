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
		this.element.setStyle({backgroundColor: '#fff', position: 'absolute', opacity: 0.0});
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
		Form.getSubmitButton(form).disable();
		$('sending').show();
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
			Form.getSubmitButton($('comment-form')).enable();
			$('sending').hide();
			if (transport.status == 200) {
				$$('#comments-list li').last().scrollTo().animate(Effect.Pulsar);
				$('comment_body').value = '';
			}
		}
	});
	return false;
}

function addFileEntry() {
	new Insertion.Bottom('uploads', '<li><input type="file" name="upload[]" size="50" /></li>');
}
