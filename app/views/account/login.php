<h2>로그인</h2>
<form method="post" action="">
<dl>
	<dt>아이디</dt>
	<dd><input type="text" name="user" /></dd>

	<dt>암호</dt>
	<dd><input type="password" name="password" /></dd>
</dl>
<p><input type="checkbox" name="autologin" id="autologin" value="1" /> <label for="autologin">자동 로그인</label></p>
<p><input type="submit" value="로그인" /> <a href="<?=$link_signup?>">회원가입</a></p>
</form>
