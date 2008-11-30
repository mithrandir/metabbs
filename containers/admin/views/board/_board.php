<tr>
	<td class="name"><?=$board->get_title()?> <span class="url">/<?=$board->name?></span></td>
	<td class="actions"><?=link_to(i('Edit Settings'), 'admin', 'board', 'edit', array('id' => $board->id, 'tab' => 'general'))?> | <?=link_to(i('Preview'), 'metabbs', 'board', null, array('board-name'=>$board->name))?> | <a href="<?=url_for_admin('board', 'delete', array('id' => $board->id))?>" onclick="return window.confirm('<?=i('Are you sure?')?>')" id="delete_<?=$board->name?>"><?=i('Delete')?></a></td>
</tr>
