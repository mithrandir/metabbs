<?php
if(!function_exists('scandir')) {
    function scandir($dir, $sortorder = 0) {
        if(is_dir($dir) && $dirlist = @opendir($dir)) {
            while(($file = readdir($dirlist)) !== false) {
                $files[] = $file;
            }
            closedir($dirlist);
            ($sortorder == 0) ? asort($files) : rsort($files); // arsort was replaced with rsort
            return $files;
        } else return false;
    }
} 

class Captcha {
	var $libs = array(
		"phpcaptcha" => array(
			"title" =>"PHP CAPTCHA", 
			"lib_src"=>"lib/external/phpcaptcha/php-captcha.inc.php"
		),
/*		"recaptcha" => array(
			"title" =>"ReCAPTCHA", 
			"lib_src"=>"lib/external/recaptcha/recaptchalib.php"
		)*/
	);

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
				$base = 'lib/external/phpcaptcha/fonts';
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
		if (!file_exists($this->libs[$this->name]["lib_src"])) {
			$this->error = "Library not exists on '{$this->libs[$this->name]['lib_src']}'.";
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
					$this->error = "Copy fonts to '/lib/external/phpcaptcha/fonts'";
					return false;
				}
				break;
		}
		return true;
	}

	function is_valid($arg) {
		include_once $this->libs[$this->name]["lib_src"];
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
		include_once $this->libs[$this->name]["lib_src"];
		switch ($this->name) {
			case "recaptcha":
				$html = recaptcha_get_html($this->publickey, $this->error);
				break;
			case "phpcaptcha":
				$html = "<input type=\"text\" name=\"recaptcha_challenge_field\" id=\"recaptcha_challenge_field\"/>\n";
				$html .= "<img src=\"/captcha/visual\" width=\"120\" height=\"18\" alt=\"Visual CAPTCHA\" style=\"border:1px solid gray;\"/>\n";
				if (!empty($this->flite_path))
					$html .= "<a href=\"/captcha/audio\">".i("Can't see the image? Click for audible version.")."</a>\n";
				break;
		}
		return $html;
	}
}

$captcha_arg = array();
switch ($config->get('captcha_name', false)) {
	case "phpcaptcha":
		$captcha_arg['flite_path'] = $config->get('flite_path', false);
		break;
	case "recaptcha":
		$captcha_arg['privatekey'] = $config->get('captcha_privatekey', false);
		$captcha_arg['publickey'] = $config->get('captcha_publickey', false);
		break;
}
?>