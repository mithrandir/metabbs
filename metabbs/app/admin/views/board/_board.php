<tr>
	<td class="name"><?=$board->get_title()?> <span class="url">/<?=$board->name?></span></td>
	<td class="actions"><?=link_admin_to(i('Edit Settings'), $board, 'edit', array('tab' => 'general'))?> | <?=link_to(i('Preview'), $board)?> | <a href="<?=url_admin_for($board, 'delete')?>" onclick="return window.confirm('<?=i('Are you sure?')?>')" id="delete_<?=$board->name?>"><?=i('Delete')?></a></td>
</tr>
