<div id="permission">
<h2><?=i('Permission')?></h2>
<p>
	<?=label_tag("Read", 'board', 'perm_read')?>
	<?=i('More than level %s', text_field('board', 'perm_read', $board->perm_read, 3))?>
</p>
<p>
	<?=label_tag("Write", 'board', 'perm_write')?>
	<?=i('More than level %s', text_field('board', 'perm_write', $board->perm_write, 3))?>
</p>
<p>
	<?=label_tag("Comment", 'board', 'perm_comment')?>
	<?=i('More than level %s', text_field('board', 'perm_comment', $board->perm_comment, 3))?>
</p>
<p>
	<?=label_tag("Edit/Delete", 'board', 'perm_delete')?>
	<?=i('Writer and more than level %s', text_field('board', 'perm_delete', $board->perm_delete, 3))?>
</p>
</div>
