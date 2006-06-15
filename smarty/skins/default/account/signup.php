<form method="post" onsubmit="return checkForm(this)">
<p><span class="star">*</span> Required</p>
<p>
	<label>User ID<span class="star">*</span></label>
<? if (isset($flash) && $flash{0} == 'U') { // error ?>
	<input type="text" name="user[user]" class="blank" value="<?=$user->user?>" /> <?=$flash?>
<? } else { ?>
	<input type="text" name="user[user]" value="<?=$user->user?>" />
<? } ?>
</p>
<p>
	<label>Password<span class="star">*</span></label>
<? if (isset($flash) && $flash{0} == 'P') { // error ?>
	<input type="password" name="user[password]" class="blank" /> <?=$flash?>
<? } else { ?>
	<input type="password" name="user[password]" />
<? } ?>
</p>
<p>
	<label>Name<span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$user->name?>" />
</p>
<p>
	<label>E-Mail Address</label>
	<input type="text" name="user[email]" size="50" class="ignore" value="<?=$user->email?>" />
</p>
<p>
	<label>Homepage</label>
	<input type="text" name="user[url]" size="50" class="ignore" value="<?=$user->url?>" />
</p>
<p><input type="submit" value="Sign up" /></p>
</form>
