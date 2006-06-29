<?php
class Config
{
	function Config($name) {
		global $metabbs_dir;
		$this->config = array();
		$this->filename = $metabbs_dir . '/' . $name;
		if (file_exists($this->filename)) {
			$file = file($this->filename);
		} else {
			return;
		}
		array_shift($file);
		foreach ($file as $_ => $line) {
			list($key, $value) = explode('=', rtrim($line), 2);
			$this->set($key, $value);
		}
	}
	function write_to_file() {
		$str = $this->to_string();
		$fp = fopen($this->filename, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}
	function set($key, $value) {
		$this->config[$key] = $value;
	}
	function get($key, $default = "") {
		if (array_key_exists($key, $this->config)) {
			return $this->config[$key];
		} else {
			return $default;
		}
	}
	function to_string() {
		$str = "<?php/*\n";
		foreach ($this->config as $key => $value) {
			$str .= "$key=$value\n";
		}
		return rtrim($str);
	}
	function to_array() {
		return $this->config;
	}
}
?>
