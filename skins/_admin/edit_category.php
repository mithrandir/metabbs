<div id="category">
<h2><?=i('Category')?></h2>
<table id="boards">
<tr>
	<th><?=i('Name')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? foreach ($board->get_categories() as $category) { ?>
<tr>
	<td class="name"><?=$category->name?> <span id="category-<?=$category->id?>"></span></td>
	<td><a href="<?=url_for($category, 'rename')?>" onclick="editCategory('category-<?=$category->id?>', this.href); return false"><?=i('Rename')?></a> | <a href="<?=url_for($category, 'delete')?>" onclick="return window.confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a></td>
</tr>
<? } ?>
</table>
<form method="post" action="?tab=category">
<p><input type="text" name="categories[]" /> <input type="submit" value="<?=i('Add category')?>" /></p>
</form>
</div>
