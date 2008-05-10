<?php
require_once dirname(__FILE__)."/../app/models/metadata.php";

/**
 * 테이블 접미사를 지정한다.
 * @param $prefix 접미사
 */
function set_table_prefix($prefix) {
	$GLOBALS['__db']->prefix = $prefix;
}

/**
 * 모델 이름으로부터 테이블 이름을 생성한다.
 * @param $model 모델 이름
 * @return 테이블 이름
 */
function get_table_name($model) {
	return $GLOBALS['__db']->prefix . $model;
}

/**
 * 모델 객체
 */
class Model
{
	var $id;

	/**
	 * 생성자
	 * 데이터가 주어진 경우 객체 속성으로 설정한다.
	 * @param $attributes 데이터 배열
	 */
	function Model($attributes = null) {
		global $__db;
		$this->db = &$__db;
		$this->import($attributes);
		if (isset($this->model))
			$this->table = get_table_name($this->model);
		$this->_init();
		$this->metadata = new Metadata($this);
	}

	/**
	 * 초기작업을 설정한다.
	 */
	function _init() { }

	/**
	 * 데이터를 객체 속성으로 불러온다.
	 * @param $attributes 데이터 배열
	 */
	function import($attributes) {
		if (is_array($attributes)) {
			foreach ($attributes as $key => $value) {
				$this->$key = $value;
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * id의 존재 여부를 확인
	 */
	function exists() {
		return (bool) $this->id;
	}

	/**
	 * URL에서 사용할 ID를 가져온다.
	 * @return id
	 */
	function get_id() {
		return $this->id;
	}

	/**
	 * 테이블에 필드가 존재하는 속성만 모아 돌려준다.
	 * @return 데이터 배열
	 */
	function get_mapped_attributes() {
		$columns = $this->db->get_columns($this->table);
		$attributes = array();
		foreach ($columns as $key) {
			if (isset($this->$key))
				$attributes[$key] = $this->$key;
		}
		return $attributes;
	}

	/**
	 * 새로운 데이터를 테이블에 삽입한다.
	 */
	function create() {
		$this->id = insert($this->model, $this->get_mapped_attributes());
	}

	/**
	 * 항목의 내용을 바꾼다.
	 */
	function update() {
		update_all($this->model, $this->get_mapped_attributes(), "id=$this->id");
	}

	/**
	 * 항목을 삭제한다.
	 */
	function delete() {
		delete_all($this->model, "id=$this->id");
		$this->id = NULL;
	}

	function get_attribute($key) {
		if ($this->exists()) $this->metadata->load();
		return $this->metadata->get($key);
	}

	function get_attributes() {
		if ($this->exists()) $this->metadata->load();
		return $this->metadata->attributes;
	}
	
	function set_attribute($key, $value) {
		$this->metadata->model = &$this; // workaround for PHP4 -_-
		$this->metadata->set($key, $value);
	}
}
?>
