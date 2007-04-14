<h2><?=i('Edit Comment')?></h2>
<form method="post" onsubmit="return checkForm(this)">
<table id="commentform">
<? if ($ask_password) { ?>
<tr>
	<th><?=i("Password")?></th>
	<td><input type="password" name="password" /></td>
</tr>
<? } ?>
<tr>
	<td colspan="2"><textarea name="body" rows="5" cols="50"><?=$comment->body?></textarea></td>
</tr>
</table>
<p><?=submit_tag(i("Edit"))?></p>
</form>

<div id="meta-actions">
<a href="<?=$link_cancel?>"><?=i('Cancel')?></a>
</div>
