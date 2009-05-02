<?php
class TrashCan {
	/**
	 * 레코드를 쓰레기통으로 보냅니다. 실제 기록은 삭제됩니다.
	 *
	 * @param $object 레코드 객체
	 */
	function put($object, $reason = '') {
		insert('trash', array(
			'model' => $object->model,
			'data' => serialize($object->get_mapped_attributes()),
			'reason' => $reason,
			'created_at' => time()
		));
		$object->delete();
	}

	/**
	 * 쓰레기통에 들어간 레코드를 완전히 삭제합니다.
	 *
	 * @param $id 레코드 ID
	 */
	function purge($id) {
		delete_all('trash', 'id=' . $id);
	}

	/**
	 * 레코드를 원래대로 돌립니다.
	 *
	 * @param $id 레코드 ID
	 */
	function revert($id) {
		$trash = find('trash', $id);
		insert($trash->model, unserialize($trash->data));
		TrashCan::purge($id);
	}

	/**
	 * 쓰레기통을 완전히 비웁니다.
	 */
	function clear() {
		delete_all('trash');
	}

	/**
	 * 쓰레기 목록을 돌려줍니다.
	 */
	function get_trashes($offset, $limit = 30) {
		return find_all('trash', '', 'id DESC', $offset, $limit);
	}
}

class Trash extends Model {
	function get_summary() {
		$data = unserialize($this->data);
		return "[$data[name]] " . utf8_strcut($data['body'], 100);
	}
}
