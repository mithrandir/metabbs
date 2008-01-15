<? if ($comment_url): ?>
	<form method="post" action="<?=$comment_url?>" id="comment-form">
	<? if ($guest): ?>
	<p>
		<label for="comment_author">이름</label>
		<input type="text" name="author" value="<?=$comment_author?>" id="comment_author" />

		<label for="comment_password">암호</label>
		<input type="password" name="password" id="comment_password" />
	</p>
	<? endif; ?>
	<p><textarea name="body" cols="40" rows="5"><?=$comment_body?></textarea></p>

	<input type="submit" value="댓글 달기" class="button" />
	<? if ($link_cancel): ?><a href="<?=$link_cancel?>" class="button dialog-close">취소</a><? endif; ?>
	</form>

	<script type="text/javascript">
	Event.observe('comment-form', 'submit', function (event) {
		addComment('comment-form', $$('#comments ol')[0])
		Event.stop(event);
	});
	</script>
<? endif; ?>
