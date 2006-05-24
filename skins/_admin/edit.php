<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<ul id="edit-section">
    <li class="selected"><a href="#general">General</a></li>
    <li><a href="#permission">Permission</a></li>
    <li><a href="#skin">Skin</a></li>
</ul>
<div id="general">
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
</div>

<div id="permission">
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
</div>

<div id="skin">
<h2>Skin</h2>
<div id="skins-available">
<? foreach ($skins as $skin) { ?>
<div class="skins-item">
<h3><input type="radio" name="skin" value="<?=$skin?>" <? if ($board->skin == $skin) { ?>checked="checked"<? } ?> /> <?=$skin?></h3>
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
	<img src="./skins/<?=$skin?>/screenshot.jpg" width="320" alt="skin screenshot" />
<? } else { ?>
	<div class="skins-noscreenshot">No Screen Shot</div>
<? } ?>
</div>
<? } ?>
<p style="clear: left"></p>
</div>
</div>

<p><input type="submit" value="OK" /></p>
</form>
