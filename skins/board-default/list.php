<h1 id="board-title"><?=$board->title?></h1>

<div id="account-info">
<? foreach (get_account_control($account) as $account_link):?>
<?= $account_link ?> 
<? endforeach; ?>
</div>

<?=flash_message_box()?>

<div id="board-info">
모두 <?=$post_count?>개의 글이 있습니다.
<a href="<?=$link_rss?>" class="feed"><img src="<?=$skin_dir?>/feed.png" alt="RSS" /></a>
</div>

<? if ($categories): ?>
<div id="categories">
	<strong>분류:</strong> <a href="<?=url_for($board)?>">전체 보기</a>
<? foreach ($categories as $category): ?>
	&ndash; <a href="<?=$category->url?>"><?=$category->name?></a> <span class="post-count">(<?=$category->post_count?>)</span>
<? endforeach; ?>
</div>
<? endif; ?>

<form method="post" action="<?=url_with_referer_for($board, 'manage')?>">
<table id="posts">
	<tr>
		<? if ($admin): ?><th class="manage left"><input type="checkbox" onclick="toggleAll(this.form, this.checked)" /></th><? endif; ?>
		<th class="author<? if (!$admin): ?> left<? endif; ?>">글쓴이</th>
		<th class="title">제목</th>
		<th class="date">날짜</th>
	</tr>

	<? foreach ($posts as $post): ?>
	<tr<? if ($post->notice): ?> class="notice"<? endif; ?>>
		<? if ($admin): ?><td class="manage"><input type="checkbox" name="posts[]" value="<?=$post->id?>" /></td><? endif; ?>
		<td class="author"><?=$post->author?></td>
		<td class="title">
			<? if ($post->category): ?><span class="category"><?=$post->category->name?></span><? endif; ?>
			<? if ($post->secret): ?><span class="secret"><?=i('Secret')?></span><? endif; ?>
			<? if ($post->moved_to): ?><span class="moved"><?=i('Moved')?></span><? endif; ?>
			<a href="<?=$post->url?>" title="<?=$post->title?>" class="title"><?=utf8_strcut($post->title, 50)?></a>
			<? if ($post->comment_count): ?><span class="comment-count"><?=$post->comment_count?></span><? endif; ?>
			<? if ($post->attachment_count): ?><span class="attachment-count"><?=$post->attachment_count?></span><? endif; ?>
		</td>
		<td class="date"><?=$post->date?></td>
	</tr>
	<? endforeach; ?>
</table>

<div id="page-list">
<? if ($link_prev_page): ?><a href="<?=$link_prev_page?>">&larr; 이전 페이지</a> <? endif; ?>
<? foreach ($pages as $page): ?><?=$page?> <? endforeach; ?>
<? if ($link_next_page): ?><a href="<?=$link_next_page?>">다음 페이지 &rarr;</a><? endif; ?>
</div>

<div id="meta-nav">
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a><? endif; ?>
<? if ($admin): ?> <input type="submit" value="이동/삭제" class="button" /><? endif; ?>
</div>
</form>

<form method="get" action="" id="search-form">
<div>
	<input type="checkbox" name="author" id="search_author" value="1" <?=$author_checked?> /> <label for="search_author">글쓴이</label> 
	<input type="checkbox" name="title" id="search_title" value="1" <?=$title_checked?> /> <label for="search_title">제목</label> 
	<input type="checkbox" name="body" id="search_body" value="1" <?=$body_checked?> /> <label for="search_body">내용</label> 
	<input type="checkbox" name="comment" id="search_comment" value="1" <?=$comment_checked?> /> <label for="search_comment">댓글</label> 
<? if ($taggable): ?>
	<input type="checkbox" name="tag" id="search_tag" value="1" <?=$tag_checked?> /> <label for="search_tag">태그</label> 
<? endif; ?>
	<input type="text" name="keyword" value="<?=$keyword?>" />
	<input type="submit" value="검색" class="button"/>
</div>
</form>
