<h2>New post</h2>
<?php print_flash() ?>
<form method="post" id="post" action="<?=url_for_board($this->board, "save")?>">
<p><label for="post_name">Name:</label> <input type="text" name="post[name]" id="post_name" /> <label for="post_password">Password:</label> <input type="password" name="post[password]" id="post_password" /></p>
<p><label for="post_subject">Subject:</label> <input type="text" name="post[subject]" id="post_subject" size="50" /></p>
<p><textarea name="post[body]" id="post_body" cols="50" rows="15"></textarea></p>
<p><input type="submit" value="Post" /> <?=link_to_board($this->board, "Back to list")?></p>
</form>
