<li id="comment_<?=$comment->id?>">
	<div class="comment">
	<div class="info">
		<span class="name"><?=$comment->name?></span>
		<span class="date"><?=strftime("%Y-%m-%d %H:%M", $comment->created_at)?></span>
		<span class="actions">
		<? if ($board->perm_comment <= $account->level) { ?>
			<a href="<?=url_for($comment, 'reply')?>" onclick="loadReplyForm('comment_<?=$comment->id?>', this.href); return false"><?=i('Reply')?></a>
		<? } ?>
		<? if ($board->perm_delete <= $account->level || $account->id == $comment->user_id) { ?>
			| <span class="delete"><?=link_to(i('Delete'), $comment, 'delete')?></span>
			| <span class="edit"><?=link_to(i('Edit'), $comment, 'edit')?></span>
		<? } ?>
		</span>
	</div>
	<div class="body"><?=format($comment->body)?></div>
	</div>
	
	<ul id="comments-list-<?=$comment->id?>">
	<? print_comment_tree($comment); ?>
	</ul>
</li>
