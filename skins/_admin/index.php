<h2><?=i('Boards')?></h2>
<table id="boards">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($boards as $board) { ?>
<tr>
	<td class="name"><?=$board->name?></td>
	<td class="actions"><a href="?action=edit&amp;board_id=<?=$board->id?>"><?=i('Edit Settings')?></a> | <a href="metabbs.php/board/<?=$board->name?>"><?=i('Preview')?></a> | <a href="?action=delete&amp;board_id=<?=$board->id?>" onclick="return window.confirm('Really?')"><?=i('Delete')?></a></td>
</tr>
<? } ?>
</table>
<p><a href="?action=new"><?=i('New Board')?></a></p>
