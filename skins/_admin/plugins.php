<h2><?=i('Plugin')?></h2>
<table id="plugins">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="status"><?=i('Status')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($plugins as $plugin) { ?>
<tr>
	<td><?=$plugin->name?></td>
	<td class="status <?=$plugin->enabled ? 'enabled' : 'disabled'?>"><?=i($plugin->enabled ? 'Enabled' : 'Disabled')?></td>
	<td class="actions"><?=$plugin->enabled ? link_to(i('Disable'), $plugin, 'disable') : link_to(i('Enable'), $plugin, 'enable')?></td>
</tr>
<? } ?>
</table>
