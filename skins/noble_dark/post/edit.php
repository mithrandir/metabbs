<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this) && sendingRequest()">
<? $name = $post->name; include($_skin_dir . '_form.php'); ?>
<p><input type="submit" value="Edit" accesskey="s" />  <span id="sending"><img src="<?=$skin_dir?>/spin.gif" alt="Sending" /> Sending...</span></p>
</form>

<div id="nav">
<p><a href="<?=url_for($board)?>">Back to List</a> | <a href="<?=url_for($post)?>">Back</a></p>
</div>
