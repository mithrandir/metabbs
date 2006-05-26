<h2><?=i('Users')?></h2>
<form method="post" action="?action=user_edit">
<table id="users">
<tr>
	<th><input type="checkbox" value="1" onchange="checkAll(this.form, this.checked)" /></th>
	<th class="name"><?=i('Name')?></th>
	<th class="level"><?=i('Level')?></th>
</tr>
<? foreach ($users as $user) { ?>
<tr>
	<td><input type="checkbox" name="user_id[<?=$user->id?>]" class="check" /></td>
	<td class="name"><?=$user->name?> <small>(<?=$user->user?>)</small></td>
	<td class="level"><?=$user->level?></td>
</tr>
<? } ?>
</table>

<h2><?=i('Change Level')?></h2>
<p><?=i('Change levels of selected users to %s', '<input type="text" name="level" value="1" size="3" />')?> (0~255) <input type="submit" value="OK" /></p>
</form>
