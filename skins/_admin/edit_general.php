<div id="general">
<h2><?=i('General')?></h2>
<p>
	<?=label_tag("Name", "board", "name")?>
	<?=text_field('board', 'name', $board->name)?> <span class="description">(<?=i('영문, 숫자만 가능')?>)</span>
</p>
<p>
	<?=label_tag("Title", "board", "title")?>
	<?=text_field('board', 'title', $board->title)?>
</p>
<p>
	<?=label_tag("Posts per page", "board", "posts_per_page")?>
	<?=text_field('board', 'posts_per_page', $board->posts_per_page)?>
</p>
<p>
	<?=label_tag("Use attachment", "board", "use_attachment")?>
	<?=check_box('board', 'use_attachment', $board->use_attachment)?>
</p>
<p>
	<?=label_tag("Use category", "board", "use_category")?>
	<?=check_box('board', 'use_category', $board->use_category)?>
</p>
</div>
