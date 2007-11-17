<?php
/**
 * MetaBBS 설정을 담당
 */
class Config {
	/**
	 * 생성자로 파일이름과 내용을 설정한다.
	 * @param $name 설정 파일 이름
	 */
	function Config($name) {
		$this->filename = $name;
		$this->config = $this->_parse($this->filename);
	}

	/**
	 * 설정 내용을 읽어와서 파싱한다.
	 * @param $path 경로를 포함한 설정 파일 이름
	 * @return 설정 내용을 파싱하여 연관 배열로 리턴
	 */
	function _parse($path) {
		$config = array();
		if (file_exists($path)) {
			$file = file($path);
			array_shift($file);
			foreach ($file as $line) {
				list($key, $value) = explode('=', rtrim($line), 2);
				$config[$key] = $value;
			}
		}
		return $config;
	}

	/**
	 * 설정 파일을 기록한다.
	 */
	function write_to_file() {
		$str = $this->to_string();
		$fp = fopen($this->filename, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}

	/**
	 * 설정 내용을 필드에 기입한다.
	 * @param $key 키
	 * @param $value 값
	 */
	function set($key, $value) {
		$this->config[$key] = $value;
	}

	/**
	 * 필드에서 설정 내용을 반환한다.
	 * @param $key 키
	 * @param $default 값이 없을 때의 반환 값
	 * @return 설정된 키를 리턴하고 해당 키가 없는 경우 $default를 리턴한다.
	 */
	function get($key, $default = "") {
		if (array_key_exists($key, $this->config) && $this->config[$key]) {
			return $this->config[$key];
		} else {
			return $default;
		}
	}

	/**
	 * 직렬화를 한다.
	 * @return 필드의 내용을 파일에 적합한 형태로 변환한다.
	 */
	function to_string() {
		$str = "<?php/*\n";
		foreach ($this->config as $key => $value) {
			if (!empty($value)) $str .= "$key=$value\n";
		}
		return rtrim($str);
	}
}
?>
