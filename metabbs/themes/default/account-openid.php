<? include "_account_menu.php" ?>

<h1><?=i('OpenID')?></h1>
<?=flash_message_box()?>
<?=error_message_box($error_messages)?>

<h2>OpenID 리스트</h2>
<table id="openids">
<tr>
	<th>OpenID</th>
	<th>등록일</th>	
	<th />
</tr>
<? foreach ($openids as $openid): ?>
<tr>
	<td><?=$openid->openid?></td>
	<td><?=$openid->created_at?></td>
	<td><a href="<?=url_for('openid','unregister',array('id'=>$openid->id));?>" onclick="if (confirm('삭제하시겠습니까?')) { var f = document.createElement('form');f.style.display = 'none';this.parentNode.appendChild(f);f.method = 'POST';f.action = this.href;f.submit();}return false;">삭제</a></td>
</tr>
<? endforeach; ?>
</table>
<form method="post" action="<?=url_with_referer_for('openid', 'register')?>" id="openid-form">
<fieldset>
<h2>OpenID 등록</h2>
<p><input type="text" name="openid_identifier" style="background: #fff url(<?=METABBS_BASE_PATH?>media/login-openid.gif) no-repeat 0 50%; padding-left: 18px;" /> <input type="submit" value="<?=i('Register')?>" /></p>
</fieldset>
</form>
