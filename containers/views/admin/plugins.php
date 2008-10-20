<h2><?=i('Plugin')?></h2>
<h3>사용 중인 플러그인</h3>
<table class="plugins">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($plugins as $plugin) if ($plugin->enabled) { ?>
<tr>
	<td><?=$plugin->get_plugin_name()?><br /><small><?=$plugin->description?></small></td>
	<td class="actions">
	<? if ($plugin->enabled) { ?>
	<? if (method_exists($plugin, 'on_settings')) { ?>
	<?=link_to(i('Edit Settings'), $plugin, 'settings')?> |
	<? } ?>
	<?=link_to(i('Disable'), $plugin, 'disable')?>
	<? } else { ?>
	<?=link_to(i('Enable'), $plugin, 'enable')?>
	<? } ?>
	<? if ($plugin->exists()) { ?>
	| <a href="<?=url_for($plugin, 'uninstall')?>" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Uninstall')?></a>
	<? } ?>
	</td>
</tr>
<? } ?>
</table>

<h3>사용 가능한 플러그인</h3>
<table class="plugins">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($plugins as $plugin) if (!$plugin->enabled) { ?>
<tr>
	<td><?=$plugin->get_plugin_name()?><br /><small><?=$plugin->description?></small></td>
	<td class="actions">
	<? if ($plugin->enabled) { ?>
	<? if (method_exists($plugin, 'on_settings')) { ?>
	<?=link_to(i('Edit Settings'), $plugin, 'settings')?> |
	<? } ?>
	<?=link_to(i('Disable'), $plugin, 'disable')?>
	<? } else { ?>
	<?=link_to(i('Enable'), $plugin, 'enable')?>
	<? } ?>
	<? if ($plugin->exists()) { ?>
	| <a href="<?=url_for($plugin, 'uninstall')?>" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Uninstall')?></a>
	<? } ?>
	</td>
</tr>
<? } ?>
</table>
