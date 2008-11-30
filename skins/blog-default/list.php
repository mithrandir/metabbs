<? if ($keyword): ?>
<div id="filter-info">'<?=$keyword?>'(으)로 검색한 결과입니다. <a href="<?=blog_url($board)?>">글 전체 보기</a></div>
<? endif; ?>

<? if (isset($category)): ?>
<div id="filter-info">분류 '<?=$category->name?>'에 들어있는 글입니다. <a href="<?=blog_url($board)?>">글 전체 보기</a></div>
<? endif; ?>

<? foreach ($posts as $post): ?>
<div class="entry">
<h1><a href="<?=$post->url?>"><?=$post->title?></a></h1>
<div class="metadata">
	<? if ($post->category): ?><a href="<?=$post->category->url?>"><?=$post->category->name?></a>, <? endif; ?>
	<?=$post->date?>
</div>
<div class="body"><?=$post->body?></div>
<? if ($tagable && $post->tags): ?>
<div id="tags">
	<p id="tag-title">태그 : 
	<? foreach ($post->get_tags() as $tag): ?>
		<a href="<?=url_for_list('board', $board->name, array('tag'=>1, 'keyword'=>urlencode($tag->name)))?>"><?=$tag->name?></a>
	<? endforeach; ?>
</div>
<? endif; ?>
<div class="responses">
	<a href="<?=$post->url?>#comments">댓글 <?=$post->comment_count?>개</a>,
	<? if ($board->use_trackback): ?>
	<a href="<?=$post->url?>#trackbacks">트랙백 <?=$post->get_trackback_count()?>개</a>
	<? else: ?>트랙백 닫힘<? endif; ?>
</div>
</div>
<? endforeach; ?>

<div id="page-list">
<? if ($link_prev_page): ?><a href="<?=$link_prev_page?>">&larr; 이전 페이지</a> <? endif; ?>
<? foreach ($pages as $page): ?><?=$page?> <? endforeach; ?>
<? if ($link_next_page): ?><a href="<?=$link_next_page?>">다음 페이지 &rarr;</a><? endif; ?>
</div>
