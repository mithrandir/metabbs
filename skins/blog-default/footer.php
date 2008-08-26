</div>

<div id="blog-footer">
<div class="column">
<h3>최근 댓글</h3>
<ol>
<? foreach ($board->get_recent_comments(5) as $comment): ?>
	<li><a href="<?=url_for($comment)?>"><?=htmlspecialchars($comment->name)?> (<?=date('m/d', $comment->created_at)?>)</a>: <?=htmlspecialchars(utf8_strcut($comment->body, 30))?></li>
<? endforeach; ?>
</ol>
</div>

<div class="column">
<? if ($board->use_category): ?>
<h3>분류</h3>
<ul>
<? foreach ($categories?$categories:$board->get_categories() as $category): ?>
	<li><a href="<?=blog_url($board)?>?category=<?=$category->id?>"><?=htmlspecialchars($category->name)?></a> (<?=$category->get_post_count()?>)</a></li>
<? endforeach; ?>
</ul>
<? endif; ?>

<form method="get" action="<?=url_for($board)?>" id="search-form">
<h3>찾기</h3>
<div>
	<input type="hidden" name="title" value="1" />
	<input type="hidden" name="body" value="1" /> 
<? if ($tagable): ?>
	<input type="hidden" name="tag" value="1" />
<? endif; ?>
	<input type="text" name="keyword" value="<?=@$keyword?>" />
	<input type="submit" value="검색" />
</div>
</form>
</div>

<div class="column">
<ul>
	<li><a href="<?=url_for($board, 'rss')?>">RSS 2.0 피드</a></li>
	<li><a href="<?=url_for($board, 'atom')?>">Atom 1.0 피드</a></li>
</ul>

<p>Powered by <a href="http://metabbs.org/">MetaBBS</a> (<?=METABBS_VERSION?>)</p>
</div>
</div>
