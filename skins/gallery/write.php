<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this)">
<? if ($account->is_guest() || $post->exists() && $post->user_id == 0 && $account->level < $board->perm_delete) { ?>
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
<? if ($board->use_attachment && !$post->exists()) { ?>
<p><?=label_tag("Image", "post", "upload")?> <input type="file" name="upload[]" size="50" id="post_upload"<? if ($account->is_admin()) { ?> class="ignore"<? } ?>/></p>
<? } ?>
<p><?=text_area("post", "body", 6, 50, $post->body)?></p>

<? if ($account->is_admin()) { ?>
<p><?=check_box("post", "type", $post->type)?> <label for="post_type" class="checkbox"><?=i('Notice')?></label></p>
<? } ?>

<p><?=submit_tag($action == 'post' ? "Post" : "Edit")?></p>
</form>

<div id="gallery-footer">
<a href="<?=$link_list?>"><?=i('List')?></a>
<? if ($link_cancel) { ?>| <a href="<?=$link_cancel?>"><?=i('Cancel')?></a><? } ?>
</div>
