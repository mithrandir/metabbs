<h1><?=i('Forget Password')?></h1>

<? if ($error->exists()): ?>
<p class="meta-error"><? foreach ($error->get_all() as $error) { echo i($error).'.'; } ?></p>
<? endif; ?>

<? if (!isset($user) || !$user->get_attribute('pwresetcode', false)) { ?>
<form method="post" action="" id="login-form" onsubmit="if ($('user').value.length == 0 || $('name').value.length == 0 ) { alert('아이디와 이름을 입력해주세요.'); return false; }">
<p>
	<label><?=i('User ID')?><span class="star">*</span></label>
	<input type="text" name="user" id="user" value="<?=$_POST['user']?>" />
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="name" id="name" value="<?=$_POST['name']?>" />
</p>
<p><input type="submit" value="<?=i('Reset Password')?>" /> <? if($_GET['url']): ?><a href="<?=$_GET['url']?>">취소<a/><? endif; ?></p>
</form>
<? } ?>