<form method="post" onsubmit="return checkForm(this)" action="?url=<?=url_for('account', 'edit')?>">
<p><span class="star">*</span> Required</p>
<p>
	<label>User ID<span class="star">*</span></label>
	<?=$account->user?>
</p>
<p>
	<label>Password</label>
	<input type="password" name="user[password]" class="ignore" />
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
<p>
	<label>Signature</label>
	<textarea name="user[signature]" cols="50" rows="5" class="ignore"><?=$account->signature?></textarea>
</p>
<p><input type="submit" value="Edit" />
</form>
