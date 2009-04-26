<? include '_menu.php' ?>

<table>
<thead>
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="name"><?=i('Post Count')?></th>
	<th class="range"><?=i('Range')?></th>
	<th class="range"><?=i('Kind')?></th>
	<th class="feed-tags"><?=i('Feed Tags')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
</thead>
<tbody id="boards-body">
<?php
foreach ($boards as $board) {
	switch($board->get_attribute('feed-range')) {
	case 0 :
		$feed_range_msg = 'All Feed';
		break;
	case 1 :
		$feed_range_msg = 'All Feed having Owner';
		break;
	case 2 :
		$feed_range_msg = 'Some Feed';
		break;
	case 3 :
		$feed_range_msg = 'Some Feed having Owner';
		break;
	}	
	switch($board->get_attribute('feed-kind')) {
	case 0 :
		$feed_kind_msg = 'Default';
		break;
	case 1 :
		$feed_kind_msg = 'By Some Tags';
		break;
	case 2 :
		$feed_kind_msg = 'Auto Grouping';
		break;
	}
	$feed_at_board_msg = $board->get_attribute('feed-at-board') ? i('Don\'t Feed at Board') : i('Feed at Board');
?>
<tr>
	<td class="name"><?=$board->get_title()?> <span class="url"><?=url_for($board)?></span></td>
	<td class="post_count"><?=Feed::get_all_post_count($board)?></td>
	<td class="range"><? if($board->get_attribute('feed-at-board')) : ?><?=link_admin_to(i($feed_range_msg), 'feedengine', null, array('feed-range' => $board->name)) ?><? endif; ?></td>
	<td class="kind"><? if($board->get_attribute('feed-at-board')) : ?><?=link_admin_to(i($feed_kind_msg), 'feedengine', null, array('feed-kind' => $board->name)) ?><? endif; ?></td>
	<td class="feed-tags"><? if($board->get_attribute('feed-at-board')) : ?><?= $board->get_attribute('tags')?> <span id="feed-tags-<?=$board->id?>"></span><? endif; ?></td>
	<td class="actions">
	<?=link_to(i('Preview'), $board)?>
	| <?= link_admin_with_dialog_to($feed_at_board_msg, 'feedengine', null, array('feed-at-board' => $board->name)) ?>
	<? if($board->get_attribute('feed-at-board')) : ?>
	| <?= link_admin_with_dialog_to(i('Collect Feeds'), 'feedengine', null, array('collect-feed' => $board->name)) ?>
	| <a href="<?=url_admin_for('feedengine', null, array('feed-tags'=>$board->name))?>" onclick="edit('feed-tags-<?=$board->id?>', this.href); return false"><?=i('Change Feed Tags')?></a>
	<? endif; ?>
	</td>  
</tr>
<?php
} 
?>
</tbody>
</table>
<h3>Range</h3>
<ul>
	<li>All Feed : 전체</li>
	<li>All Feed having Owner: 소유자를 가지고 있는 전체</li>
	<li>Some Feed : 특정 피드(Board 메뉴)</li>
	<li>Some Feed having Owner : 소유자를 가지고 특정 피드(Board 메뉴)</li>
</ul>
<h3>Kind</h3>
<ul>
	<li>Default : 보통</li>
	<li>By Some Tags : 특정 태그만 받음(Feed Tags 설정)</li>
	<li>Auto Grouping : 다채널 자동 그룹핑(Group 메뉴)</li>
</ul>