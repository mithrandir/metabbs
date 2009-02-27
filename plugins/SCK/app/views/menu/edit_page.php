<form method="post" action="">
<p><?=i('Title')?>: <input type="text" name="page_title" size="30" value="<?=htmlspecialchars($menu->name)?>" /></p>
<p><textarea name="page_body" rows="15" cols="50"><?=htmlspecialchars($menu->body)?></textarea></p>
<p><input type="submit" value="<?=i('OK')?>" /></p>
</form>
