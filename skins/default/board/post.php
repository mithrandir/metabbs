<form method="post" enctype="multipart/form-data" action="<?=url_for($board, 'post')?>" onsubmit="return checkForm(this) && sendingRequest()">
<? include($_skin_dir . '/_form.php'); ?>
<p><?=submit_tag("Post")?> <span id="sending"><?=image_tag($skin_dir, 'Sending')?> Sending...</span></p>
</form>

<div id="nav">
    <p><?=link_to("Back to List", $board)?></p>
</div>
