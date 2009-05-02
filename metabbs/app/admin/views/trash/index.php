<h2><?=i('Trash Can')?></h2>
<table id="trash">
<tr>
	<th class="type"><?=i('Type')?></th>
	<th><?=i('Summary')?></th>
	<th class="reason"><?=i('Reason')?></th>
	<th class="date"><?=i('Date')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($trashes as $trash) { ?>
<tr>
	<td><?=$trash->model?></td>
	<td><?=htmlspecialchars($trash->get_summary())?></td>
	<td><?=htmlspecialchars($trash->reason)?></td>
	<td><?=date('Y-m-d H:i:s', $trash->created_at)?></td>
	<td>
		<a href="trash/<?=$trash->id?>/revert"><?=i('Revert')?></a>
		| <a href="trash/<?=$trash->id?>/purge" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Purge')?></a>
	</td>
</tr>
<? } ?>
</table>

<!--<p><a href="<?=url_admin_for('trash', 'clear')?>" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Clear all')?></a></p>-->
