<? if ($comment_writable): ?>
<?= error_message_box($error_messages); ?>
	<form method="post" action="<?=$comment_url?>" id="<?=$form_id?>" class="comment-form">
	<? if ($guest): ?>
	<p>
		<label for="comment_author">이름</label>
		<input type="text" name="comment[author]" value="<?=$comment_author?>" id="comment_author" class="check <?=marked_by_error_message('author', $error_messages)?>" />

		<label for="comment_password">암호</label>
		<input type="password" name="comment[password]" id="comment_password" class="check <?=marked_by_error_message('password', $error_messages)?>" />
	</p>
	<? endif; ?>
	<p><textarea name="comment[body]" cols="40" rows="5" id="comment_body" class="check <?=marked_by_error_message('body', $error_messages)?>"><?=$comment_body?></textarea></p>

	<div class="buttons"><input type="submit" value="댓글 달기" class="button" />
	<? if ($link_cancel): ?><a href="<?=$link_cancel?>" class="button dialog-close">취소</a><? endif; ?></div>
	</form>
<? endif; ?>
