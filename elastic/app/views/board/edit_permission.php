<div id="permission">
<form method="post" action="?tab=permission">
<h2><?=i('Permission')?></h2>
<h3><?=i('General')?></h3>
<dl>
	<dt><?=label_tag("Read", 'board', 'perm_read')?></dt>
	<dd>
		<?=i('More than level %s', text_field('board', 'perm_read', $board->perm_read, 3))?>
		<?=check_box('board', 'always_show_list', $board->get_attribute('always_show_list', false))?> <label for="board_always_show_list">읽기 권한이 없어도 목록을 보여줍니다.</label>
	</dd>

	<dt><?=label_tag("Write", 'board', 'perm_write')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_write', $board->perm_write, 3))?></dd>
	
	<dt><?=label_tag("Comment", 'board', 'perm_comment')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_comment', $board->perm_comment, 3))?></dd>
</dl>
<p><input type="submit" value="OK" /></p>
</form>

<h3><?=i('Administrators')?></h3>
<table id="users">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="level"><?=i('Level')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? $_ = $board->get_admins(); if ($_) { foreach ($_ as $admin) { ?>
<tr>
	<td><?=$admin->name?> <small>(<?=$admin->user?>)</small></td>
	<td><?=$admin->level?></td>
	<td>
	<? if (!$admin->is_admin()) { ?>
	<a href="<?=url_for($board, 'admins')?>?action=drop&amp;id=<?=$admin->id?>">관리자 권한 제거</a>
	<? } else { ?>
	-
	<? } ?>
	</td>
</tr>
<? } } else { ?>
<tr>
	<td colspan="3" style="text-align: center; height: 4em">관리자가 없습니다.</td>
</tr>
<? } ?>
</table>

<form method="post" action="<?=url_for($board, 'admins')?>?action=add">
<p>관리자로 추가할 사용자의 아이디를 입력하세요.</p>
<p><input type="text" name="admin_id" /> <input type="submit" value="<?=i('Add')?>" /></p>
</form>
</div>
