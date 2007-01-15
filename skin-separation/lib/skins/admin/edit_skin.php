<form method="post" action="?tab=skin">
<div id="skin">
<h2><?=i('Skin')?></h2>
<ul>
<? foreach ($skins as $skin) { ?>
<li><input type="radio" name="board[skin]" value="<?=$skin?>" <? if ($board->skin == $skin) { ?>checked="checked"<? } ?> onchange="this.form.submit()" /> <?=$skin?></li>
<? } ?>
</ul>
</form>
