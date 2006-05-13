<form method="post" action="?action=settings">
<p><label for="settings_admin_password">Admin password</label> <?=password_field('settings', 'admin_password')?></p>
<p><label for="settings_global_layout">Use global layout</label> <?=text_field('settings', 'global_layout', '', 30)?></p>
<p><input type="submit" value="OK" /></p>
</form>
