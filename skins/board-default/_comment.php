		<li id="comment_<?=$comment->id?>" class="comment parent-<?=$comment->parent?>" <?if(isset($comment->depth)):?> style="margin-left: <?=$comment->depth * 2?>em"<?endif;?>>
			<div class="actions">
			<? if ($comment->reply_url): ?><a href="<?=$comment->reply_url?>" class="dialog">답글 달기</a><? endif; ?>
			<? if ($comment->delete_url): ?>| <a href="<?=$comment->delete_url?>" class="dialog">지우기</a><? endif; ?>
			<? if ($comment->edit_url): ?>| <a href="<?=$comment->edit_url?>" class="dialog">고치기</a><? endif; ?>
			</div>
			<span class="author"><?=$comment->author?></span>
			<span class="date"><?=$comment->date?></span>
			<div class="comment-body"><?=$comment->body?></div>
		</li>
