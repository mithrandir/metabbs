<form method="post">
<ul id="edit-section">
    <li class="selected"><a href="#general"><?=i('General')?></a></li>
    <li><a href="#permission"><?=i('Permission')?></a></li>
    <li><a href="#skin"><?=i('Skin')?></a></li>
<? if ($board->use_category) { ?>
    <li><a href="#category"><?=i('Category')?></a></li>
<? } ?>
</ul>
<div id="general">
<h2><?=i('General')?></h2>
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
	<?=text_field('board', 'posts_per_page', $board->posts_per_page)?>
</p>
<p>
	<?=label_tag("Use attachment", "board", "use_attachment")?>
	<?=check_box('board', 'use_attachment', $board->use_attachment)?>
</p>
<p>
	<?=label_tag("Use category", "board", "use_category")?>
	<?=check_box('board', 'use_category', $board->use_category)?>
</p>
</div>

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

<div id="skin">
<h2><?=i('Skin')?></h2>
<div id="skins-available">
<? foreach ($skins as $skin) { ?>
<div class="skins-item">
<h3><input type="radio" name="board[skin]" value="<?=$skin?>" <? if ($board->skin == $skin) { ?>checked="checked"<? } ?> /> <?=$skin?></h3>
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
	<img src="<?=_url_for("skins/$skin/screenshot.jpg")?>" width="320" alt="skin screenshot" />
<? } else { ?>
	<div class="skins-noscreenshot"><?=i('No Screenshot')?></div>
<? } ?>
</div>
<? } ?>
<p style="clear: left"></p>
</div>
</div>

<? if ($board->use_category) { ?>
<div id="category">
<ul>
<? foreach ($board->get_categories() as $category) { ?>
	<li><?=$category->name?></li>
<? } ?>
	<li><input type="text" name="categories[]" /></li>
</ul>
</div>
<? } ?>

<p><input type="submit" value="OK" /></p>
</form>
