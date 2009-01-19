<h2><?=i('Settings')?></h2>
<form method="post" action="?">
<dl>
	<dt><?=label_tag(i('Global header'), 'settings', 'global_header')?></dt>
	<dd><?=text_field('settings', 'global_header', $config->get('global_header'), 30)?></dd>

	<dt><?=label_tag(i('Global footer'), 'settings', 'global_footer')?></dt>
	<dd><?=text_field('settings', 'global_footer', $config->get('global_footer'), 30)?></dd>

	<dt><?=label_tag(i('Base Path'), 'settings', 'base_path')?></dt>
	<dd><?=text_field('settings', 'base_path', $config->get('base_path'), 30)?></dd>

	<dt><?=label_tag(i('Site theme'), 'settings', 'theme')?></dt>
	<dd>
		<select name="settings[theme]" id="settings_theme">
		<? foreach ($themes as $theme): ?>
		<?=option_tag($theme, $theme, $theme == $current_theme)?>
		<? endforeach; ?>
		</select>
		<?=check_box('settings', 'use_forget_password', $config->get('use_forget_password', false))?>
		<?=label_tag(i('Use \'Forget Password\' Page'), 'settings', 'use_forget_password')?>
	</dd>

	<dt><?=label_tag(i('Default language'), 'settings', 'default_language')?></dt>
	<dd>
		<select name="settings[default_language]" id="settings_default_language">
		<?=option_tag('en', 'English', $default_language == 'en')?>
		<?=option_tag('ko', '한국어', $default_language == 'ko')?>
		</select>
		<?=check_box('settings', 'always_use_default_language', $config->get('always_use_default_language', false))?>
		<?=label_tag(i('Always use default language'), 'settings', 'always_use_default_language')?>
	</dd>

	<dt><?=label_tag(i('Timezone'), 'settings', 'timezone')?></dt>
	<dd>
		<select name="settings[timezone]" id="settings_timezone">
		<? foreach (Timezone::getList() as $timezone) { ?>
		<?=option_tag($timezone, $timezone, $timezone == $current_tz)?>
		<? } ?>
		</select>
	</dd>
</dl>

<h2>고급 설정</h2>
<p><?=check_box('settings', 'force_fancy_url', $config->get('force_fancy_url', false))?> <?=label_tag('Fancy URL 강제 적용', 'settings', 'force_fancy_url')?></p>
<p><input type="submit" value="OK" /></p>
</form>
