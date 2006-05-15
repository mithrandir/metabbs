<form method="post" enctype="multipart/form-data" action="<?=url_for($board, 'post')?>" onsubmit="return sendForm(this)">
<? include($_skin_dir . '_form.php'); ?>
<p><input type="submit" value="Post" accesskey="s" /> <span id="sending"><img src="<?=$skin_dir?>/spin.gif" alt="Sending" /> Sending...</span></p>
</form>

<div id="nav">
<p><a href="<?=$board->get_href()?>">Back to List</a></p>
</div>
