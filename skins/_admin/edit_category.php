<div id="category">
<h2><?=i('Category')?></h2>
<table id="boards">
<tr>
	<th><?=i('Name')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? foreach ($board->get_categories() as $category) { ?>
<tr>
	<td><?=$category->name?></td>
	<td><a href="<?=url_for($category, 'delete')?>" onclick="return window.confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a></td>
</tr>
<? } ?>
<tr>
	<td><input type="text" name="categories[]" /></td>
	<td><input type="submit" value="<?=i('Add category')?>" /></td>
</tr>
</table>
</div>
