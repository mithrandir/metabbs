<h1><?=i('Forget Password')?></h1>
<? if ($error): ?>
<p class="meta-error"><?=$error?></p>
<? endif; ?>
<? if ($flash) { ?>
<p class="meta-error"><?=$flash?></p>
<? } else { ?>
<form method="post" action="" id="login-form" onsubmit="if ($('user').value.length == 0 || $('name').value.length == 0 ) { alert('아이디와 이름을 입력해주세요.'); return false }">
<p>
	<label><?=i('User ID')?><span class="star">*</span></label>
	<input type="text" name="user" id="user" value="" />
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="name" id="name" value="" />
</p>
<p><input type="submit" value="<?=i('Reset Password')?>" /></p>
</form>
<? } ?>