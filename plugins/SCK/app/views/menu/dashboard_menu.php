<?php
function print_dashboard_entry($x, $y) {
	global $account, $menu, $metabbs;
	$admin = $account->is_admin();
	$alloc = $menu->get_attribute("dashboard_$x,$y", false);
?>
	<td>
	<?php if (!$alloc && $admin): ?>
		<form class="unallocated" method="POST" action="<?=url_for($menu, 'edit')?>">
		<input type="hidden" name="position" value="<?=$x?>,<?=$y?>" />
		<p>이 자리에 최근 게시물 출력:
		<select name="board_name">
		<?php foreach (Board::find_all() as $board): ?>
			<option value="<?=$board->name?>"><?=$board->get_title()?></option>
		<?php endforeach; ?>
		</select>
		<input type="submit" value="OK" />
		</p>
		</form>
	<?php elseif ($alloc): ?>
		<?php $metabbs->printLatestPosts($alloc, 5, 30); ?>
	<?php endif; ?>
	</td>
<?php
}
?>
<table class="dashboard">
	<tr>
		<?php print_dashboard_entry(0, 0); ?>
		<?php print_dashboard_entry(1, 0); ?>
	</tr>

	<tr>
		<?php print_dashboard_entry(0, 1); ?>
		<?php print_dashboard_entry(1, 1); ?>
	</tr>
</table>
