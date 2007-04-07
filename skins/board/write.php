<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this)">
<table id="postform">
<? if ($account->is_guest() || $post->exists() && $post->user_id == 0 && $account->level < $board->perm_delete) { ?>
<tr>
	<th><?=label_tag("Name", "post", "name")?></th>
	<td class="name"><?=text_field("post", "name", $post->name)?></td>

	<th><?=label_tag("Password", "post", "password")?></th>
	<td class="password"><?=password_field("post", "password")?></td>
</tr>
<? } ?>
<tr>
	<th><?=label_tag("Title", "post", "title")?></th>
	<td colspan="3"><?=text_field("post", "title", $post->title, 50)?></td>
</tr>
<tr class="options">
	<th></th>
	<td colspan="3">
		<? if ($board->use_category) { ?>
		<select name="post[category_id]" id="post_category_id">
			<option value=""><?=i('Select category')?></option>
		<? foreach ($board->get_categories() as $category) { ?>
			<?=option_tag($category->id, $category->name, $category->id == $post->category_id)?>
		<? } ?>
		</select>
		<? } ?>
		<? if ($account->is_admin()) { ?><?=check_box("post", "type", $post->type)?> <?=label_tag("Notice", "post", "type")?><? } ?>
		<?=check_box("post", "secret", $post->secret)?> <?=label_tag("Secret Post", "post", "secret")?>
	</td>
</tr>
<tr>
	<td colspan="4" class="body"><?=text_area("post", "body", 15, 60, $post->body)?></td>
</tr>
</table>

<? if ($board->use_attachment) { ?>
<div id="upload">
<h3><?=i('Attachments')?> <span class="info"><a href="#" onclick="addFileEntry(); return false">+ <?=i('Add file...')?></a></span></h3>
<p><?=i('Max upload size')?>: <?=get_upload_size_limit()?></p>
<ol id="uploads">
<? if ($post->exists()) { ?>
<? foreach ($post->get_attachments() as $attachment) { ?>
<? if (!$attachment->file_exists()) $attachment->filename = "<del>$attachment->filename</del>"; ?>
	<li><?=$attachment->filename?> <label><input type="checkbox" name="delete[]" value="<?=$attachment->id?>" /> Delete</li>
<? } ?>
<? } ?>
	<li><input type="file" name="upload[]" size="50" class="ignore" /></li>
</ol>
</div>
<? } ?>
<p><?=submit_tag($action == 'post' ? "Post" : "Edit")?></p>
</form>

<div id="meta-actions">
<a href="<?=$link_list?>"><?=i('List')?></a>
<? if ($link_cancel) { ?>| <a href="<?=$link_cancel?>"><?=i('Cancel')?></a><? } ?>
</div>
