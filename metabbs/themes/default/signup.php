<h1>회원 가입</h1>
<form method="post" onsubmit="return checkForm(this)" id="signup-form">

<fieldset>
<h2>필수 정보</h2>
<p>
	<label><?=i('User ID')?><span class="star">*</span></label>
	<input type="text" name="user[user]" value="<?=$account->user?>" class="<?=$error->exists_by_field('user') ? 'error':'';?>"/>
	<span id="notification">
	<? if($messge = $error->get_first_error_message('user')) echo i($messge).'.' ?>
	</span>
	<input type="button" value="중복 확인" onclick="checkUserID(this.form['user[user]'])" />
</p>
<p>
	<label><?=i('Password')?><span class="star">*</span></label>
<? if ($errors = $error->exists_by_field('password')) { // error ?>
	<input type="password" name="user[password]" class="blank <?=$error->exists_by_field('password') ? 'error':'';?>" /> 
	<? if($messge = $error->get_first_error_message('password')) echo i($messge).'.' ?>
<? } else { ?>
	<input type="password" name="user[password]" /> 
	<?=i('Password length must be longer than 5')?>.
<? } ?>
</p>
<p>
	<label><?=i('Password (again)')?><span class="star">*</span></label>
	<input type="password" name="user[password_again]" class="<?=$error->exists_by_field('password_again') ? 'error':'';?>"/>
	<? if($messge = $error->get_first_error_message('password_again')) echo i($messge).'.' ?>
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
<? if (isset($captcha) && $captcha->ready()) { ?>
<p>
	<label><?=i('CAPTCHA')?><span class="star">*</span></label>
	<?= $captcha->get_html() ?>
	<? if($messge = $error->get_first_error_message('captcha')) echo i($messge).'.' ?>
</p>
<? } ?>
</fieldset>
<fieldset>
<h2>추가 정보</h2>
<p>
	<label><?=i('E-Mail Address')?></label>
	<input type="text" name="user[email]" size="50" class="ignore <?=$error->exists_by_field('email') ? 'error':'';?>" value="<?=$account->email?>" />
	<? if($messge = $error->get_first_error_message('email')) echo i($messge).'.' ?>
</p>
<p>
	<label><?=i('Homepage')?></label>
	<input type="text" name="user[url]" size="50" class="ignore <?=$error->exists_by_field('url') ? 'error':'';?>" value="<?=$account->url?>" />
	<? if($messge = $error->get_first_error_message('url')) echo i($messge).'.' ?>
</p>
<p>
	<label><?=i('Signature')?></label>
	<textarea name="user[signature]" cols="50" rows="5" class="ignore"><?=$account->signature?></textarea>
</p>
</fieldset>
<p><input type="submit" value="<?=i('Sign up')?>" /></p>
</form>
