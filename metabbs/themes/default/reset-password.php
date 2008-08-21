<h1><?=i('Reset Password')?></h1>
<? if ($error) { ?>
<p class="meta-error"><?=$error?></p>
<? } else { ?>
<form method="post" action="" id="login-form" onsubmit="if ($('password').value != $('password-verify').value) { alert('두번째 입력한 암호가 다르네요.'); return false }">
<p><label for="password" class="field"><?=i('Password')?><span class="star">*</span></label> <input type="password" name="password" id="password" /></p>
<p><label for="password-verify" class="field"><?=i('Password (again)')?><span class="star">*</span></label> <input type="password" name="password_verify" id="password-verify" /></p>
<p><input type="submit" value="<?=i('Reset Password')?>" /></p>
</form>
<? } ?>
