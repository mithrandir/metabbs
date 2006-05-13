<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<h2>Permission</h2>
<p>
	<label>Read</label>
	More than level <?=text_field('board', 'perm_read', '0', 3)?>
</p>
<p>
	<label>Write</label>
	More than level <?=text_field('board', 'perm_write', '0', 3)?>
</p>
<p>
	<label>Comment</label>
	More than level <?=text_field('board', 'perm_comment', '0', 3)?>
</p>
<p>
	<label>Edit/Delete</label>
	Writer and more than level <?=text_field('board', 'perm_delete', '255', 3)?>
</p>
<p><input type="submit" value="OK" /></p>
</form>
