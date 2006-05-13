<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<input type="hidden" name="board[name]" value="<?=$board->name?>" />
<ul id="edit-section">
    <li><a href="?action=edit_general<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">General</a></li>
    <li class="selected">Permission</li>
    <li><a href="?action=edit_skin<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Skin</a></li>
</ul>
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
