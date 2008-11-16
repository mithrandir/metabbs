<h1>글 삭제</h1>

<form method="post" action="">
<? if ($ask_password): ?>
<p><label for="password">암호:</label> <input type="password" name="password" id="password" /></p>
<? endif; ?>
<div id="meta-nav"><input type="submit" value="지우기" class="button" /> <a href="<?=$link_cancel?>" class="button dialog-close">취소</a></div>
</form>

<script type="text/javascript">
Event.observe('delete-form', 'submit', function (event) {
	deleteComment(this, <?=$comment->id?>, <?=$comment->has_child() ? 'true' : 'false'?>);
	Event.stop(event)
})
</script>
