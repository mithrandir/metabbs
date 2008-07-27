<? if ($error) { ?>
<h1>잘못된 초기화 코드</h1>
<p>초기화 주소가 잘못되었거나 이미 초기화를 했습니다.</p>
<? } else { ?>
<h1>암호를 초기화합니다.</h1>
<form method="post" action="" id="login-form" onsubmit="if ($('password').value != $('password-verify').value) { alert('두번째 입력한 암호가 다르네요.'); return false }">
<p><label for="password" class="field">새 암호</label> <input type="password" name="password" id="password" /></p>
<p><label for="password-verify" class="field">새 암호, 한번 더</label> <input type="password" name="password_verify" id="password-verify" /></p>
<p><input type="submit" value="초기화" /></p>
</form>
<? } ?>
