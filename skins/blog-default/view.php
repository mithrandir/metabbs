<div class="entry">
<h1><?=$post->title?></h1>
<div class="metadata">
	<? if ($post->category): ?><a href="<?=$post->category->url?>"><?=$post->category->name?></a>, <? endif; ?>
	<?=$post->date?>
</div>
<div class="actions">
<? if ($link_edit): ?><a href="<?=$link_edit?>">고치기</a> / <? endif; ?>
<? if ($link_delete): ?><a href="<?=$link_delete?>">지우기</a> <? endif; ?>
</div>
<div class="body">
<? foreach ($attachments as $attachment): ?>
<? if ($attachment->thumbnail_url): ?>
<p><img src="<?=$attachment->url?>" alt="<?=$attachment->filename?>" /></p>
<? else: ?>
<p>첨부 파일: <a href="<?=$attachment->url?>"><?=$attachment->filename?></a> (<?=$attachment->size?>)</p>
<? endif; ?>
<? endforeach; ?>
<?=$post->body?>
</div>

<? if ($taggable and $tags): ?>
<p id="tags">태그: 
<? foreach ($tags as $tag): ?>
	<a href="<?=$tag->url?>"><?=$tag->name?></a><? if (!$tag->last): ?>,</a><? endif; ?>
<? endforeach; ?>
</p>
<? endif; ?>
</div>

<div class="responses">
<? if ($post->trackback_url): ?>
<div id="trackbacks">
	<h2>트랙백</h2>
	<p id="trackback-url">트랙백 주소: <?=$post->trackback_url?></p>
<? if ($trackbacks): ?>
	<ol>
	<? foreach ($trackbacks as $trackback): ?>
		<li>
			<a href="<?=$trackback->url?>"><?=$trackback->title?></a> from <?=$trackback->blog_name?>
			<? if ($trackback->delete_url): ?><a href="<?=$trackback->delete_url?>">삭제</a><? endif; ?>
		</li>
	<? endforeach; ?>
	</ol>
<? endif; ?>
</div>
<? endif; ?>

	<h2>댓글</h2>
	<ol id="comments">
	<? foreach ($comments as $comment): ?>
		<? include "_comment.php"; ?>
	<? endforeach; ?>
	</ol>

	<? include "comment_form.php"; ?>

	<script type="text/javascript">
	Event.observe('comment-form', 'submit', function (event) {
		addComment('comment-form', $('comments'))
		Event.stop(event);
	});
	</script>
</div>
