<?php
class PluginManager
{
	var $plugins;
	function fire_event($event_type, $target) {
		// TODO: 이 함수를 호출하면 적당한 플러그인들을 찾아 실행한다.
	}
	function get_list($applied = null) {
		// TODO: $applied 변수로 적용 범위를 지정하여 플러그인 목록 반환
	}
	function enable($plugin_id) {
		// TODO: 해당 플러그인 활성화
	}
	function disable($plugin_id) {
		// TODO: 해당 플러그인 비활성화
	}
	function register_handler($event, $plugin_id) {
		// TODO: 이벤트 등록
	}
	function deregister_handler($event, $plugin_id) {
		// TODO: 이벤트 해제 
	}
	function save_options($plugin_id, $values) {
		// TODO: 해당 플러그인의 설정 저장하기
	}
	function load_options($plugin_id) {
		// TODO: 해당 플러그인의 설정 불러오기
	}
}

class Plugin {
	var $config;
	function _init() {
	}
	/* abstract */ function register_handler() {
	}
	/* abstract */ function deregister_handler() {
	}
}
