<? if ($comment_url): ?>
	<form method="post" action="<?=$comment_url?>">
	<dl>
	<? if ($guest): ?>
		<dt>이름</dt>
		<dd><input type="text" name="author" value="<?=$comment_author?>" /></dd>

		<dt>암호</dt>
		<dd><input type="password" name="password" /></dd>
	<? endif; ?>

		<dt>내용</dt>
		<dd><textarea name="body" cols="30" rows="5"><?=$comment_body?></textarea></dd>
	</dl>

	<p><input type="submit" value="댓글 달기" /></p>
	</form>
<? endif; ?>
