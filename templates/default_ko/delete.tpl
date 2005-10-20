{include file="header.tpl"}

<div id="rubybbs">

<form method="post" action="delete.php?bid={$bid}&amp;id={$id}">
암호: <input type="password" name="passwd" class="text" /> <input type="submit" value="지우기" class="submit" />
</form>

<ul id="nav">
	<li><a href="index.php?bid={$bid}&amp;page={$page}">목록보기</a></li>
	<li><a href="post.php?bid={$bid}&amp;page={$page}">글쓰기</a></li>
	<li><a href="index.php?bid={$bid}&amp;page={$page}&amp;id={$id}">돌아가기</a></li>
	<li><a href="admin.php">관리</a></li>
</ul>
</div>

{include file="footer.tpl"}
