<? if (isset($flash)) { ?>
<p><?=$flash?></p>
<? } ?>
<form method="post">
<p>
	<label><?=i('User ID')?>:</label>
	<input type="text" name="user" />
</p>
<p>
	<label><?=i('Password')?>:</label>
	<input type="password" name="password" />
</p>
<p>
	<label for="autologin"><input type="checkbox" name="autologin" value="1" id="autologin" /></label>
	<?=i('Auto Login')?>
</p>
<p><input type="submit" value="Login" /> <?=signup()?></p>
</form>
