<? if ($user->is_guest() || $post->exists() && $post->user_id == 0 && $user->level < $board->perm_delete) { ?>
<p><?=label_tag("Name:", "post", "name")?> <?=text_field("post", "name", $name)?></p>
<p><?=label_tag("Password:", "post", "password")?> <?=password_field("post", "password")?></p>
<? } ?>
<p><?=label_tag("Title:", "post", "title")?> <?=text_field("post", "title", $post->title, 50)?></p>
<p><?=text_area("post", "body", 12, 60, $post->body)?></p>

<? if ($board->use_attachment) { ?>
<h3>Attachments <span class="info"><a href="#" onclick="addFileEntry()">+ Add File</a></span></h3>
<ol id="uploads">
<? if ($post->exists()) { ?>
<? foreach ($post->get_attachments() as $attachment) { ?>
<? if (!$attachment->exist()) $attachment->filename = "<del>$attachment->filename</del>"; ?>
	<li><?=$attachment->filename?> <label><input type="checkbox" name="delete[]" value="<?=$attachment->id?>" /> Delete</li>
<? } ?>
<? } ?>
	<li><input type="file" name="upload[]" size="50" class="ignore" /></li>
</ol>
<? } ?>
