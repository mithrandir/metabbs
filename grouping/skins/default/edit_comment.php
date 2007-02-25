<h2><?=i('Edit Comment')?></h2>
<form method="post" onsubmit="return checkForm(this)">
<? if ($ask_password) { ?>
<p><?=i("Password")?>: <input type="password" name="password" /></p>
<? } ?>
<p><textarea name="body" rows="5" cols="50"><?=$comment->body?></textarea></p>
<p><?=submit_tag(i("Edit"))?></p>
</form>
<div id="nav">
<a href="<?=$link_cancel?>"><?=i('Cancel')?></a>
</div>
