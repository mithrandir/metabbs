<h1>정보 수정</h1>
<form method="post" onsubmit="return checkForm(this)" action="?url=<?=$_GET['url']?>">
<p><span class="star">*</span> <?=i('Required')?></p>
<p>
	<label><?=i('User ID')?></label>
	<?=$account->user?>
</p>
<p>
	<label><?=i('Password')?></label>
	<input type="password" name="user[password]" class="ignore" />
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
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
<p><input type="submit" value="<?=i('Edit Info')?>" />
</form>
