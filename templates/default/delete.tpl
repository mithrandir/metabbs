{include file="header.tpl"}

<div id="rubybbs">

<form method="post" action="delete.php?bid={$bid}&amp;id={$id}">
Password: <input type="password" name="passwd" class="text" /> <input type="submit" value="Delete" class="submit" />
</form>

<ul id="nav">
	<li><a href="index.php?bid={$bid}&amp;page={$page}">list</a></li>
	<li><a href="post.php?bid={$bid}&amp;page={$page}">post</a></li>
	<li><a href="index.php?bid={$bid}&amp;page={$page}&amp;id={$id}">return</a></li>
	<li><a href="admin.php">admin</a></li>
</ul>
</div>

{include file="footer.tpl"}
