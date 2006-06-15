<form method="post" action="?action=settings">
<p><?=label_tag(i('Admin password'), 'settings', 'admin_password')?> <?=password_field('settings', 'admin_password')?></p>
<p><?=label_tag(i('Global layout'), 'settings', 'global_layout')?> <?=text_field('settings', 'global_layout', $config->get('global_layout'), 30)?></p>
<p><input type="submit" value="OK" /></p>
</form>
