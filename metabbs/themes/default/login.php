<h1>로그인</h1>
<form method="post" action="" id="login-form">
<p><label for="user" class="field">아이디</label> <input type="text" name="user" id="user" /></p>
<p><label for="password" class="field">암호</label> <input type="password" name="password" id="password" /></p>
<p><input type="checkbox" name="autologin" id="autologin" value="1" /> <label for="autologin">자동 로그인</label></p>
<p><input type="submit" value="로그인" /> <a href="<?=url_with_referer_for('account', 'signup')?>">회원가입</a></p>
</form>
