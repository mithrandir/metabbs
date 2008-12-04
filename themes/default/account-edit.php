<h1><?=i('Account Edit')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<form method="post" onsubmit="return checkForm(this)" action="?url=<?=$_GET['url']?>" id="signup-form">
<fieldset>
<h2>기본 정보</h2>
<p>
	<label><?=i('User ID')?></label>
	<?=$account->user?>
</p>
<p>
	<label><?=i('Password')?></label>
	<input type="password" name="user[password]" class="ignore <?=marked_by_error_message('password', $error_messages)?>"/>
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
<p>
	<label><?=i('E-Mail Address')?><span class="star">*</span></label>
	<input type="text" name="user[email]" size="50" class="ignore <?=marked_by_error_message('email', $error_messages)?>" value="<?=$account->email?>" />
</p>
</fieldset>
<fieldset>
<h2>추가 정보</h2>
<p>
	<label><?=i('Homepage')?></label>
	<input type="text" name="user[url]" size="50" class="ignore <?=marked_by_error_message('url', $error_messages)?>" value="<?=$account->url?>" />
</p>
<p>
	<label><?=i('Signature')?></label>
	<textarea name="user[signature]" cols="50" rows="5" class="ignore"><?=$account->signature?></textarea>
</p>
<p><input type="submit" value="<?=i('Edit Info')?>" />
<? if (isset($_GET['url']) && !empty($_GET['url'])): ?> <a href="<?=$_GET['url']?>"><?=('Cancel')?></a><? endif; ?></p>
</fieldset>
</form>
