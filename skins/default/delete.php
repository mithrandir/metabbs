<h2><?=i('Delete')?></h2>
<form method="post">
<p>
	<? if ($ask_password) { ?>
	<?=i("Password")?>: <input type="password" name="password" />
	<? } ?>
	<?=submit_tag(i("Delete"))?>
</p>
</form>
<div id="nav">
<a href="<?=$link_cancel?>"><?=i('Cancel')?></a>
</div>
