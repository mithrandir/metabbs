<h2>Move post</h2>
<form method="post" action="?">
<p>
<?=$board->get_title()?> &rarr;
<select name="board_id">
<? foreach ($boards as $board) { ?>
<? if ($board->id != $post->board_id) { ?>
	<option value="<?=$board->id?>"><?=$board->get_title()?></option>
<? } ?>
<? } ?>
</select>
<input type="submit" value="<?=i('Move')?>" />
</p>
<p><?=link_to(i('Cancel'), $post)?></p>
</form>
