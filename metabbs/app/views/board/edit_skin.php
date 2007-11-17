<div id="current-style">
<h2>현재 사용중인 모양새</h2>
<table>
<tr>
	<td class="preview-image">
	<? if (file_exists('styles/'.$board->style.'/preview.png')) { ?>
	<img src="<?=$current_style->get_path()?>/preview.png" alt="Preview" />
	<? } ?>
	</td>
	<td>
		<span class="style-name"><?=$current_style->fullname?></span><br />
		<span class="creator">Created by <?=htmlspecialchars($current_style->creator)?></cite><br />
		<span class="engine">Licensed under <?=array_key_exists($current_style->license, $license_mapping)?$license_mapping[$current_style->license]:htmlspecialchars($current_style->license)?></span>
	</td>
</tr>
</table>
</div>
<div id="change-style">
<h2>모양새 바꾸기</h2>
<ul>
<? foreach ($styles as $style) { ?>
<? if ($style->name != $current_style->name) { ?>
	<li>
	<div class="preview-image" onclick="location.href='?tab=skin&amp;style=<?=$style->name?>'">
	<? if (file_exists('styles/'.$style->name.'/preview.png')) { ?>
	<img src="<?=$style->get_path()?>/preview.png" alt="Preview" />
	<? } ?>
	</div>
	<a href="?tab=skin&amp;style=<?=$style->name?>"><?=$style->fullname?></a>
	</li>
<? } ?>
<? } ?>
</ul>
</div>
