<h1 class="account-title"><?=i('Login')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>

<? if (using_default_authentication()): ?>
<form method="post" action="<?=url_with_referer_for('account', 'login') ?>" id="login-form" class="account-form">
<p><label for="user" class="field"><?=i('User ID')?></label> <input type="text" name="user" id="user" /></p>
<p><label for="password" class="field"><?=i('Password')?></label> <input type="password" name="password" id="password" /></p>
<p><input type="checkbox" name="autologin" id="autologin" value="1" /> <label for="autologin"><?=i('Auto Login')?></label></p>
<p><input type="submit" value="<?=i('Login')?>" class="button"/> 
<a href="<?=url_with_referer_for('account', 'signup')?>"><?=i('Sign up')?></a>
<? if($config->get('use_forget_password', false)): ?> <a href="<?=url_with_referer_for('account', 'forget-password')?>"><?=i('Forget Password')?></a><? endif; ?>
<? if (!is_xhr() && isset($_GET['url']) && !empty($_GET['url'])): ?> <a href="<?=$_GET['url']?>" class="button dialog-close"><?=i('Cancel')?></a><? endif; ?>
</p>
</form>
<? endif; ?>

<? if (using_openid()): ?>
<form method="post" action="<?=url_with_referer_for('openid', 'login')?>" id="openid-form" class="account-form">
<p><label for="openid_identifier" class="field"><?=i('OpenID')?></label> <input type="text" name="openid_identifier" id="openid_identifier" style="" /></p>
<p><input type="checkbox" name="autologin" value="1" id="openid_autologin" /> <label for="openid_autologin"><?=i('Auto Login')?></label></p>
<p><input type="submit" value="<?=i('Login')?>" class="button"/></p>
</form>
</form>
<? endif; ?>
