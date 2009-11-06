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
<div class="body">
<? if ($post->secret): ?>
비밀글입니다.
<? else: ?>
<? foreach ($post->attachments as $attachment): ?>
<? if ($attachment->thumbnail_url): ?>
<p><img src="<?=$attachment->url?>" alt="<?=$attachment->filename?>" /></p>
<? else: ?>
<p>첨부 파일: <a href="<?=$attachment->url?>"><?=$attachment->filename?></a> (<?=$attachment->size?>)</p>
<? endif; ?>
<? endforeach; ?>
<?=$post->body?>
<? endif; ?>
</div>
<? if ($taggable and $post->tags): ?>
<div id="tags">
	<p id="tag-title">태그: 
	<? foreach ($post->tags as $tag): ?>
		<a href="<?=$tag->url?>"><?=$tag->name?></a><? if (!$tag->last): ?>, <? endif; ?>
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

<div class="page-nav">
<? foreach($pages as $page): ?>
<? if ($page['name'] == 'padding'): ?>
<?=$page['text']?>
<? elseif ($page['name'] == 'prev'):?>
<a href="<?=$page['url']?>" class="<?=$page['name']?>">&larr; 이전 페이지</a>
<? elseif ($page['name'] == 'next'):?>
<a href="<?=$page['url']?>" class="<?=$page['name']?>">다음 페이지 &rarr;</a>
<? else:?>
<a href="<?=$page['url']?>" class="<?=$page['name']?>"><?=$page['text']?></a>
<? endif; ?>
<? endforeach; ?>
</div>
