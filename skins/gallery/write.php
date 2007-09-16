<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this)">
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name", "post", "name")?> <?=text_field("post", "name", $post->name)?></p>
<p><?=label_tag("Password", "post", "password")?> <?=password_field("post", "password")?></p>
<? } ?>
<p><?=label_tag("Title", "post", "title")?> <?=text_field("post", "title", $post->title, 50)?></p>
<? if ($board->use_category) { ?>
<p><?=label_tag("Category", "post", "category_id")?>
<select name="post[category_id]" id="post_category_id" class="ignore">
<? foreach ($board->get_categories() as $category) { ?>
<?=option_tag($category->id, $category->name, $category->id == $post->category_id)?>
<? } ?>
</select>
<? } ?>

<p><?=text_area("post", "body", 6, 50, $post->body)?></p>

<? if ($account->has_perm('admin', $board)) { ?>
<p><?=check_box("post", "notice", $post->notice)?> <label for="post_notice" class="checkbox"><?=i('Notice')?></label></p>
<? } ?>

<? if ($board->use_attachment) { ?>
<h3>Upload Images</h3>
<p>Max upload size: <?=get_upload_size_limit()?></p>
<ol id="uploads">
<? if ($post->exists()) { ?>
<? foreach ($post->get_attachments() as $attachment) { ?>
<? if (!$attachment->file_exists()) $attachment->filename = "<del>$attachment->filename</del>"; ?>
	<li><?=$attachment->filename?> <label><input type="checkbox" name="delete[]" value="<?=$attachment->id?>" /> Delete</li>
<? } ?>
<? } ?>
	<li><input type="file" name="upload[]" size="50" class="ignore" /></li>
</ol>
<p><a href="#" onclick="addFileEntry(); return false">+ <?=i('Add file...')?></a></p>
<? } ?>

<? if ($extra_attributes) { ?>
<div id="metadata">
<h3>추가 정보</h3>
<? foreach ($extra_attributes as $attr) { ?>
<p><label><?=htmlspecialchars($attr->name)?></label> <? $attr->render($post->get_attribute($attr->key)); ?></p>
<? } ?>
</div>
<? } ?>

<p><?=submit_tag($action == 'post' ? "Post" : "Edit")?></p>
</form>

<div id="gallery-footer">
<a href="<?=$link_list?>"><?=i('List')?></a>
<? if ($link_cancel) { ?>| <a href="<?=$link_cancel?>"><?=i('Cancel')?></a><? } ?>
</div>
