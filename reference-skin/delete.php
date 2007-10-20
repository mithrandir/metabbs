<form method="post" action="">
<h2>글 삭제</h2>

<? if ($ask_password): ?>
<p>암호: <input type="password" name="password" /></p>
<? endif; ?>
<p><input type="submit" value="지우기" /></p>
</form>
