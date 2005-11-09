<div id="post">
    <h2><?=$this->post->subject?></h2>
    <p><?=nl2br($this->post->body)?></p>
    <p id="info">Posted at <?=date("Y-m-d H:i:s", $this->post->created_at)?> by <?=$this->post->name?></div>
</div>

<div id="comments">
    <h3>Comments</h3>
    <ul>
<?php foreach ($this->post->get_comments() as $_ => $comment) { ?>
        <li><p class="body"><?=$comment->body?></p><p class="info"><?=$comment->name?>, <?=date("Y-m-d H:i:s", $comment->created_at)?></p></li>
<?php } ?>
    </ul>
    <form method="post" action="<?=url_for_post($this->post, "comment")?>">
        <p><label for="comment_name">Name:</label> <input type="text" name="comment[name]" id="comment_name" /> <label for="comment_password">Password:</label> <input type="password" name="comment[password]" id="comment_password" /></p>
        <p><textarea name="comment[body]" cols="30" rows="5"></textarea></p>
        <p><input type="submit" value="Comment" /></p>
    </form>
</div>

<p><?=link_to_board($this->board, "List")?> | <?=link_to_board($this->board, "New post", "new")?> | <?=link_to_post($this->post, "Edit", "edit")?> or <?=link_to_post($this->post, "Delete", "delete")?>
