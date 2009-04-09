<script type="text/javascript"> 
function openPlayer(id, url) { 
	$(id).innerHTML = '<object type="application/x-shockwave-flash" data="<?=$skin_dir?>/player.swf" width="290" height="24"><param name="movie" value="<?=$skin_dir?>/player.swf" /><param name="FlashVars" value="autostart=yes&amp;soundFile='+url+'" /></object>'; 
} 
</script>

<div id="post">
	<h1 class="title"><span class="title-wrap"><?=$post->title?></span></h1>

	<table class="body">
	<tr>
		<td id="post-side">
			<div class="author"><?=$post->author?></div>
			<div class="date"><?=$post->date?></div>
		</td>

		<td id="post-content">
			<div class="body"><?=$post->body?></div>

			<? if ($taggable and $tags): ?>
			<p id="tags">태그: 
			<? foreach ($tags as $tag): ?>
				<a href="<?=$tag->url?>"><?=$tag->name?></a><? if (!$tag->last): ?>,</a><? endif; ?>
			<? endforeach; ?>
			</p>
			<? endif; ?>

			<? if ($post->edited): ?>
			<p class="edit-info"><?=$post->edited_by?> 님이 <?=$post->edited_at?>에 고쳤습니다.</p>
			<? endif; ?>

			<? if ($signature): ?>
			<div class="signature"><?=$signature?></div>
			<? endif; ?>

			<? if ($attachments and $attachment_downable): ?>
			<ul id="attachments">
			<? foreach ($attachments as $attachment): ?>
				<li>
					<a href="<?=$attachment->url?>" class="file" title="<?=$attachment->filename?>"><?=utf8_strcut($attachment->filename, 30)?></a> (<?=$attachment->size?>)
					<? if ($attachment->is_music()): ?><a href="<?=url_for($attachment)?>" onclick="openPlayer('player-<?=$attachment->id?>', this.href); return false">Listen</a><div id="player-<?=$attachment->id?>"></div><? endif; ?>
					<? if ($attachment->thumbnail_url): ?><br /><img src="<?=$attachment->thumbnail_url?>" alt="<?=$attachment->filename?>" /><? endif; ?>
				</li>
			<? endforeach; ?>
			</ul>
			<? endif; ?>

		</td>
	</tr>
	</table>

<div id="responses">
<? if ($post->trackback_url): ?>
<div id="trackbacks">
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

<? if ($commentable): ?>
<div id="comments">
	<ol id="comment-list">
	<? foreach ($comments as $comment): ?>
		<? include "_comment.php"; ?>
	<? endforeach; ?>
	</ol>
<? if ($comment_writable): ?>
	<? include "comment_form.php"; ?>

	<script type="text/javascript">
	Event.observe('comment-form', 'submit', function (event) {
		addComment('comment-form', $$('#comments ol')[0])
		Event.stop(event);
	});
	</script>
<? endif; ?>
</div>
<? endif; ?>
</div>
</div>

<div id="meta-nav">
<? if ($link_list): ?><a href="<?=$link_list?>">목록보기</a> <? endif; ?>
<? if ($link_new_post): ?><a href="<?=$link_new_post?>">글쓰기</a> <? endif; ?>
<? if ($link_edit): ?><a href="<?=$link_edit?>">고치기</a> <? endif; ?>
<? if ($link_delete): ?><a href="<?=$link_delete?>" class="dialog">지우기</a> <? endif; ?>
</div>

<p id="neighbor-posts">
<? if ($newer_post): ?>
<a href="<?=$newer_post->url?>" title="<?=$newer_post->title?>">&larr; <?=utf8_strcut($newer_post->title, 20)?></a>
<? endif; ?>
<? if ($newer_post and $older_post): ?> | <? endif; ?>
<? if ($older_post): ?>
<a href="<?=$older_post->url?>" title="<?=$older_post->title?>"><?=utf8_strcut($older_post->title, 20)?> &rarr;</a>
<? endif; ?>
</p>
