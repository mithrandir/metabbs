<? include "_account_menu.php" ?>

<h1><?=i('Transfer to Default Account')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<form method="post" action="<?=url_with_referer_for('account', 'transfer', $params)?>" id="account-transfer-form">
<fieldset>
<h2>기본 정보</h2>
<p>
	<label><?=i('OpenID')?><span class="star">*</span></label>
	
</p>
<p>
	<label><?=i('User ID')?><span class="star">*</span></label>
	<input type="text" name="user[user]" value="<?=$user->user?>" class="<?=marked_by_error_message('user', $error_messages)?>"/>
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
<p><input type="submit" value="<?=i('Transfer')?>" class="button" /><? if (isset($_GET['url']) && !empty($_GET['url'])): ?> <a href="<?=$_GET['url']?>"><?=i('Cancel')?></a><? endif; ?></p></p>
</fieldset>
</form>