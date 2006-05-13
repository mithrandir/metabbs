<?php
function print_skin_screenshot($skin, $class = '') {
	global $board;
?>
<div<?=($class == '') ? '' : " class=\"$class\""?>>
<h4><?=$skin?></h4>
<a href="?action=save&amp;skin=<?=$skin?><? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
	<img src="./skins/<?=$skin?>/screenshot.jpg" width="320" alt="skin screenshot" />
<? } else { ?>
	<div class="skins-noscreenshot">No Screen Shot</div>
<? } ?>
</a>
</div>
<? } ?>

<ul id="edit-section">
    <li><a href="?action=edit_general<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">General</a></li>
    <li><a href="?action=edit_permission<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Permission</a></li>
    <li class="selected">Skin</li>
</ul>
<h2>Skin</h2>
<div id="skins-current">
<h3>Current Skin</h3>
<? print_skin_screenshot($board->skin, 'selected');?>
</div>
<div id="skins-available">
<h3>Available Skins</h3>
<? foreach ($skins as $skin) { ?>
<? print_skin_screenshot($skin, 'skins-item');?>
<? } ?>
<p style="clear: left"></p>
</div>
