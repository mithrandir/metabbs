<?php
function getattr(&$object, $attr) { return $object->$attr; }
function hasattr(&$object, $attr) { return isset($object->$attr); }
function setattr(&$object, $attr, $value) { $object->$attr = $value; }

/**
 * 1:N 관계를 나타내는 객체
 */
class OneToManyRelation {
	/**
	 * 생성자
	 * $object has many $models
	 * @param $object 부모 객체
	 * @param $model  $object가 가질 모델의 이름
	 */
	function OneToManyRelation($object, $model) {
		$this->object = $object;
		$this->model = $model;
	}

	/**
	 * 갯수 캐시 사용 여부를 돌려준다.
	 * 모델명_count 필드가 존재하는지 확인하는 방식
	 * @returns 사용하면 true, 안 쓰면 false
	 */
	function caches_count() {
		return hasattr($this->object, "{$this->object->model}_count");
	}

	function count() {
		if ($this->caches_count())
			return getattr($this->object, "{$this->object->model}_count");
		else
			return $this->real_count();
	}

	function real_count() {
		return count_all($this->model, $this->_condition());
	}

	function all() {
		return find_all($this->model, $this->_condition());
	}

	function add($item) {
		setattr($item, "{$this->object->model}_id", $this->object->id);
		$item->create();
		if ($this->caches_count()) {
			$p = $this->model . '_count';
			$this->object->$p = $this->real_count() + 1;
			update_all($this->object->model, array($p => $this->object->$p), 'id='.$this->object->id);
		}
	}

	function update($attributes) {
		update_all($this->model, $attributes, $this->_condition());
	}

	function clear() {
		delete_all($this->model, $this->_condition());
	}

	function _condition() {
		return "{$this->object->model}_id={$this->object->id}";
	}
}
