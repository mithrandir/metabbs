<h1><?=i('Sign up')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<form method="post" onsubmit="return checkForm(this)" id="signup-form">
<fieldset>
<h2>필수 정보</h2>
<p>
	<label><?=i('User ID')?><span class="star">*</span></label>
	<input type="text" name="user[user]" value="<?=$account->user?>" class="<?=marked_by_error_message('user', $error_messages)?>"/>
	<span id="notification"></span>
	<input type="button" value="중복 확인" onclick="checkUserID(this.form['user[user]'])" />
</p>
<p>
	<label><?=i('Password')?><span class="star">*</span></label>
	<input type="password" name="user[password]" class="<?=marked_by_error_message('password', $error_messages)?>"/>
</p>
<p>
	<label><?=i('Password (again)')?><span class="star">*</span></label>
	<input type="password" name="user[password_again]" class="<?=marked_by_error_message('password_again', $error_messages)?>"/>
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" class="<?=marked_by_error_message('name', $error_messages)?>"/>
</p>
<p>
	<label><?=i('E-Mail Address')?><span class="star">*</span></label>
	<input type="text" name="user[email]" size="50" class="<?=marked_by_error_message('email', $error_messages)?>" value="<?=$account->email?>" />
</p>
<? if (isset($captcha) && $captcha->ready()) { ?>
<p>
	<label><?=i('CAPTCHA')?><span class="star">*</span></label>
	<?= $captcha->get_html() ?>
</p>
<? } ?>
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
</fieldset>
<p><input type="submit" value="<?=i('Sign up')?>" /><? if (isset($_GET['url']) && !empty($_GET['url'])): ?> <a href="<?=$_GET['url']?>"><?=('Cancel')?></a><? endif; ?></p></p>
</form>
