<h1>정보 고치기</h1>
<form method="post" onsubmit="return checkForm(this)" action="?url=<?=$_GET['url']?>" id="signup-form">
<fieldset>
<h2>기본 정보</h2>
<p>
	<label><?=i('User ID')?></label>
	<?=$account->user?>
</p>
<p>
	<label><?=i('Password')?></label>
	<input type="password" name="user[password]" class="ignore <?=$error->exists_by_field('password') ? 'error':'';?>" />
	<? if($messge = $error->get_first_error_message('password')) echo i($messge).'.' ?>
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
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
<p><input type="submit" value="<?=i('Edit Info')?>" /><? if($_GET['url']): ?><a href="<?=$_GET['url']?>">취소<a/><? endif; ?></p>
</fieldset>
</form>
