<div id="loginform">
<h2><?=i('Login')?></h2>
<? if (isset($flash)) { ?>
<p><?=$flash?></p>
<? } ?>
<form method="post">
<table>
<tr>
	<th><?=i('User ID')?></th>
	<td><input type="text" name="user" /></td>
</tr>
<tr>
	<th><?=i('Password')?></th>
	<td><input type="password" name="password" /></td>
</tr>
<tr>
	<td></td>
	<td><input type="checkbox" name="autologin" value="1" id="autologin" /> <label for="autologin"><?=i('Auto Login')?></label></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="<?=i('Login')?>" /> <?=signup()?></td>
</tr>
</table>
</form>
</div>
