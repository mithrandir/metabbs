<form method="post" action="?tab=permission">
<div id="permission">
<h2><?=i('Permission')?></h2>
<dl>
	<dt><?=label_tag("Read", 'board', 'perm_read')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_read', $board->perm_read, 3))?></dd>

	<dt><?=label_tag("Write", 'board', 'perm_write')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_write', $board->perm_write, 3))?></dd>
	
	<dt><?=label_tag("Comment", 'board', 'perm_comment')?></dt>
	<dd><?=i('More than level %s', text_field('board', 'perm_comment', $board->perm_comment, 3))?></dd>

	<dt><?=label_tag("Edit/Delete", 'board', 'perm_delete')?></dt>
	<dd><?=i('Writer and more than level %s', text_field('board', 'perm_delete', $board->perm_delete, 3))?></dd>
</dl>
</div>
<p><input type="submit" value="OK" /></p>
</form>
