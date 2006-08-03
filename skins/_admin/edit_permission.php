<div id="permission">
<h2><?=i('Permission')?></h2>
<p>
	<?=label_tag("Read", 'board', 'perm_read')?>
	<?=i('More than level %s', text_field('board', 'perm_read', '0', 3))?>
</p>
<p>
	<?=label_tag("Write", 'board', 'perm_write')?>
	<?=i('More than level %s', text_field('board', 'perm_write', '0', 3))?>
</p>
<p>
	<?=label_tag("Comment", 'board', 'perm_comment')?>
	<?=i('More than level %s', text_field('board', 'perm_comment', '0', 3))?>
</p>
<p>
	<?=label_tag("Edit/Delete", 'board', 'perm_delete')?>
	<?=i('Writer and more than level %s', text_field('board', 'perm_delete', '255', 3))?>
</p>
</div>
