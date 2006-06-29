<form method="post" action="?action=settings">
<p><?=label_tag(i('Admin password'), 'settings', 'admin_password')?> <?=password_field('settings', 'admin_password')?></p>
<p><?=label_tag(i('Global header'), 'settings', 'global_header')?> <?=text_field('settings', 'global_header', $config->get('global_header'), 30)?></p>
<p><?=label_tag(i('Global footer'), 'settings', 'global_footer')?> <?=text_field('settings', 'global_footer', $config->get('global_footer'), 30)?></p>
<p><input type="submit" value="OK" /></p>
</form>
