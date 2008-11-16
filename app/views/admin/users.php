<h2><?=i('Users')?></h2>

<form method="get" action="<?=url_for('admin', 'users')?>">
<p>
<select name="key">
	<?=option_tag('name', i('Name'), !isset($_GET['key']) || $_GET['key'] == 'name')?>
	<?=option_tag('user', i('User ID'), isset($_GET['key']) && $_GET['key'] == 'user')?>
</select>
<input type="text" name="query" value="<?=isset($_GET['query']) ? $_GET['query'] : ''?>" /> <input type="submit" value="<?=i('Search')?>" /></p>
</form>

<form method="post" action="<?=url_for('user', 'edit')?>?page=<?=$page?>">
<table id="users">
<tr>
	<th><input type="checkbox" value="1" onchange="checkAll(this.form, this.checked)" /></th>
	<th class="name"><?=i('Name')?></th>
	<th class="level"><?=i('Level')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($users as $user) { ?>
<tr>
	<td><input type="checkbox" name="user_id[<?=$user->id?>]" class="check" <? if ($user->id==$account->id) { ?>disabled="disabled" <? } ?> /></td>
	<td class="name"><?=htmlspecialchars($user->name)?> <small>(<?=htmlspecialchars($user->user)?>)</small></td>
	<td class="level"><?=$user->level?></td>
	<td class="actions"><?=link_to(i('View'), $user)?><? if (!$user->is_admin()) { ?> | <a href="<?=url_for($user, 'delete')?>?page=<?=$page?>" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Delete user')?></a><? } ?><? if ($user->id != $account->id && !preg_match('@^http://@', $user->user)) { ?> | 
	<? if ($user->get_attribute('pwresetcode')) { ?><a href="<?=url_for($user, 'reset-password')?>">암호 초기화 상태</a>
	<? } else { ?><a href="<?=url_for($user, 'reset-password')?>" onclick="return confirm('<?=i('Are you sure?')?>')">암호 초기화</a><? } } ?></td>
</tr>
<? } ?>
</table>

<? _print_pages($page, $users_count, 10); ?>

<h3><?=i('Mass operation')?></h3>
<ul id="operations">
	<li><input type="radio" name="mass_operation" id="mass_operation_level" value="level" checked="checked" /><?=i('Change levels of selected users to %s', '<input type="text" name="level" value="1" size="3" />')?> (0~255)</li>
	<li><input type="radio" name="mass_operation" id="mass_operation_delete" value="delete" /><?=i('Delete selected users')?></li>
</ul>
<p><input type="submit" value="OK" /></p>
</form>

