<h2><?=i('Boards')?></h2>
<table id="boards">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<? foreach ($boards as $board) { ?>
<? include($_skin_dir . '/_board.php'); ?>
<? } ?>
</table>
<form method="post" action="<?=url_for('admin', 'new')?>" onsubmit="return addNewBoard(this)">
<h3><?=i('New Board')?></h3>
<p><input type="text" name="name" /> <?=submit_tag(i('Create'))?></p>
