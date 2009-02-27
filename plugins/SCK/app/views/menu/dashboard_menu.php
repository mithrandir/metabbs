<?php
function print_dashboard_entry($x, $y) {
	global $menu, $metabbs;
	$alloc = $menu->get_attribute("dashboard_$x,$y", false);
?>
	<td><?php if ($alloc) $metabbs->printLatestPosts($alloc, 5, 30); ?></td>
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

<?php if ($account->is_admin()): ?>
<p><a href="<?=url_for($menu, 'edit')?>">Edit</a></p>
<?php endif; ?>
