<h2><?=i('Plugin')?></h2>
<table id="plugins">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="status"><?=i('Status')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($plugins as $plugin) { ?>
<tr>
	<td><?=$plugin->name?><br /><small><?=$plugin->description?></small></td>
	<td class="status <?=$plugin->enabled ? 'enabled' : 'disabled'?>"><?=i($plugin->enabled ? 'Enabled' : 'Disabled')?></td>
	<td class="actions">
	<? if ($plugin->enabled) { ?>
	<? if ($plugin->settings_function) { ?>
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
