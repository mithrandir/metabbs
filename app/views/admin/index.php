<h2><?=i('Boards')?></h2>
<table id="boards">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<tbody id="boards-body">
<? foreach ($boards as $board) { ?>
<? include('app/views/admin/_board.php'); ?>
<? } ?>
</tbody>
</table>
<form method="post" action="<?=url_for('admin', 'new')?>" onsubmit="return addNewBoard(this)" id="add-board-form">
<h3><?=i('New Board')?></h3>
<p><input type="text" name="name" /> <input type="submit" value="<?=i('Create')?>" id="create-board" /></p>
