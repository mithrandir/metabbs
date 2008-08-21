<h1><?=i('Login')?></h1>
<?php if ($error): ?>
<p class="meta-error"><?=$error?></p>
<?php endif; ?>
<form method="post" action="" id="login-form">
<p><label for="user" class="field"><?=i('User ID')?></label> <input type="text" name="user" id="user" /></p>
<p><label for="password" class="field"><?=i('Password')?></label> <input type="password" name="password" id="password" /></p>
<p><input type="checkbox" name="autologin" id="autologin" value="1" /> <label for="autologin"><?=i('Auto Login')?></label></p>
<p><input type="submit" value="<?=i('Login')?>" /> <a href="<?=url_with_referer_for('account', 'signup')?>"><?=i('Sign up')?></a><? if($config->get('use_forget_password', false)): ?> <a href="<?=url_for('account', 'forget-password')?>"><?=i('Forget Password')?></a><? endif; ?>
</p>
</form>
