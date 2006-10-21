<form method="post" action="?tab=skin">
<div id="skin">
<h2><?=i('Skin')?></h2>
<div id="skins-available">
<? foreach ($skins as $skin) { ?>
<div class="skins-item">
<h3><input type="radio" name="board[skin]" value="<?=$skin?>" <? if ($board->skin == $skin) { ?>checked="checked"<? } ?> /> <?=$skin?></h3>
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
	<img src="<?=METABBS_BASE_PATH."skins/$skin/screenshot.jpg"?>" width="320" alt="skin screenshot" />
<? } else { ?>
	<div class="skins-noscreenshot"><?=i('No Screenshot')?></div>
<? } ?>
</div>
<? } ?>
<p style="clear: left"></p>
</div>
</div>
</form>
