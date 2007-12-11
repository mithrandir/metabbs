<?php
$__cache = array();

/**
 * 테이블 접미사를 지정한다.
 * @param $prefix 접미사
 */
function set_table_prefix($prefix) {
	$GLOBALS['table_prefix'] = $prefix;
}

/**
 * 모델 이름으로부터 테이블 이름을 생성한다.
 * @param $model 모델 이름
 * @return 테이블 이름
 */
function get_table_name($model) {
	return $GLOBALS['table_prefix'] . $model;
}

/**
 * 캐시를 사용하여 데이터를 가져온다.
 * 캐시에 해당 레코드가 있으면 캐시를 사용하고, 그렇지 않으면 새로 찾는다.
 * @param $model 모델 이름
 * @param $id 레코드 아이디
 * @return 모델 객체
 */
function find_and_cache($model, $id) {
	global $__cache;
	$key = $model.'_'.$id;
	if (!isset($__cache[$key])) {
		$o = call_user_func(array($model, 'find'), $id);
		$__cache[$key] = $o;
	} else {
		$o = $__cache[$key];
	}
	return $o;
}

// XXX: must be (re)moved
function find($model, $key, $value) {
	global $__db;
	$table = get_table_name($model);
	return $__db->fetchrow("SELECT * FROM $table WHERE $key=?", $model, array($value));
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
			$attributes[$key] = $this->$key;
		}
		return $attributes;
	}

	/**
	 * 새로운 데이터를 테이블에 삽입한다.
	 */
	function create() {
		$columns = $this->get_mapped_attributes();
		$keys = array_map(array(&$this->db, 'quote_identifier'), array_keys($columns));
		$values = array_map(array(&$this->db, 'quote'), array_values($columns));
		
		$query = "INSERT INTO $this->table";
		$query .= " (".implode(", ", $keys).")";
		$query .= " VALUES(".implode(", ", $values).")";
		$this->db->execute($query);
		$this->id = $this->db->insertid();
	}

	/**
	 * 항목의 내용을 바꾼다.
	 */
	function update() {
		$columns = $this->get_mapped_attributes();
		$query = "UPDATE $this->table SET ";
		$parts = array();
		foreach ($columns as $k => $v) {
			$parts[] = $this->db->quote_identifier($k)."=".$this->db->quote($v);
		}
		$query .= implode(", ", $parts);
		$query .= " WHERE id=$this->id";
		$this->db->execute($query);
	}

	/**
	 * 항목을 삭제한다.
	 */
	function delete() {
		$this->db->execute("DELETE FROM $this->table WHERE id=$this->id");
	}
}
?>
