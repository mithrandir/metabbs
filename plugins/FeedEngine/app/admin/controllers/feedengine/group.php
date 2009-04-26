<?php
if (is_post()) {
	if (isset($params['group']) && !empty($params['group']['board_id']) && !empty($params['group']['name'])) {
		$tags = array_trim(explode(",",$params['group']['tags']));
		$group = new Group(array('board_id'=> $params['group']['board_id'], 'name' => $params['group']['name'], 'tags'=> implode(',',$tags)));
		$group->create();
		Flash::set('그룹을 생성했습니다');
		redirect_back();
	}
	if (isset($params['rename']) && is_numeric($params['rename'])) {
		$group = Group::find($params['rename']);
		$group->name = $params['value'];
		$group->update();
		redirect_back();
	}
	
	if (isset($params['delete']) && is_numeric($params['delete'])) {
		$group = Group::find($params['delete']);
		$group->delete();
		Flash::set('그룹을 삭제했습니다');
		redirect_back();
	}
}
if (isset($params['up']) && is_numeric($params['up'])) {
	$group = Group::find($params['up']);
	$group->move_higher();
	redirect_back();
}
if (isset($params['down']) && is_numeric($params['down'])) {
	$group = Group::find($params['down']);
	$group->move_lower();
	redirect_back();
}

$groups = Group::find_all();
$boards = Board::find_all();
?>