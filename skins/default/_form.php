<p><label>Name:</label> <input type="text" name="post[name]" value="<?=$name?>" /></p>
<p><label>Password:</label> <input type="password" name="post[password]" /></p>
<p><label>Title:</label> <input type="text" name="post[title]" size="50" value="<?=$post->title?>" /></p>
<p><textarea name="post[body]" cols="60" rows="12"><?=$post->body?></textarea></p>

<? if ($board->use_attachment) { ?>
<h3>Attachments <span class="info"><a href="#" onclick="addFileEntry()">+ Add File</a></span></h3>
<ol id="uploads">
<? if ($post->exists()) { ?>
<? foreach ($post->get_attachments() as $attachment) { ?>
    <li><?=$attachment->filename?> <label for="delete<?=$attachment->id?>"><input type="checkbox" name="delete[]" value="<?=$attachment->id?>" id="delete<?=$attachment->id?>" /> Delete</label></li>
<? } ?>
<? } ?>
    <li><input type="file" name="upload[]" size="50" class="ignore" /></li>
</ol>
<? } ?>
