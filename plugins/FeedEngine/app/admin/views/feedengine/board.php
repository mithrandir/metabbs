<? include '_menu.php' ?>

<table id="boards">
<tr>
	<th><?=i('Board')?></th>
	<th><?=i('URL')?></th>
	<th><?=i('Feed URL')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? foreach($feed_boards as $feed_board): 
	$board = $feed_board->get_board(); 
	$feed = $feed_board->get_feed(); ?>
<tr>
	<td><?=$board->name ?></td>
	<td><?=$feed->link ?></td>
	<td><?=$feed->url ?></td>
	<td><?=link_admin_with_dialog_by_post_to(i('Delete'), 'feedengine', 'board', array('delete' => $feed_board->id))?></td>
</tr>
<? endforeach; ?>
</table>
<form method="post" action="<?=url_admin_for('feedengine','board')?>">
<p><select name="feed_board[board_id]" >
<? foreach($boards as $board): ?>
	<? if($board->get_attribute('feed-at-board')): ?>
	<option value="<?=$board->id?>"><?=$board->name?></option>
	<? endif; ?>
<? endforeach; ?>
</select> 
<select name="feed_board[feed_id]" >
<? foreach($feeds as $feed): ?>
	<option value="<?=$feed->id?>"><?=$feed->title.'('.$feed->link.')'?></option>
<? endforeach; ?>
</select> <input type="submit" value="<?=i('Add Feed Board')?>" /></p>
</form>