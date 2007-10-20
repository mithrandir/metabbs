<div id="board-info">
모두 <?=$post_count?>개의 글이 있습니다.
<a href="<?=$link_rss?>">RSS</a>
</div>

<? if ($categories): ?>
<ul id="categories">
	<li><a href="?">전체 보기</a></li>
<? foreach ($categories as $category): ?>
	<li><a href="<?=$category->url?>"><?=$category->name?></a> (<?=$category->post_count?>)</li>
<? endforeach; ?>
</ul>
<? endif; ?>

<form method="post" action="<?=$manage_url?>">
<table id="posts">
	<thead>
		<tr>
			<? if ($admin): ?><th class="manage"><input type="checkbox" onclick="toggleAll(this.form, this.checked)" /></th><? endif; ?>
			<th class="author">글쓴이</th>
			<th class="title">제목</th>
			<th class="views">조회수</th>
			<th class="date">날짜</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="4" id="page-list">
				<? if ($link_prev_page): ?><a href="<?=$link_prev_page?>">&larr;</a><? endif; ?>
				<? foreach ($pages as $page): ?><?=$page?> <? endforeach; ?>
				<? if ($link_next_page): ?><a href="<?=$link_next_page?>">&rarr;</a><? endif; ?>
			</td>
		</tr>
	</tfoot>

	<tbody>
	<? foreach ($posts as $post): ?>
		<tr>
			<? if ($admin): ?><td class="manage"><input type="checkbox" name="posts[]" value="<?=$post->id?>" /></td><? endif; ?>
			<td class="author"><?=$post->author?></td>
			<td class="title">
				<? if ($post->notice): ?>공지사항<? endif; ?>
				<? if ($post->secret): ?>비밀글<? endif; ?>
				<? if ($post->category): ?><a href="<?=$post->category->url?>"><?=$post->category->name?></a><? endif; ?>
				<a href="<?=$post->url?>"><?=$post->title?></a>
				<? if ($post->comment_count): ?><?=$post->comment_count?><? endif; ?>
			</td>
			<td class="views"><?=$post->views?>번 읽힘</td>
			<td class="date"><?=$post->date?></td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<? if ($admin): ?><input type="submit" value="선택한 글 관리" /><? endif; ?>
</form>

<div id="meta-nav">
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a><? endif; ?>
</div>

<form method="get" action="">
	<input type="checkbox" name="title" id="search_title" value="1" <?=$title_checked?> /> <label for="search_title">제목</label> 
	<input type="checkbox" name="body" id="search_body" value="1" <?=$body_checked?> /> <label for="search_body">내용</label> 
	<input type="checkbox" name="comment" id="search_comment" value="1" <?=$comment_checked?> /> <label for="search_comment">댓글</label> 
	<input type="text" name="keyword" value="<?=$keyword?>" />
	<input type="submit" value="검색" />
</form>
