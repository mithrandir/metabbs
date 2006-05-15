<div class="title">
<h2><?=$post->title?></h2>
<div class="info">
<p>Posted by <?=$post->name?> at <?=date_format("%Y-%m-%d %H:%M:%S", $post->created_at)?></p>
</div>
</div>
<div id="attachments" style="clear: both">
<ul>
<? foreach ($attachments as $attachment) { ?>
<? if ($attachment->is_image()) { ?>
    <li><img src="<?=url_for($attachment)?>" alt="<?=$attachment->filename?>" /></li>
<? } else { ?>
    <li>Attachment: <a href="<?=url_for($attachment)?>"><?=$attachment->filename?></a> (<?=$attachment->get_size()/1024?>kb)</li>
<? } ?>
<? } ?>
</ul>
</div>
<p class="body"><?=$post->get_body()?></p>

<div id="trackbacks">
<h3>Trackbacks</h3>
<p>Trackback URL: <a href="<?=$trackback_url='http://'.$_SERVER['HTTP_HOST'].url_for($post, 'trackback')?>"><?=$trackback_url?></a></p>
<ul>
<? foreach ($trackbacks as $trackback) { ?>
    <li><a href="<?=$trackback->url?>"><?=$trackback->title?></a> from <?=$trackback->blog_name?></li>
<? } ?>
</ul>
</div>

<div id="comments">
<h3>Comments</h3>
<ul>
<? foreach ($comments as $comment) { ?>
    <li class="comment">
        <div class="info"><?=$comment->name?> <small><?=date_format("%Y-%m-%d %H:%m", $comment->created_at)?></small> <a href="<?=url_for($comment, 'delete')?>">x</a></div>
        <div class="body"><?=$comment->get_body()?></div>
    </li>
<? } ?>
</ul>
</div>

<form method="post" action="<?=url_for($post, 'comment')?>" onsubmit="return sendForm(this)">
<p><label>Name:</label> <input type="text" name="comment[name]" value="<?=$name?>" /></p>
<p><label>Password:</label> <input type="password" name="comment[password]" /></p>
<p><textarea name="comment[body]" cols="50" rows="5"></textarea></p>
<p><input type="submit" value="Save" /> <span id="sending"><img src="<?=$skin_dir?>/spin.gif" alt="Sending" /> Sending...</span></p></p>
</form>

<div id="nav">
<p><a href="<?=url_for($board)?>?page=<?=Page::get_requested_page()?>">List</a> | <a href="<?=url_for($board, 'post')?>">New Post</a> | <a href="<?=url_for($post, 'edit')?>">Edit</a> or <a href="<?=url_for($post, 'delete')?>">Delete</a></p>
</div>
