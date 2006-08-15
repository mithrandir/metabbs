<form method="post" onsubmit="return checkForm(this)">
<p><span class="star">*</span> Required</p>
<p>
	<label>User ID<span class="star">*</span></label>
<? if (isset($flash)) { // error ?>
	<input type="text" name="user[user]" class="blank" /> <?=$flash?>
<? } else { ?>
	<input type="text" name="user[user]" />
<? } ?>
</p>
<p>
	<label>Password<span class="star">*</span></label>
	<input type="password" name="user[password]" />
</p>
<p>
	<label>Name<span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
<p>
	<label>E-Mail Address</label>
	<input type="text" name="user[email]" size="50" class="ignore" value="<?=$account->email?>" />
</p>
<p>
	<label>Homepage</label>
	<input type="text" name="user[url]" size="50" class="ignore" value="<?=$account->url?>" />
</p>
<p><input type="submit" value="Sign up" />
</form>
