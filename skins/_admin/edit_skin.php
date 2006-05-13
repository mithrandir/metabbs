<?php
function print_skin_screenshot($skin, $class = '') {
	global $board;
?>
<div class="<?=$class?>">
<h3><input type="radio" name="skin" value="<?=$skin?>" <? if ($board->skin == $skin) { ?>checked="checked"<? } ?> /> <?=$skin?></h3>
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
	<img src="./skins/<?=$skin?>/screenshot.jpg" width="320" alt="skin screenshot" />
<? } else { ?>
	<div class="skins-noscreenshot">No Screen Shot</div>
<? } ?>
</div>
<? } ?>

<ul id="edit-section">
    <li><a href="?action=edit_general<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">General</a></li>
    <li><a href="?action=edit_permission<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Permission</a></li>
    <li class="selected">Skin</li>
</ul>

<form method="post" action="?action=save&amp;board_id=<?=$board->id?>">
<h2>Skin</h2>
<div id="skins-available">
<? foreach ($skins as $skin) { ?>
<? print_skin_screenshot($skin, 'skins-item');?>
<? } ?>
<p style="clear: left"></p>
</div>
<p><input type="submit" value="OK" /></p>
</form>
