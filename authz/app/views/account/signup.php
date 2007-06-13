<form method="post" onsubmit="return checkForm(this)">
<p><span class="star">*</span> <?=i('Required')?></p>

<fieldset>
<p>
	<label><?=i('User ID')?><span class="star">*</span></label>
<? if (isset($flash) && $error_field == 'user') { // error ?>
	<input type="text" name="user[user]" class="blank" value="<?=$account->user?>" /> <?=$flash?>
<? } else { ?>
	<input type="text" name="user[user]" value="<?=$account->user?>" />
<? } ?>
</p>
<p>
	<label><?=i('Password')?><span class="star">*</span></label>
<? if (isset($flash) && $error_field == 'password') { // error ?>
	<input type="password" name="user[password]" class="blank" /> <?=$flash?>
<? } else { ?>
	<input type="password" name="user[password]" />
<? } ?>
</p>
<p>
	<label><?=i('Password (again)')?><span class="star">*</span></label>
	<input type="password" name="user[password_again]" />
</p>
</fieldset>
<fieldset>
<p>
	<label><?=i('Name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
<p>
	<label><?=i('E-Mail Address')?></label>
	<input type="text" name="user[email]" size="50" class="ignore" value="<?=$account->email?>" />
</p>
<p>
	<label><?=i('Homepage')?></label>
	<input type="text" name="user[url]" size="50" class="ignore" value="<?=$account->url?>" />
</p>
<p>
	<label><?=i('Signature')?></label>
	<textarea name="user[signature]" cols="50" rows="5" class="ignore"><?=$account->signature?></textarea>
</p>
</fieldset>
<p><input type="submit" value="<?=i('Sign up')?>" /></p>
</form>
