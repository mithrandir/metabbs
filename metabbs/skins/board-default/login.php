<h1>로그인</h1>

<form method="post" action="">
<dl>
	<dt>아이디</dt>
	<dd><input type="text" name="user" /></dd>

	<dt>암호</dt>
	<dd><input type="password" name="password" /></dd>
</dl>
<p><input type="checkbox" name="autologin" id="autologin" value="1" /> <label for="autologin">자동 로그인</label></p>
<p><input type="submit" value="로그인" class="button" /> <a href="<?=$link_signup?>" class="button">회원가입</a></p>
</form>
