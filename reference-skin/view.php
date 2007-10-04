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

	<ul id="attachments">
	<? foreach ($attachments as $attachment): ?>
		<li><a href="<?=$attachment->url?>"><?=$attachment->filename?></a> (<?=$attachment->size?>)</li>
	<? endforeach; ?>
	</ul>

	<!-- 글 내용 -->
	<div class="body"><?=$post->body?></div>

<? if ($signature): ?>
	<!-- 사용자 서명 -->
	<div class="signature"><?=$signature?></div>
<? endif; ?>

<? if ($trackbacks): ?>
<? endif; ?>
</div>

<div id="meta-nav">
<? if ($link_list): ?><a href="<?=$link_list?>">목록보기</a> <? endif; ?>
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a> <? endif; ?>
<? if ($link_edit): ?><a href="<?=$link_edit?>">고치기</a> <? endif; ?>
<? if ($link_delete): ?><a href="<?=$link_delete?>">지우기</a> <? endif; ?>
</div>
