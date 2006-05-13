<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<h2>General</h2>
<p>
	<label for="board_name">Name</label>
	<?=text_field('board', 'name')?>
</p>
<p>
	<label for="board_title">Title</label>
	<?=text_field('board', 'title')?>
</p>
<p>
	<label for="board_posts_per_page">Posts per page</label>
	<?=text_field('board', 'posts_per_page', 10)?>
</p>
<p>
	<label for="board_skin">Skin</label>
	<select name="board[skin]" id="board_skin">
<? foreach ($skins as $skin) { ?>
<? if ($skin == $board->skin) { ?>
		<option selected="selected"><?=$skin?></option>
<? } else { ?>
		<option><?=$skin?></option>
<? } ?>
<? } ?>
	</select>
</p>
<p>
	<label>Use attachment</label>
	<?=check_box('board', 'use_attachment')?>
</p>
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
