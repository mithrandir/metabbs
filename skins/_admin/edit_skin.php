<?php
function print_skin_screenshot ($skin) {
	global $board;
?>
<a href="?action=save&amp;skin=<?=$skin?><? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">
<h4><?=$skin?></h4>
<div>
<? if(file_exists("./skins/$skin/screenshot.jpg")) { ?>
<img src="./skins/<?=$skin?>/screenshot.jpg" style="width:320px;border:1px solid black;vertical-align:middle;" />
<? } else { ?>
<div style="width:320px;border:1px solid black;float:left;">No Screen Shot</div>
<? } ?>
</a>
<br />
<? } ?>

<ul id="edit_section">
    <li><a href="?action=edit_general<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">General</a></li>
    <li><a href="?action=edit_permission<? if ($board->exists()) { ?>&amp;board_id=<?=$board->id?><? } ?>">Permission</a></li>
    <li>Skin</li>
</ul>
<h2>Skin</h2>
<h3>Current Skin</h3>
<? print_skin_screenshot($board->skin);?>

<h3>Available Skins</h3>
<p>
<? foreach ($skins as $skin) { ?>
<? print_skin_screenshot($skin);?>
<? } ?>
</p>
