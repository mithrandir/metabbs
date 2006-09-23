<form method="post" action="?">
<p><?=label_tag(i('Admin password'), 'settings', 'admin_password')?> <?=password_field('settings', 'admin_password')?></p>
<p><?=label_tag(i('Global header'), 'settings', 'global_header')?> <?=text_field('settings', 'global_header', $config->get('global_header'), 30)?></p>
<p><?=label_tag(i('Global footer'), 'settings', 'global_footer')?> <?=text_field('settings', 'global_footer', $config->get('global_footer'), 30)?></p>
<p><?=label_tag(i('Default language'), 'settings', 'default_language')?>
<select name="settings[default_language]" id="settings_default_language">
<?=option_tag('en', 'English', $default_language == 'en')?>
<?=option_tag('ko', '한국어', $default_language == 'ko')?>
</select>
</p>
<p><?=label_tag(i('Always use default language'), 'settings', 'always_use_default_language')?> <?=check_box('settings', 'always_use_default_language', $config->get('always_use_default_language', false))?></p>
<p><input type="submit" value="OK" /></p>
</form>
