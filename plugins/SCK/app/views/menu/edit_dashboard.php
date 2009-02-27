<?php
function print_dashboard_entry($x, $y) {
	global $account, $menu, $metabbs;
	$admin = $account->is_admin();
	$alloc = $menu->get_attribute("dashboard_$x,$y", false);
?>
	<td>
	<div class="entry">
		<p>이 자리에 최근 게시물 출력:
		<select name="board_name[<?="$x,$y"?>]">
			<option value=""<?=!$alloc ? ' selected="selected"' : ''?>>안함</option>
		<?php foreach (Board::find_all() as $board): ?>
			<option value="<?=$board->name?>"<?=$alloc == $board->name ? ' selected="selected"' : ''?>><?=$board->get_title()?></option>
		<?php endforeach; ?>
		</select>
		</p>
	</div>
	</td>
<?php
}
?>
<form method="POST" action="<?=url_for($menu, 'edit')?>">
<p>이름: <input type="text" name="name" size="30" value="<?=htmlspecialchars($menu->name)?>" /></p>

<table class="dashboard editing">
	<tr>
		<?php print_dashboard_entry(0, 0); ?>
		<?php print_dashboard_entry(1, 0); ?>
	</tr>

	<tr>
		<?php print_dashboard_entry(0, 1); ?>
		<?php print_dashboard_entry(1, 1); ?>
	</tr>
</table>

<p><input type="submit" value="OK" /></p>
</form>
