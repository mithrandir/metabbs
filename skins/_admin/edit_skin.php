<form method="post" action="?tab=skin">
<div id="skin">
<table>
<? foreach ($styles as $info) { list($style, $name, $creator, $license) = $info; ?>
<tr>
	<td>
	<input type="radio" name="board[style]" value="<?=$style?>" <? if ($board->style == $style) { ?>checked="checked"<? } ?> onchange="this.form.submit()" />
	</td>
	<td>
		<span class="style-name"><?=$name?></span><br />
		<span class="creator">Created by <?=htmlspecialchars($creator)?></cite><br />
		<span class="engine">Licensed under <?=$license_mapping[$license]?></span>
	</td>
</tr>
<? } ?>
</table>
</div>
</form>
