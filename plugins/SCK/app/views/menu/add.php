<?php $GLOBALS['sck_context'] = new SCKManagerMenu; ?>
<h2><?=i('Add Menu')?></h2>

<form method="post" action="">
<p><input type="radio" name="type" value="board" id="board_type" checked="checked" /> <label for="board_type"><?=i('From an existing board')?>:</label> 
<select name="board_name">
<?php foreach (Board::find_all() as $board): ?>
	<option value="<?=$board->name?>"><?=$board->get_title()?></option>
<?php endforeach; ?>
</select>
</p>

<p><input type="radio" name="type" value="dashboard" id="dashboard_type" /> <label for="dashboard_type"><?=i('Create new dashboard')?></label><br />
<small><?=i('Dashboard displays recent posts of each registered boards')?></small><br />
<?=i('Name')?>: <input type="text" name="dashboard_name" size="30" /></p>

<p><input type="radio" name="type" value="page" id="page_type" /> <label for="page_type"><?=i('Create new page')?></label><br />
<?=i('Title')?>: <input type="text" name="page_title" size="30" /><br />
<textarea name="page_body" rows="10" cols="50"></textarea></p>

<p><input type="submit" value="<?=i('OK')?>" /></p>
</form>
