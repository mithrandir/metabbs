<?php
require 'php-captcha.inc.php';

class SimpleCaptcha extends Plugin {
	var $plugin_name = 'SimpleCaptcha';
	var $description = 'Captcha를 사용하게 합니다.';
	var $fonts ;

	function on_init() {
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));

		add_filter('ValidateAccountSignup', array(&$this, 'validate'), 300);
		add_filter('ValidatePostCreate', array(&$this, 'validate'), 300);
		add_filter('ValidateCommentCreate', array(&$this, 'validate'), 300);
		add_filter('ValidateCommentReply', array(&$this, 'validate'), 300);
	}

	function on_settings() {
		$config = new Config(METABBS_DIR . '/data/captcha.php');
		if (is_post()) {
			$flite_path = isset($_POST['settings']['flite_path']) ? $_POST['settings']['flite_path'] : null;
			$config->set('flite_path', $flite_path);
			$config->write_to_file();
		}
?>
<form method="post" action="?">
<h2><?=i('Settings')?></h2>
<dl>
	<dt><?=label_tag('Flite Path', 'settings', 'flite_path')?></dt>
	<dd><?=text_field('settings', 'flite_path', $config->get('flite_path', false), 50)?></dd>
</dl>
<p><input type="submit" value="OK" /></p>
</form>

<h2><?=i('Usage')?></h2>

<ul>
	<li>다음 코드를 /themes/XXX/signup.php 에 추가하세요.
<pre style="border: 1px solid gray;"><code>&lt;? if (Plugin::is_enabled('SimpleCaptcha')): ?&gt;
&lt;p&gt;
	&lt;label&gt;<?=i('CAPTCHA')?>&lt;span class="star"&gt;*&lt;/span&gt;&lt;/label&gt;
	&lt;?= SimpleCaptcha::get_html() ?&gt;
&lt;/p&gt;
&lt;? endif; ?&gt;
</code></pre>
	</li>
	<li>다음 코드를 /skins/XXX/write.php 에 추가하세요.
<pre style="border: 1px solid gray;"><code>&lt;? if (Plugin::is_enabled('SimpleCaptcha') && $guest 
	&& ($controller == 'board' || $action == 'post')): ?&gt;
&lt;tr&gt;
	&lt;th&gt;CAPTCHA&lt;/th&gt;
	&lt;td class="captcha" colspan="3"&gt;&lt;?= SimpleCaptcha::get_html() ?&gt;&lt;/td&gt;
&lt;/tr&gt;
&lt;? endif; ?&gt;
</code></pre>
	</li>
	<li>다음 코드를 /skins/XXX/comment_form.php 에 추가하세요.
<pre style="border: 1px solid gray;"><code>&lt;? if (Plugin::is_enabled('SimpleCaptcha') && $guest 
	&& (($controller == 'post' && $action == 'index') || ($controller == 'comment' && $action == 'reply'))): ?&gt;
	&lt;p&gt;
		&lt;label for="recaptcha_challenge_field"&gt;CAPTCHA&lt;/label&gt;
		&lt;?= SimpleCaptcha::get_html() ?&gt;
	&lt;/p&gt;
&lt;? endif; ?&gt;
</code></pre>
	</li>
</ul>
<?php
	}

	function validate(&$post, &$error_messages) {
		if (array_key_exists('recaptcha_challenge_field', $post) && !SimpleCaptcha::is_valid($post)) {
			$error_messages->add(i('The CAPTCHA solution was incorrect'), 'captcha');
		}
	}

	function is_valid($post) {
		if (!empty($post['recaptcha_challenge_field'])) {
			return false;
		}

		return PhpCaptcha::Validate($arg['recaptcha_challenge_field']);
	}

	function get_html() {
		global $error_messages;
		$config = new Config(METABBS_DIR . '/data/captcha.php');
		$flite_path = $config->get('flite_path');

		$html = "<input type=\"text\" name=\"recaptcha_challenge_field\" id=\"recaptcha_challenge_field\" class=\"".marked_by_error_message('captcha', $error_messages)."\"/>\n";
		$html .= "<img src=\"/captcha/visual/\" width=\"120\" height=\"18\" alt=\"Visual CAPTCHA\" style=\"border:1px solid gray;\"/>\n";
		if (!empty($flite_path))
			$html .= "<a href=\"/captcha/audio/\">".i("Can't see the image? Click for audible version")."</a>\n";

		return $html;
	}

	function get_fonts() {
		global $config;
		
		$plugin_path = get_plugin_path('SimpleCaptcha');
		$dirs = scandir($plugin_path."/fonts/");
		$fonts = array();

		foreach ($dirs as $dir) {
			if (is_file($plugin_path.'/fonts/'.$dir) && $dir != '.' && $dir != '..' && strstr($dir, ".ttf"))
				array_push($fonts, $plugin_path.'/fonts/'.$dir);
		}

		return $fonts;
	}
}

register_plugin('SimpleCaptcha');
?>