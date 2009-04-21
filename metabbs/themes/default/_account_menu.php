<ul>
	<li<?= $routes['action'] == 'edit' ? ' class="selected"':''?>><a href="<?=url_for('account', 'edit', isset($params['url']) ? array('url'=>urlencode($params['url'])): null);?>"><?=i('Account Edit')?></a></li>
<? if (!$account->is_openid_account()): ?>	
	<li<?= $routes['action'] == 'openid' ? ' class="selected"':''?>><a href="<?=url_for('account', 'openid', isset($params['url']) ? array('url'=>urlencode($params['url'])): null)?>"><?=i('OpenID')?></a></li>
<? else: ?>
	<li<?= $routes['action'] == 'transfer' ? ' class="selected"':''?>><a href="<?=url_for('account', 'transfer', isset($params['url']) ? array('url'=>urlencode($params['url'])): null)?>"><?=i('Transfer to Default Account')?></a></li>
<? endif; ?>
</ul>
