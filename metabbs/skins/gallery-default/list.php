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

<? if ($categories): ?>
<div id="categories">
	<strong>분류:</strong> <a href="?">전체 보기</a>
<? foreach ($categories as $category): ?>
	&ndash; <a href="<?=$category->url?>"><?=$category->name?></a> <span class="post-count">(<?=$category->post_count?>)</span>
<? endforeach; ?>
</div>
<? endif; ?>

<form method="post" action="<?=$manage_url?>">
<? if ($notices): ?>
<ul id="notices">
<? foreach ($notices as $notice): ?>
	<li>
		<? if ($admin): ?><input type="checkbox" name="posts[]" value="<?=$notice->id?>" /><? endif; ?>
		<? if ($notice->category): ?><span class="category"><?=$notice->category->name?></span><? endif; ?>
		<a href="<?=$notice->url?>"><?=$notice->title?></a>
		<span class="comment-count"><?=$notice->comment_count?></span>
		<span class="metadata">
		/ <?=$notice->author?>
		<?=$notice->date?>
		</span>
	</li>
<? endforeach; ?>
</ul>
<? endif; ?>

<table id="images">
<? for ($i = 0, $rows = ceil(count($posts) / 4); $i < $rows; $i++): ?>
<tr>
	<? for ($j = 0; $j < 4; $j++): $post = @$posts[$i * 4 + $j]; ?>
	<td>
	<? if ($post): ?>
		<p><a href="<?=$post->url?>"><img src="<?=$post->attachments[0]->thumbnail_url?>" alt="<?=$post->title?>" /></a></p>
		<p>
			<? if ($post->category): ?><span class="category"><?=$post->category->name?></span><? endif; ?>
			<a href="<?=$post->url?>"><?=$post->title?></a>
			<span class="comment-count"><?=$post->comment_count?></span>
		</p>
		<p class="metadata">
			<? if ($admin): ?><input type="checkbox" name="posts[]" value="<?=$post->id?>" /><? endif; ?>
			<?=$post->author?><br />
			<?=$post->date?><? if ($post->attachment_count > 1): ?>, <?=$post->attachment_count?> images<? endif; ?>
		</p>
	<? endif; ?>
	</td>
	<? endfor; ?>
</tr>
<? endfor; ?>
</tr>
</table>

<div id="page-list">
<? if ($link_prev_page): ?><a href="<?=$link_prev_page?>">&larr; 이전 페이지</a> <? endif; ?>
<? foreach ($pages as $page): ?><?=$page?> <? endforeach; ?>
<? if ($link_next_page): ?><a href="<?=$link_next_page?>">다음 페이지 &rarr;</a><? endif; ?>
</div>

<div id="meta-nav" class="list">
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a><? endif; ?>
<? if ($admin): ?> <input type="submit" value="이동/삭제" class="button" /><? endif; ?>
</div>
</form>
