<form method="post" action="?tab=skin">
<div id="skin">
<table>
<? foreach ($styles as $info) { list($style, $name, $creator, $license) = $info; ?>
<tr<? if ($board->style == $style) { ?> class="current"<? } ?>>
	<td><input type="radio" name="board[style]" value="<?=$style?>" <? if ($board->style == $style) { ?>checked="checked"<? } ?> onchange="this.form.submit()" /></td>
	<td>
	<? if (file_exists('styles/'.$style.'/preview.png')) { ?>
	<img src="<?=METABBS_BASE_PATH?>styles/<?=$style?>/preview.png" alt="Preview" />
	<? } ?>
	</td>
	<td>
		<span class="style-name"><?=$name?></span><br />
		<span class="creator">Created by <?=htmlspecialchars($creator)?></cite><br />
		<span class="engine">Licensed under <?=array_key_exists($license, $license_mapping)?$license_mapping[$license]:htmlspecialchars($license)?></span>
	</td>
</tr>
<? } ?>
</table>
</div>
</form>
