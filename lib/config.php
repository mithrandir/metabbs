<?php
class Config
{
	function Config($name) {
		$this->filename = METABBS_DIR . '/' . $name;
		$this->config = $this->_parse($this->filename);
	}
	function _parse($path) {
		$config = array();
		if (file_exists($path)) {
			$file = file($path);
			array_shift($file);
			foreach ($file as $_ => $line) {
				list($key, $value) = explode('=', rtrim($line), 2);
				$config[$key] = $value;
			}
		}
		return $config;
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
		if (array_key_exists($key, $this->config) && $this->config[$key]) {
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
}
?>
