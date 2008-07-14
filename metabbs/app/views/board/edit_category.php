<div id="category">
<h2><?=i('Category')?></h2>
<table id="boards">
<tr>
	<th><?=i('Name')?></th>
	<th><?=i('Post count')?></th>
	<th><?=i('Actions')?></th>
</tr>
<tr>
	<td class="name"><?=i('None')?></td>
	<td class="post_count"><?= $un->get_post_count() ?></td>
	<td/>
</tr>
<? foreach ($board->get_categories() as $category) { ?>
<tr>
	<td class="name"><?=$category->name?> <span id="category-<?=$category->id?>"></span></td>
	<td class="post_count"><?=$category->get_post_count()?></td>
	<td><a href="<?=url_for($category, 'rename')?>" onclick="editCategory('category-<?=$category->id?>', this.href); return false"><?=i('Rename')?></a> |
	<?= $category->is_first() ? i('Up') : "<a href=\"".url_for($category, 'up')."\">".i('Up')."</a>" ?> |
	<?= $category->is_last() ? i('Down') : "<a href=\"".url_for($category, 'down')."\">".i('Down')."</a>" ?> |
	<a href="<?=url_for($category, 'delete')?>" onclick="return window.confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a>	</td>
</tr>
<? } ?>
</table>
<form method="post" action="?tab=category">
<p><input type="text" name="categories[]" /> <input type="submit" value="<?=i('Add category')?>" /></p>
</form>

<form method="post" action="?tab=category">
<h2><?=i('Additional Setting')?></h2>
<dl>
	<dt><?=label_tag("Have empty item", "category", "have_empty_item")?></dt>
	<dd><?=check_box('category', 'have_empty_item', $board->have_empty_item())?></dd>
</dl>
<p><input type="submit" value="OK" /></p>
</form>
</div>
