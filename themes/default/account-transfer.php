<h1 class="account-title"><?=i('Transfer to Default Account')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<form method="post" action="<?=url_with_referer_for('account', 'transfer')?>" id="account-transfer-form" class="account-form">
<fieldset>
<h2>기본 정보</h2>
<p>
	<label class="field"><?=i('OpenID')?><span class="star">*</span></label>
	<?= $account->user?>
</p>
<p>
	<label class="field"><?=i('User ID')?><span class="star">*</span></label>
	<input type="text" name="user[user]" value="<?=$user->user?>" class="<?=marked_by_error_message('user', $error_messages)?>"/>
</p>
<p>
	<label class="field"><?=i('Password')?><span class="star">*</span></label>
	<input type="password" name="user[password]" class="<?=marked_by_error_message('password', $error_messages)?>"/>
</p>
<p>
	<label class="field"><?=i('Password (again)')?><span class="star">*</span></label>
	<input type="password" name="user[password_again]" class="<?=marked_by_error_message('password_again', $error_messages)?>"/>
</p>
<p><input type="submit" value="<?=i('Transfer')?>" class="button" />
<? if (isset($_GET['url']) && !empty($_GET['url'])): ?> <a href="<?=$_GET['url']?>"><?=i('Cancel')?></a><? endif; ?></p></p>
</fieldset>
</form>
