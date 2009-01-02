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

<h2><?=i('CAPTCHA Setting')?></h2>
<dl>
	<dt><?=label_tag("Name", "settings", "captcha_name")?></dt>
	<dd>
		<select name="settings[captcha_name]">
		<?=option_tag('none', '사용안합니다.', false)?>
		<? foreach($external_libs['captcha'] as $name => $lib) { ?>
		<?=option_tag($name, $lib["title"], $config->get('captcha_name', false) == $name)?>
		<? } ?>
		</select>
	</dd>
</dl>
<? switch ($config->get('captcha_name', false)) { ?>
<?		case "phpcaptcha": ?>
<dl>
	<dt><?=label_tag('Flite Path', 'settings', 'flite_path')?></dt>
	<dd><?=text_field('settings', 'flite_path', $config->get('flite_path', false), 50)?></dd>
</dl>
<h3>Notice</h3>
<ol>
	<li>Download 'php-captcha.inc.php' and TrueType fonts(english) on <a href="http://www.ejeliot.com/pages/2" onclick="window.open(this.href);return false;">http://www.ejeliot.com/pages/2</a></li>
	<li>Comment out 'session_start()'(ex: // session_start()) on 'php-captcha.inc.php' line 46</li>
	<li>Copy 'php-captcha.inc.php' to '/core/external/phpcaptcha' </li>
	<li>Copy TrueType fonts to '/core/external/phpcaptcha/fonts' </li>
	<li>Insert this line 'RewriteRule captcha/(visual|audio) core/external/phpcaptcha/$1-captcha.php' to file '.htaccess'</li>
</ol>
<?		break; ?>
<?		case "recaptcha": ?>
<dl>
	<dt><?=label_tag('Public Key', 'settings', 'captcha_publickey')?></dt>
	<dd><?=text_field('settings', 'captcha_publickey', $config->get('captcha_publickey', false), 50)?></dd>
	<dt><?=label_tag('Private Key', 'settings', 'captcha_privatekey')?></dt>
	<dd><?=text_field('settings', 'captcha_privatekey', $config->get('captcha_privatekey', false), 50)?></dd>
</dl>
<h3>Notice</h3>
<ol>
	<li>Download 'recaptchalib.php' on <a href="http://recaptcha.net/plugins/php/" onclick="window.open(this.href);return false;">http://recaptcha.net/plugins/php/</a></li>
	<li>Copy 'recaptchalib.php' to '/core/external/recaptcha' </li>
	<li>Get Public Key and Private Key on <a href="http://recaptcha.net/whyrecaptcha.html" onclick="window.open(this.href);return false;">http://recaptcha.net/whyrecaptcha.html</a> </li>
<?		break; ?>
<? } ?>
</dl>
<p><input type="submit" value="OK" /></p>
</form>
