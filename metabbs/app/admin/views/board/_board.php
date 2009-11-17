<tr>
	<td class="name"><?=$board->get_title()?> <span class="url">/<?=$board->name?></span></td>
	<td class="actions"><?=link_admin_to(i('Edit Settings'), $board, 'edit', array('tab' => 'general'))?> | <?=link_to(i('Preview'), $board)?> | <?=link_admin_with_dialog_by_post_to(i('Delete'), $board, 'delete') ?></td>
</tr>
