<div id="thumbnail">
<form method="post" action="?tab=thumbnail">
<h2><?=i('Kind')?></h2>
<p class="thumbnail_kind">
	<input type="radio" name="thumbnail[kind]" value="0" <?= $board->get_attribute('thumbnail_kind') == 0 ? "checked=\"checked\"":"" ?>/>세로폭을 <?=i('Size')?>값으로 축소<br />
	<input type="radio" name="thumbnail[kind]" value="1" <?= $board->get_attribute('thumbnail_kind') == 1 ? "checked=\"checked\"":"" ?>/>폭,높이중 작은쪽을 <?=i('Size')?>값으로 축소<br />
	<input type="radio" name="thumbnail[kind]" value="2" <?= $board->get_attribute('thumbnail_kind') == 2 ? "checked=\"checked\"":"" ?>/>폭,높이중 큰쪽을 <?=i('Size')?>값으로 축소<br />
	<input type="radio" name="thumbnail[kind]" value="3" <?= $board->get_attribute('thumbnail_kind') == 3 ? "checked=\"checked\"":"" ?>/>정사각형폭을 <?=i('Size')?>값으로 축소/잘라내기<br />
	<input type="radio" name="thumbnail[kind]" value="4" <?= $board->get_attribute('thumbnail_kind') == 4 ? "checked=\"checked\"":"" ?>/><?=i('Width')?>, <?=i('Height')?>으로 축소/잘라내기
</p>
<dl>
	<dt><?=i('Size')?></dt>
	<dd><input type="text" name="thumbnail[size]" value="<?=$board->get_attribute('thumbnail_size')?>" /></dd>
	<dt><?=i('Width')?></dt>
	<dd><input type="text" name="thumbnail[width]" value="<?=$board->get_attribute('thumbnail_width')?>" /></dd>
	<dt><?=i('Height')?></dt>
	<dd><input type="text" name="thumbnail[height]" value="<?=$board->get_attribute('thumbnail_height')?>" /></dd>
</dt>
<p><input type="submit" value="OK" /></p>

</form>
</div>
