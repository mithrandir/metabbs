<h2>Delete Post</h2>
<form method="post" action="<?=url_for($post, 'delete')?>">
<p>Password: <input type="password" name="password" /> <input type="submit" value="Delete" /></p>
</form>

<div id="nav">
<p><a href="<?=url_for($post)?>">Cancel</a></p>
</div>