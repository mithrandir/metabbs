<h2>Delete Comment</h2>
<form method="post" action="<?=url_for($comment, 'delete')?>">
<p>Password: <input type="password" name="password" /><input type="submit" value="Delete" /></p>
</form>

<div id="nav">
<p><a href="<?=url_for($post)?>">Cancle</a></p>
</div>