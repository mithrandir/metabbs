<h1><?=i('Reset Password')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<form method="post" action="" id="reset-password-form">
<p>
	<label for="password" class="field"><?=i('Password')?><span class="star">*</span></label> 
	<input type="password" name="password" id="password" class="<?=marked_by_error_message('password', $error_messages)?>"/>
</p>
<p>
	<label for="password_again" class="field"><?=i('Password (again)')?><span class="star">*</span></label> 
	<input type="password" name="password_again" id="password_again" class="<?=marked_by_error_message('password_again', $error_messages)?>" />
</p>
<p><input type="submit" value="<?=i('Reset Password')?>" class="button"/></p>
</form>