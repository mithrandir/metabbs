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

function addComment(form) {
	var data = Form.serialize(form);
	form.disable();
	$('sending').show();
	new Ajax.Updater({success: 'comments-list'}, form.action, {
		parameters: data,
		insertion: Insertion.Bottom,
		onFailure: function (transport) {
			alert(transport.responseText);
		},
		onComplete: function (transport) {
			Form.enable($('comment-form'));
			$('sending').hide();
			if (transport.status == 200) {
				$$('#comments-list li').last().scrollTo().animate(Effect.Pulsar);
				$('comment_body').value = '';
			}
		}
	});
	return false;
}
