<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this) && sendingRequest()">
<? if ($user->is_guest() || $post->exists() && $post->user_id == 0 && $user->level < $board->perm_delete) { ?>
<p><label>Name:</label> <input type="text" name="post[name]" value="<?=$name?>" /></p>
<p><label>Password:</label> <input type="password" name="post[password]" /></p>
<? } ?>
<p><label>Title:</label> <input type="text" name="post[title]" size="50" value="<?=htmlspecialchars($post->title, ENT_COMPAT)?>" /></p>
<p><textarea name="post[body]" cols="60" rows="12"><?=htmlspecialchars($post->body, ENT_COMPAT)?></textarea></p>

<? if ($board->use_attachment) { ?>
<h3>Attachments <span class="info"><a href="#" onclick="addFileEntry()">+ Add File</a></span></h3>
<ol id="uploads">
<? if ($post->exists()) { ?>
<? foreach ($post->get_attachments() as $attachment) { ?>
<? if (!$attachment->exist()) $attachment->filename = "<del>$attachment->filename</del>"; ?>
	<li><?=$attachment->filename?> <label for="delete<?=$attachment->id?>"><input type="checkbox" name="delete[]" value="<?=$attachment->id?>" id="delete<?=$attachment->id?>" /> Delete</label></li>
<? } ?>
<? } ?>
	<li><input type="file" name="upload[]" size="50" class="ignore" /></li>
</ol>
<? } ?>
<p><?=submit_tag($action == 'post' ? "Post" : "Edit")?> <span id="sending"><?=image_tag("$skin_dir/spin.gif", 'Sending')?> Sending...</span></p>
</form>

<div id="meta-nav">
<p>
<?=link_to("Back to List", $board)?>
<? if ($action == 'edit') { ?>
 | <?=link_to("Back", $post)?>
<? } ?>
</p>
</div>
