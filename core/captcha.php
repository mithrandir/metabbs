<?php
class Captcha {
	function Captcha($name, $arg) {
		$this->name = $name;
		switch ($this->name) {
			case "recaptcha":
				if (isset($arg['privatekey'])) $this->privatekey = $arg['privatekey'];
				if (isset($arg['privatekey'])) $this->publickey = $arg['publickey'];
				$this->resp = null;
				break;
			case "phpcaptcha":
				if (isset($arg['flite_path'])) $this->flite_path = $arg['flite_path'];
				$base = 'core/external/phpcaptcha/fonts';
				$dirs = scandir($base."/");
				$this->fonts = array();

				foreach ($dirs as $dir) {
				    if (is_file("$base/$dir") && $dir != '.' && $dir != '..' && strstr($dir, ".ttf"))
						array_push($this->fonts, "$base/$dir");
				}
				break;
		}
		$this->error = null;
	}

	function ready() {
		global $external_libs;
		if (!file_exists($external_libs['captcha'][$this->name]['src'])) {
			$this->error = "Library not exists on '{$external_libs['captcha'][$this->name]['src']}'.";
			return false;
		}
		switch ($this->name) {
			case "recaptcha":
				if (empty($this->privatekey) || empty($this->publickey)) {
					$this->error = "Enter Private Key and Public Key for ReCAPTCHA";
					return false;
				}
				break;
			case "phpcaptcha":
				if (count($this->fonts) == 0) {
					$this->error = "Copy fonts to '/core/external/phpcaptcha/fonts'";
					return false;
				}
				break;
		}
		return true;
	}

	function is_valid($arg) {
		switch ($this->name) {
			case "recaptcha":
				if (empty($arg['recaptcha_challenge_field']) || empty($arg['recaptcha_response_field'])) {
					$this->error = "The CAPTCHA solution is not ready";
					return false;
				}

				$this->resp = recaptcha_check_answer($this->privatekey, $_SERVER["REMOTE_ADDR"], $arg['recaptcha_challenge_field'], $arg['recaptcha_response_field']);
				$result = $this->resp->is_valid;
				break;
			case "phpcaptcha":
				if (empty($arg['recaptcha_challenge_field'])) {
					$this->error = "The CAPTCHA solution is not ready";
					return false;
				}

				$result = PhpCaptcha::Validate($arg['recaptcha_challenge_field']);
				break;
		}
		if($result === false)
			$this->error = "The CAPTCHA solution was incorrect";
		return $result;
	}

	function get_html() {
		switch ($this->name) {
			case "recaptcha":
				$html = recaptcha_get_html($this->publickey, $this->error);
				break;
			case "phpcaptcha":
				$html = "<input type=\"text\" name=\"recaptcha_challenge_field\" id=\"recaptcha_challenge_field\"/>\n";
				$html .= "<img src=\"/captcha/visual\" width=\"120\" height=\"18\" alt=\"Visual CAPTCHA\" style=\"border:1px solid gray;\"/>\n";
				if (!empty($this->flite_path))
					$html .= "<a href=\"/captcha/audio\">".i("Can't see the image? Click for audible version")."</a>\n";
				break;
		}
		return $html;
	}
}

$captcha_arg = array();
switch ($config->get('captcha_name', false)) {
	case 'phpcaptcha':
		include_once $external_libs['captcha']['phpcaptcha']['src'];
		$captcha_arg['flite_path'] = $config->get('flite_path', false);
		break;
	case 'recaptcha':
		include_once $external_libs['captcha']['recaptcha']['src'];
		$captcha_arg['privatekey'] = $config->get('captcha_privatekey', false);
		$captcha_arg['publickey'] = $config->get('captcha_publickey', false);
		break;
}
?>
