<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<ul id="edit-section">
    <li class="selected"><a href="#general">General</a></li>
    <li><a href="#permission">Permission</a></li>
    <li><a href="#skin">Skin</a></li>
</ul>
<div id="general">
<h2>General</h2>
<p>
	<?=label_tag("Name", "board", "name")?>
	<?=text_field('board', 'name', $board->name)?>
</p>
<p>
	<?=label_tag("Title", "board", "title")?>
	<?=text_field('board', 'title', $board->title)?>
</p>
<p>
	<?=label_tag("Posts per page", "board", "posts_per_page")?>
	<?=text_field('board', 'posts_per_page', 10, $board->posts_per_page)?>
</p>
<p>
	<?=label_tag("Use attachment", "board", "use_attachment")?>
	<?=check_box('board', 'use_attachment', $board->use_attachment)?>
</p>
</div>

<div id="permission">
<h2>Permission</h2>
<p>
	<?=label_tag("Read", 'board', 'perm_read')?>
	More than level <?=text_field('board', 'perm_read', '0', 3)?>
</p>
<p>
	<?=label_tag("Write", 'board', 'perm_write')?>
	More than level <?=text_field('board', 'perm_write', '0', 3)?>
</p>
<p>
	<?=label_tag("Comment", 'board', 'perm_comment')?>
	More than level <?=text_field('board', 'perm_comment', '0', 3)?>
</p>
<p>
	<?=label_tag("Edit/Delete", 'board', 'perm_delete')?>
	Writer and more than level <?=text_field('board', 'perm_delete', '255', 3)?>
</p>
</div>

<div id="skin">
<h2>Skin</h2>
<div id="skins-available">
<? foreach ($skins as $skin) { ?>
<div class="skins-item">
<h3><input type="radio" name="board[skin]" value="<?=$skin?>" <? if ($board->skin == $skin) { ?>checked="checked"<? } ?> /> <?=$skin?></h3>
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
