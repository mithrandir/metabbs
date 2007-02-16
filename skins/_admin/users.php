<h2><?=i('Users')?></h2>
<form method="post" action="<?=url_for('user', 'edit')?>">
<table id="users">
<tr>
	<th><input type="checkbox" value="1" onchange="checkAll(this.form, this.checked)" /></th>
	<th class="name"><?=i('Name')?></th>
	<th class="level"><?=i('Level')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($users as $user) { ?>
<tr>
	<td><input type="checkbox" name="user_id[<?=$user->id?>]" class="check" /></td>
	<td class="name"><?=$user->name?> <small>(<?=$user->user?>)</small></td>
	<td class="level"><?=$user->level?></td>
	<td class="actions"><?=link_to(i('View'), $user)?> | <a href="<?=url_for($user, 'delete')?>" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Delete user')?></a></td>
</tr>
<? } ?>
</table>

<? _print_pages($page, $users_count, 10); ?>

<h3><?=i('Mass operation')?></h3>
<ul id="operations">
	<li><input type="radio" name="mass_operation" id="mass_operation_level" value="level" /><?=i('Change levels of selected users to %s', '<input type="text" name="level" value="1" size="3" />')?> (0~255)</li>
	<li><input type="radio" name="mass_operation" id="mass_operation_delete" value="delete" /><?=i('Delete selected users')?></li>
</ul>
<p><input type="submit" value="OK" /></p>
</form>
