<form method="post" action="?tab=skin">
<div id="skin">
<ul>
<? foreach ($styles as $style) { ?>
<li><input type="radio" name="board[style]" value="<?=$style?>" <? if ($board->style == $style) { ?>checked="checked"<? } ?> onchange="this.form.submit()" /> <?=$style?></li>
<? } ?>
</ul>
</form>
