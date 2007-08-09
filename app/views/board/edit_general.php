<form method="post" action="?tab=general">
<div id="general">
<h2><?=i('General')?></h2>
<dl>
	<dt><?=label_tag("Name", "board", "name")?></dt>
	<dd><?=text_field('board', 'name', $board->name)?> <span class="description">(<?=i('게시판을 구분하는 고유 이름')?>)</span></dd>

	<dt><?=label_tag("Title", "board", "title")?></dt>
	<dd><?=text_field('board', 'title', $board->title)?> <span class="description">(<?=i('게시판 상단에 표시되는 제목')?>)</span></dd>

	<dt><?=label_tag("Posts per page", "board", "posts_per_page")?></dt>
	<dd><?=text_field('board', 'posts_per_page', $board->posts_per_page)?></dd>
	
	<dt><?=label_tag("Use attachment", "board", "use_attachment")?></dt>
	<dd><?=check_box('board', 'use_attachment', $board->use_attachment)?></dd>

	<dt><?=label_tag("Use category", "board", "use_category")?></dt>
	<dd><?=check_box('board', 'use_category', $board->use_category)?></dd>
	<dt><?=label_tag("Use trackback", "board", "use_trackback")?></dt>
	<dd><?=check_box('board', 'use_trackback', $board->use_trackback)?></dd>

	<dt><?=label_tag("Sorting", "board", "order_by")?></dt>
	<dd>
		<select name="board[order_by]">
		<?=option_tag('', '최근 글부터 보여줍니다.', !$board->order_by)?>
		<?=option_tag('last_update_at DESC', '최근에 댓글이 달린 글부터 보여줍니다.', $board->order_by == 'last_update_at DESC')?>
		</select>
	</dd>
</dl>
</div>
<p><input type="submit" value="OK" /></p>
</form>
