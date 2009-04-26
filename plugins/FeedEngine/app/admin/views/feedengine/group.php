<? include '_menu.php' ?>

<table id="boards">
<tr>
	<th><?=i('Board')?></th>
	<th><?=i('Name')?></th>
	<th><?=i('Post count')?></th>
	<th><?=i('Tags')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? foreach ($groups as $group) { 
	$board = $group->get_board(); ?>
<tr>
	<td class="board"><?=$board->name?> </td>
	<td class="name"><?=$group->name?> <span id="group-<?=$group->id?>"></span></td>
	<td class="post_count"><?=$group->get_post_count()?></td>
	<td class="tags"><?=$group->tags?></td>
	<td><a href="<?=url_admin_for('feedengine','group', array('rename'=>$group->id))?>" onclick="edit('group-<?=$group->id?>', this.href); return false"><?=i('Rename')?></a>
	| <?= $group->is_first() ? i('Move up') : link_admin_to(i('Move up'), 'feedengine','group', array('up'=>$group->id)) ?>
	| <?= $group->is_last() ? i('Move down') : link_admin_to(i('Move down'), 'feedengine','group', array('down'=>$group->id)) ?>
	| <?=link_admin_delete_to(i('Delete'), 'feedengine', 'group', array('delete' => $group->id))?>
	</td>
</tr>
<? } ?>
</table>
<form method="post" action="?tab=group">
<p><select name="group[board_id]" >
<? foreach($boards as $board): ?>
	<? if($board->get_attribute('feed-at-board')): ?>
	<option value="<?=$board->id?>"><?=$board->name?></option>
	<? endif; ?>
<? endforeach; ?>
</select> 이름 <input type="text" name="group[name]" /> </p>
<p>태그 <input type="text" name="group[tags]" size="50"/> <input type="submit" value="<?=i('Add group')?>" /></p>
</form>