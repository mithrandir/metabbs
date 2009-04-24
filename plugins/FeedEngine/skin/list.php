<script type="text/javascript">
function click_feed(url) {
	new Ajax.Request( url, { method: 'get' });
}
</script>
<div id="account-info">
<? if ($guest): ?>
<a href="<?=$link_login?>" class="dialog">로그인</a>
<a href="<?=$link_signup?>">회원가입</a>
<? else: ?>
<a href="<?=$link_logout?>">로그아웃</a>
<a href="<?=$link_account?>">정보 수정</a>
<? if ($link_admin): ?><a href="<?=$link_admin?>">관리자 페이지</a><? endif; ?>
<? endif; ?>
</div>

<div id="board-info">
모두 <?=$post_count?>개의 글이 있습니다.
<a href="<?=$link_rss?>" class="feed"><img src="<?=$skin_dir?>/feed.png" alt="RSS" /></a>
</div>

<? if ($categories): ?>
<div id="categories">
	<strong>분류:</strong> <a href="?">전체 보기</a>
<? foreach ($categories as $category): ?>
	&ndash; <a href="<?=$category->url?>"><?=$category->name?></a> <span class="post-count">(<?=$category->post_count?>)</span>
<? endforeach; ?>
</div>
<? endif; ?>


<form method="post" action="<?=$manage_url?>" id="posts">
	<h1 class="title"><span class="title-wrap"><? if ($admin): ?><input type="checkbox" onclick="toggleAll(this.form, this.checked)" /><? endif; ?>&nbsp;</span></h1>
	<? foreach ($posts as $post): ?>
<?
	$attachments = $post->get_attachments();
	$first_image = new Attachment;
	foreach ($attachments as $attachment) {
		if ($attachment->is_image()) {
			unset($first_image);
			$first_image = $attachment;
			continue;
		}
	}
	$feed = Feed::find($post->feed_id);

	$tags = array();
	if(!empty($post->tags)) {
		foreach(explode(',', $post->tags) as $tag)
			array_push($tags, "<a href=\"?tag=1&keyword=".urlencode($tag)."\">$tag</a>");
	}
?>
	<div class="post">
		<? if($first_image->exists()): ?>
		<div class="thumbnail" style="background: transparent url(<?=url_for($first_image)?>?thumb) no-repeat scroll center center; width: 100px; height: 100px;" alt="<?=$post->title?>"></div>
		<? endif; ?>
		<h2 class="title <?=$first_image->exists() ? 'have_image':''?>"><? if ($admin): ?><input type="checkbox" name="posts[]" value="<?=$post->id?>" /> <? endif; ?>
		<? if ($post->secret): ?><span class="secret">비공개</span> | <? endif; ?>
		<a href="<?=$post->feed_link?>" onclick="window.open(this.href); return false;" title="<?=$post->title?>"><?=utf8_strcut($post->title, ($first_image->exists()?50:70))?></a></h2>
		<p class="info <?=$first_image->exists() ? 'have_image':''?>">
		<a href="<?=$feed->link?>" onclick="click_feed('/feedengine/feed/updateViews?board=<?=$board->name?>&post=<?=$post->id?>'); window.open(this.href); return false;"><?=$feed->title?></a>
		| <span class="date"><?=$post->date?></a></span>
		| <span class="author"><?=$post->author?></span>
		</p>
		<p class="description <?=$first_image->exists() ? 'have_image':''?>"><?=utf8_strcut(strip_tags($post->body), ($first_image->exists()?250:300))?></p>
		<? if($tagable && count($tags) > 0): ?>
		<p class="tags"><span>Tags : </span><?=implode(", ", $tags)?></p>
		<? endif; ?>
	</div>
	<? endforeach; ?>

<div id="page-list">
<? if ($link_prev_page): ?><a href="<?=$link_prev_page?>">&larr; 이전 페이지</a> <? endif; ?>
<? foreach ($pages as $page): ?><?=$page?> <? endforeach; ?>
<? if ($link_next_page): ?><a href="<?=$link_next_page?>">다음 페이지 &rarr;</a><? endif; ?>
</div>

<div id="meta-nav">
<? if ($admin): ?> <input type="submit" value="이동/삭제" class="button" /><? endif; ?>
</div>
</form>

<form method="get" action="" id="search-form">
<div>
	<input type="checkbox" name="author" id="search_author" value="1" <?=$author_checked?> /> <label for="search_author">글쓴이</label> 
	<input type="checkbox" name="title" id="search_title" value="1" <?=$title_checked?> /> <label for="search_title">제목</label> 
	<input type="checkbox" name="body" id="search_body" value="1" <?=$body_checked?> /> <label for="search_body">내용</label> 
<? if ($tagable): ?>
	<input type="checkbox" name="tag" id="search_tag" value="1" <?=$tag_checked?> /> <label for="search_tag">태그</label> 
<? endif; ?>
	<input type="text" name="keyword" value="<?=$keyword?>" />
	<input type="submit" value="검색" />
</div>
</form>

<div id="update-box"></div>

<script type="text/javascript">
/*new Ajax.Updater('update-box', '<?=full_url_for("feedengine", "feed")."update?board=".$board->id?>', { method: 'get' });*/
</script>
