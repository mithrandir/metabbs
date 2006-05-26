<h2><?=i('Boards')?></h2>
<table id="boards">
<tr>
	<th class="name">Name</th>
	<th class="actions">Actions</th>
</tr>
<? foreach ($boards as $board) { ?>
<tr>
	<td class="name"><?=$board->name?></td>
	<td class="actions"><a href="?action=edit&amp;board_id=<?=$board->id?>">Edit Settings</a> | <a href="metabbs.php/board/<?=$board->name?>">Preview</a> | <a href="?action=delete&amp;board_id=<?=$board->id?>" onclick="return window.confirm('Really?')">Delete</a></td>
</tr>
<? } ?>
</table>
<p><a href="?action=new">New Board</a></p>
