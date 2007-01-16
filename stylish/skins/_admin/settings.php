<h2><?=i('Settings')?></h2>
<form method="post" action="?">
<dl>
	<dt><?=label_tag(i('Admin password'), 'settings', 'admin_password')?></dt>
	<dd><?=password_field('settings', 'admin_password')?></dd>
	
	<dt><?=label_tag(i('Global header'), 'settings', 'global_header')?></dt>
	<dd><?=text_field('settings', 'global_header', $config->get('global_header'), 30)?></dd>

	<dt><?=label_tag(i('Global footer'), 'settings', 'global_footer')?></dt>
	<dd><?=text_field('settings', 'global_footer', $config->get('global_footer'), 30)?></dd>

	<dt><?=label_tag(i('Default language'), 'settings', 'default_language')?></dt>
	<dd>
		<select name="settings[default_language]" id="settings_default_language">
		<?=option_tag('en', 'English', $default_language == 'en')?>
		<?=option_tag('ko', '한국어', $default_language == 'ko')?>
		</select>
	</dd>

	<dt><?=label_tag(i('Always use default language'), 'settings', 'always_use_default_language')?></dt>
	<dd><?=check_box('settings', 'always_use_default_language', $config->get('always_use_default_language', false))?></dd>
</dl>

<p><input type="submit" value="OK" /></p>
</form>
