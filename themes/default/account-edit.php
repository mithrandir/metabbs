<h1><?=i('Account Edit')?></h1>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<form method="post" action="<?=url_with_referer_for('account', 'edit', $params)?>" id="account-edit-form">
<fieldset>
<h2>기본 정보</h2>
<p>
	<label><?=i('User ID')?></label>
	<?=$account->user?>
</p>
<? if (!$account->is_openid_account()): ?>
<p>
	<label><?=i('Password')?></label>
	<input type="password" name="user[password]" class="ignore <?=marked_by_error_message('password', $error_messages)?>"/>
</p>
<? endif; ?>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
<p>
	<label><?=i('E-Mail Address')?><span class="star">*</span></label>
	<input type="text" name="user[email]" size="50" class="ignore <?=marked_by_error_message('email', $error_messages)?>" value="<?=$account->email?>" />
</p>
</fieldset>
<fieldset>
<h2>추가 정보</h2>
<p>
	<label><?=i('Homepage')?></label>
	<input type="text" name="user[url]" size="50" class="ignore <?=marked_by_error_message('url', $error_messages)?>" value="<?=$account->url?>" />
</p>
<p>
	<label><?=i('Signature')?></label>
	<textarea name="user[signature]" cols="50" rows="5" class="ignore"><?=$account->signature?></textarea>
</p>
<p><input type="submit" value="<?=i('Edit Info')?>" class="button"/>
<? if (isset($params['url']) && !empty($params['url'])): ?> <a href="<?=$params['url']?>" class="button dialog-close"><?=i('Cancel')?></a><? endif; ?>
<? if (using_openid() && $account->is_openid_account()): ?> <a href="<?=url_for('account', 'transfer', array('url'=>urlencode(url_with_referer_for('account', 'edit'))))?>"><?=i('Transfer to Default Account')?></a><? endif; ?>
</p>
</fieldset>
</form>

<? if (using_openid() && !$account->is_openid_account()): ?>
<h2><?=i('OpenID')?></h2>
<br />
<table id="openids">
<tr>
	<th>OpenID</th>
	<th>등록일</th>	
	<th />
</tr>
<? foreach (Openid::find_all_by_user($account) as $openid): ?>
<tr>
	<td><?=$openid->openid?></td>
	<td><?=date('Y-m-d H:i:s', $openid->created_at)?></td>
	<td><a href="<?=url_for('openid','unregister',array('id'=>$openid->id));?>" onclick="if (confirm('삭제하시겠습니까?')) { var f = document.createElement('form');f.style.display = 'none';this.parentNode.appendChild(f);f.method = 'POST';f.action = this.href;f.submit();}return false;">삭제</a></td>
</tr>
<? endforeach; ?>
</table>
<form method="post" action="<?=url_with_referer_for('openid', 'register')?>" id="openid-form">
<fieldset>
<p><input type="text" name="openid_identifier" style="background: #fff url(<?=METABBS_BASE_PATH?>media/login-openid.gif) no-repeat 0 50%; padding-left: 18px;" /> <input type="submit" value="<?=i('Register')?>" /></p>
</fieldset>
</form>
<? endif; ?>
