<?php
define('METABBS_DB_REVISION', 769);

/**
 * 모델 명칭으로부터 DB 테이블의 이름을 만든다.
 * @param $model 모델 명
 * @return DB 테이블의 이름.
 */
function get_table_name($model) {
	return METABBS_TABLE_PREFIX . $model;
}

/**
 * 키, 밸류를 직렬화한다.
 * @param $key 키
 * @param $value 값
 * @return 직렬화 되어 $key=$value 형태의 문자열로 반환된다.
 */
function get_column_pair($key, $value) {
	return "$key=$value";
}

/**
 * 모델 객체
 * DB 입출력 등의 일을 자동화 한다.
 */
class Model
{
	/**
	 * 모든 모델은 기본키로 id를 갖는다.
	 */
	var $id;

	/**
	 * 생성자
	 * 어트리뷰트(키와 값으로 이루어진 짝)가 있을 경우 설정을 한다.
	 * @param $attributes 어티리뷰트의 집합
	 */
	function Model($attributes = null) {
		$this->db = get_conn();
		$this->import($attributes);
		$this->_init();
	}

	/**
	 * 초기작업을 설정한다.
	 */
	function _init() { }

	/**
	 * 어트르뷰트(키와 값으로 이루어진 짝) 집합을 모델 객체의 필드로 치환한다.
	 * @param $attributes 어트리뷰트
	 */
	function import($attributes) {
		if (is_array($attributes)) {
			foreach ($attributes as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * id의 존재 여부를 확인
	 */
	function exists() {
		return !!$this->id;
	}

	/**
	 * id를 가져온다.
	 * @return id
	 */
	function get_id() {
		return $this->id;
	}

	/**
	 * 컬럼을 가져온다.
	 * @return 한 컬럼의 내용들이 남긴 배열
	 */
	function get_columns() {
		$columns = $this->db->get_columns($this->table);
		$data = array();
		foreach ($columns as $k) {
			$data[$k] = "'" . mysql_real_escape_string($this->$k) . "'";
		}
		return $data;
	}

	/**
	 * 새로운 데이터를 테이블에 삽입한다.
	 */
	function create() {
		$columns = $this->get_columns();
		$query = "INSERT INTO $this->table";
		$query .= " (".implode(",", array_keys($columns)).")";
		$query .= " VALUES(".implode(",", array_values($columns)).")";
		$this->db->query($query);
		$this->id = $this->db->insertid();
	}

	/**
	 * 항목의 내용을 개선한다.
	 */
	function update() {
		$columns = $this->get_columns();
		$query = "UPDATE $this->table SET ";
		$query .= implode(",", array_map('get_column_pair', array_keys($columns), array_values($columns)));
		$query .= " WHERE id=$this->id";
		$this->db->query($query);
	}

	/**
	 * 항목을 삭제한다.
	 */
	function delete() {
		$this->db->query("DELETE FROM $this->table WHERE id=$this->id");
	}
}
?>
