<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this)">
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name", "post", "name")?> <?=text_field("post", "name", $post->name)?></p>
<p><?=label_tag("Password", "post", "password")?> <?=password_field("post", "password")?></p>
<? } ?>
<p><?=text_field("post", "title", $post->title, 40)?>
<? if ($board->use_category) { ?>
<select name="post[category_id]" id="post_category_id" class="ignore">
<? foreach ($board->get_categories() as $category) { ?>
<?=option_tag($category->id, $category->name, $category->id == $post->category_id)?>
<? } ?>
</select>
<? } ?></p>
<p><?=text_area("post", "body", 12, 60, $post->body, array('id' => 'post_body'))?></p>

<? if ($board->use_attachment) { ?>
<h5><?=i('Attachments')?></h5>
<p>Max upload size: <?=ini_get('upload_max_filesize')?> <a href="#" onclick="addFileEntry()">+</a></p>
<ol id="uploads">
<? if ($post->exists()) { ?>
<? foreach ($post->get_attachments() as $attachment) { ?>
<? if (!$attachment->file_exists()) $attachment->filename = "<del>$attachment->filename</del>"; ?>
	<li><?=$attachment->filename?> <label><input type="checkbox" name="delete[]" value="<?=$attachment->id?>" /> Delete</li>
<? } ?>
<? } ?>
	<li><input type="file" name="upload[]" size="50" class="ignore" /></li>
</ol>
<? } ?>
<p><?=submit_tag($action == 'post' ? "Post" : "Edit")?></p>
</form>
