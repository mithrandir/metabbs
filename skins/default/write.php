<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this) && sendingRequest()">
<? if ($account->is_guest() || $post->exists() && $post->user_id == 0 && $account->level < $board->perm_delete) { ?>
<p><?=label_tag("Name", "post", "name")?> <?=text_field("post", "name", $post->name)?></p>
<p><?=label_tag("Password", "post", "password")?> <?=password_field("post", "password")?></p>
<? } ?>
<p><?=label_tag("Title", "post", "title")?> <?=text_field("post", "title", $post->title, 50)?></p>
<? if ($board->use_category) { ?>
<p><?=label_tag("Category", "post", "category_id")?>
<select name="post[category_id]" id="post_category_id">
<? foreach ($board->get_categories() as $category) { ?>
<option value="<?=$category->id?>"<? if ($category->id==$post->category_id) { ?> selected="selected"<? } ?>><?=$category->name?></option>
<? } ?>
</select>
<? } ?>
<? if ($account->is_admin()) { ?>
<p><?=label_tag("Notice", "post", "type")?> <?=check_box("post", "type", $post->type)?></p>
<? } ?>
<p><?=text_area("post", "body", 12, 60, $post->body)?></p>

<? if ($board->use_attachment) { ?>
<h3><?=i('Attachments')?> <span class="info"><a href="#" onclick="addFileEntry(); return false" style="font-size: 12px">+ <?=i('Add file...')?></a></span></h3>
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
<p><?=submit_tag($action == 'post' ? "Post" : "Edit")?> <span id="sending"><?=image_tag("$skin_dir/spin.gif", 'Sending...')?></span></p>
</form>
