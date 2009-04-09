<div id="permission">
<form method="post" action="?tab=permission">
<h2><?=i('Permission')?></h2>
<h3><?=i('General')?></h3>
<dl>
	<dt><?=label_tag("Read", 'board', 'perm_read')?></dt>
	<dd>
		<?=i('More than level %s', text_field('board', 'perm_read', $board->perm_read, 3))?>
		<?=check_box('board', 'restrict_access', $board->restrict_access())?> <label for="board_restrict_access"><?=i('Only for members')?></label>
		<?=check_box('board', 'always_show_list', $board->get_attribute('always_show_list', false))?> <label for="board_always_show_list">읽기 권한이 없어도 목록은 보여줍니다.</label>
	</dd>

	<dt><?=label_tag("Write", 'board', 'perm_write')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_write', $board->perm_write, 3))?> <?=check_box('board', 'restrict_write', $board->get_attribute('restrict_write', false))?> <label for="board_restrict_write"><?=i('Only for members')?></label></dd>
	
	<dt><?=label_tag("Comment", 'board', 'perm_comment')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_comment', $board->perm_comment, 3))?> <?=check_box('board', 'restrict_comment', $board->get_attribute('restrict_comment', false))?> <label for="board_always_show_comments"><?=i('Only for members')?></label>
	<?=check_box('board', 'always_show_comments', $board->get_attribute('always_show_comments', false))?> <label for="always_show_comments">읽기 권한이 없어도 댓글 내용은 보여줍니다.</label></dd>

	<dt><?=label_tag("Attachment", 'board', 'perm_attachment')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_attachment', $board->perm_attachment, 3))?> <?=check_box('board', 'restrict_attachment', $board->get_attribute('restrict_attachment', false))?> <label for="board_restrict_attachment"><?=i('Only for members')?></label></dd>
</dl>
<p><input type="submit" value="OK" /></p>
</form>

<h3><?=i('Membership')?></h3>
<table id="users">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="class"><?=i('Class')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? $_ = $board->get_members(); if ($_) { foreach ($_ as $member) { ?>
<tr>
	<td><?=$member->name?> <small>(<?=$member->user?>)</small></td>
	<td>
		<? if ($member->admin) { ?>관리자
		<? } else if ($member->is_admin()) { ?>사이트 관리자
		<? } else { ?>일반 회원<? } ?>
	</td>
	<td>
	<? if (!$member->is_admin()) { ?>
	<a href="<?=url_admin_for($board, 'members', array('member_id'=> $member->id, 'action'=>'toggle'))?>"><?=$member->admin ? '일반 회원으' : '관리자'?>로 전환</a> |
	<a href="<?=url_admin_for($board, 'members', array('member_id'=> $member->id, 'action'=>'drop'))?>">관계자 목록에서 제거</a>
	<? } else { ?>
	-
	<? } ?>
	</td>
</tr>
<? } } else { ?>
<tr>
	<td colspan="3" style="text-align: center; height: 4em">관계자로 지정한 사용자가 없습니다.</td>
</tr>
<? } ?>
</table>
<form method="post" action="<?=url_admin_for($board, 'members', array('action'=>'add'))?>">
<p>관계자로 추가할 사용자의 아이디를 입력하세요.</p>
<p><input type="text" name="member_id" /> <input type="submit" value="<?=i('Add')?>" /></p>
</form>
</div>
