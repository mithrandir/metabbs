<h2><?=htmlspecialchars($menu->name)?></h2>

<p><?=format_plain($menu->body)?></p>

<? if ($account->is_admin()): ?>
<p><a href="<?=url_for($menu, 'edit')?>">Edit</a></p>
<? endif; ?>
