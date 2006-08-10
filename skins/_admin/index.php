<h2><?=i('Boards')?></h2>
<table id="boards">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($boards as $board) { ?>
<tr>
	<td class="name"><?=$board->name?></td>
	<td class="actions"><?=link_to(i('Edit Settings'), $board, 'edit', array('tab' => 'general'))?> | <?=link_to(i('Preview'), $board)?> | <a href="<?=url_for($board, 'delete')?>" onclick="return window.confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a></td>
</tr>
<? } ?>
</table>
<form method="post" action="<?=url_for('admin', 'new')?>">
<h3>게시판 생성</h3>
<p><input type="text" name="name" /> <span class="description">(<?=i('영문, 숫자만 가능')?>)</span> <?=submit_tag(i('New Board'))?></p>
