<form method="post" action="?action=save<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<ul id="edit_section">
    <li>General</li>
    <li><a href="?action=edit_permission<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Permission</a></li>
</ul>
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
	<div style="padding-left:10em;">
<? foreach ($skins as $skin) { ?>
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
		<img src="./skins/<?=$skin?>/screenshot.jpg" style="width:320px;border:1px solid black;vertical-align:middle;" />
<? } else { ?>
		<div style="width:320px;border:1px solid black;float:left;">No Screen Shot</div>
<? } ?>
<? if ($skin == $board->skin) { ?>
		<input type="radio" name="board[skin]" value="<?=$skin?>" selected="selected"><?=$skin?></input>
<? } else { ?>
		<input type="radio" name="board[skin]" value="<?=$skin?>"><?=$skin?></input>
<? } ?>
		<br />
<? } ?>
	</div>
</p>
<p>
	<label>Use attachment</label>
	<?=check_box('board', 'use_attachment')?>
</p>
<p><input type="submit" value="OK" /></p>
</form>
