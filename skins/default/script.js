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

Event.observe(window, 'load', function () {
	Event.observe('comment-form', 'submit', function (ev) {
		var data = Form.serialize(this);
		Form.disable(this);
		$('sending').show();
		new Ajax.Updater('comments-list', this.action, {
			parameters: data,
			insertion: Insertion.Bottom,
			onComplete: function () {
				Form.enable(this);
				$$('#comments-list li').last().scrollTo().animate(Effect.Pulsar);
				$('sending').hide();
			}.bind(this)
		});
	});
});
