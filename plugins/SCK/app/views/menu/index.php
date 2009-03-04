<?php
if (isset($menu)):
	$GLOBALS['sck_context'] = $menu;
	include $menu->type . '_menu.php';
else:
	$GLOBALS['sck_context'] = new SCKManagerMenu;
?>
<h2>메뉴 관리</h2>
<ul>
<?php foreach (sck_primary_menus() as $menu): ?>
	<li><?=$menu->name?> (<?=$menu->type?>) <a href="<?=url_for($menu, 'delete')?>" onclick="return confirm('<?=i('Are you sure?')?>')">지우기</a> <a href="<?=url_for($menu, 'edit')?>">고치기</a></li>
<?php endforeach; ?>
</ul>

<p><a href="<?=url_for('menu', 'add')?>">메뉴 추가</a></p>
<?php endif; ?>
