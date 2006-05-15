<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<ul id="edit-section">
    <li class="selected">General</li>
    <li><a href="?action=edit_permission<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Permission</a></li>
    <li><a href="?action=edit_skin<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Skin</a></li>
</ul>
<h2>General</h2>
<p>
	<label for="board_name">Name</label>
	<?=text_field('board', 'name', $board->name)?>
</p>
<p>
	<label for="board_title">Title</label>
	<?=text_field('board', 'title', $board->title)?>
</p>
<p>
	<label for="board_posts_per_page">Posts per page</label>
	<?=text_field('board', 'posts_per_page', 10, $board->posts_per_page)?>
</p>
<p>
	<label>Use attachment</label>
	<?=check_box('board', 'use_attachment')?>
</p>
<p><input type="submit" value="OK" /></p>
</form>
