<div id="board-info">
모두 <?=$post_count?>개의 글이 있습니다.
<a href="<?=$link_rss?>">RSS</a>
</div>

<? if ($categories): ?>
<ul id="categories">
	<li><a href="?">전체 보기</a></li> <!-- 설명 필요 -->
<? foreach ($categories as $category): ?>
	<li><a href="<?=$category->url?>"><?=$category->name?></a> (<?=$category->post_count?>)</li>
<? endforeach; ?>
</ul>
<? endif; ?>

<table id="posts">
	<thead>
		<tr>
			<th class="author">글쓴이</th>
			<th class="title">제목</th>
			<th class="date">날짜</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="3" id="page-list">
				<? if ($link_prev_page): ?><a href="<?=$link_prev_page?>">&larr;</a><? endif; ?>
				<? foreach ($pages as $page): ?><?=$page?> <? endforeach; ?>
				<? if ($link_next_page): ?><a href="<?=$link_next_page?>">&rarr;</a><? endif; ?>
			</td>
		</tr>
	</tfoot>

	<tbody>
	<? foreach ($posts as $post): ?>
		<tr>
			<td class="author"><?=$post->author?></td>
			<td class="title">
				<? if ($post->notice): ?>공지사항<? endif; ?>
				<? if ($post->secret): ?>비밀글<? endif; ?>
				<? if ($post->category): ?><a href="<?=$post->category->url?>"><?=$post->category->name?></a><? endif; ?>
				<a href="<?=$post->url?>"><?=$post->title?></a>
				<? if ($post->comment_count): ?><?=$post->comment_count?><? endif; ?>
			</td>
			<td class="date"><?=$post->date?></td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<!-- TODO: 글 관리 -->

<div id="meta-nav">
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a><? endif; ?>
</div>

<!-- TODO: 검색 폼 -->
