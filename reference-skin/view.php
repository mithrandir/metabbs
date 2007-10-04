<div id="post">
	<!-- 글 제목 -->
	<h1><?=$post->title?></h1>

	<!-- 글 정보 -->
	<dl class="metadata">
		<dt>글쓴이</dt>
		<dd><?=$post->author?></dd>

		<dt>날짜</dt>
		<dd><?=$post->date?></dd>
		
		<dt>조회수</dt>
		<dd><?=$post->views?></dd>

		<dt>트랙백 주소</dt>
		<dd><?=$post->trackback_url?></dd>

<? if ($post->category): ?>
		<dt>분류</dt>
		<dd><a href="<?=$post->category->url?>"><?=$post->category->name?></a></dd>
<? endif; ?>

<? if ($post->edited): ?>
		<dt>수정 시각</dt>
		<dd><?=$post->edited_by?> 님이 <?=$post->edited_at?>에 고침</dd>
<? endif; ?>

<? if ($newer_post): ?>
		<dt>이전 글</dt>
		<dd><a href="<?=$newer_post->url?>"><?=$newer_post->title?></a></dd>
<? endif; ?>

<? if ($older_post): ?>
		<dt>다음 글</dt>
		<dd><a href="<?=$older_post->url?>"><?=$older_post->title?></a></dd>
<? endif; ?>
	</dl>

<? if ($attachments): ?>
	<ul id="attachments">
	<? foreach ($attachments as $attachment): ?>
		<li><a href="<?=$attachment->url?>"><?=$attachment->filename?></a> (<?=$attachment->size?>)</li>
	<? endforeach; ?>
	</ul>
<? endif; ?>

	<!-- 글 내용 -->
	<div class="body"><?=$post->body?></div>

<? if ($signature): ?>
	<!-- 사용자 서명 -->
	<div class="signature"><?=$signature?></div>
<? endif; ?>

<? if ($trackbacks): ?>
<? endif; ?>

<h2>댓글</h2>
<ol id="comments">
<? foreach ($comments as $comment): ?>
	<li class="comment">
		<span class="author"><?=$comment->author?></span>
		<span class="date"><?=$comment->date?></span>
		<span class="actions">
		<? if ($comment->delete_url): ?><a href="<?=$comment->delete_url?>">지우기</a><? endif; ?>
		<? if ($comment->edit_url): ?><a href="<?=$comment->edit_url?>">고치기</a><? endif; ?>
		</span>
		<div class="body"><?=$comment->body?></div>
	</li>
<? endforeach; ?>
</ol>
</div>

<div id="meta-nav">
<? if ($link_list): ?><a href="<?=$link_list?>">목록보기</a> <? endif; ?>
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a> <? endif; ?>
<? if ($link_edit): ?><a href="<?=$link_edit?>">고치기</a> <? endif; ?>
<? if ($link_delete): ?><a href="<?=$link_delete?>">지우기</a> <? endif; ?>
</div>
