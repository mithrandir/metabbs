<h2><?=i('Edit Comment')?></h2>
<form method="post">
<p>
	<? if ($ask_password) { ?>
	<?=i("Password")?>: <input type="password" name="password" />
	<? } ?>
	<textarea name="body" rows="5" cols="50"><?=$comment->body?></textarea>
</p>
<p><?=submit_tag(i("Edit"))?></p>
</form>
