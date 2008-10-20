<div id="category">
<h2><?=i('Category')?></h2>

<table id="boards">
<tr>
	<th><?=i('Name')?></th>
	<th><?=i('Post count')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? if ($un->exists()) { ?>
<tr>
	<td class="name"><?=i('Uncategorized Posts')?></td>
	<td class="post_count"><?= $un->get_post_count() ?></td>
	<td/>
</tr>
<? } ?>
<? foreach ($board->get_categories() as $category) { ?>
<tr>
	<td class="name"><?=$category->name?> <span id="category-<?=$category->id?>"></span></td>
	<td class="post_count"><?=$category->get_post_count()?></td>
	<td><a href="<?=url_for($category, 'rename')?>" onclick="editCategory('category-<?=$category->id?>', this.href); return false"><?=i('Rename')?></a> |
	<?= $category->is_first() ? i('Move up') : "<a href=\"".url_for($category, 'up')."\">".i('Move up')."</a>" ?> |
	<?= $category->is_last() ? i('Move down') : "<a href=\"".url_for($category, 'down')."\">".i('Move down')."</a>" ?> |
	<a href="<?=url_for($category, 'delete')?>" onclick="return window.confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a>	</td>
</tr>
<? } ?>
</table>
<form method="post" action="?tab=category">
<p><input type="text" name="categories[]" /> <input type="submit" value="<?=i('Add category')?>" /></p>
</form>

<form method="post" action="?tab=category">
<h2><?=i('More options')?></h2>
<ul id="operations">
	<li><input type="radio" name="category[have_empty_item]" value="0"<? if (!$board->have_empty_item()) { ?> checked="checked"<? } ?> id="category_required" /> <label for="category_required">글 쓸 때 분류를 반드시 고르게 합니다.</label></li>
	<li><input type="radio" name="category[have_empty_item]" value="1"<? if ($board->have_empty_item()) { ?> checked="checked"<? } ?> id="category_optional" /> <label for="category_optional">글 쓸 때 분류를 비워둘 수 있게 합니다.</label></li>
</ul>
<p><input type="submit" value="OK" /></p>
</form>
</div>
