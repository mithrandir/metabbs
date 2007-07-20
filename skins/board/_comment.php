<li id="comment_<?=$comment->id?>">
	<div class="comment">
	<div class="info">
		<div class="name"><?=$comment->name?></div>
		<div class="date"><?=strftime("%Y-%m-%d %H:%M", $comment->created_at)?></div>
		<div class="actions">
		<? if ($account->has_perm('reply', $comment)) { ?>
			<a href="<?=url_for($comment, 'reply')?>" onclick="loadReplyForm('comment_<?=$comment->id?>', this.href); return false"><?=i('Reply')?></a>
		<? } ?>
		<? if ($account->has_perm('delete', $comment)) { ?>
			| <span class="delete"><?=link_to(i('Delete'), $comment, 'delete')?></span>
		<? } ?>
		<? if ($account->has_perm('edit', $comment)) { ?>
			| <span class="edit"><a href="<?=url_for($comment, 'edit')?>" onclick="editComment('comment_<?=$comment->id?>', this.href); return false"><?=i('Edit')?></a></span>
		<? } ?>
		</div>
	</div>
	<div class="body">
	<?=format($comment->body)?>
	</div>
	</div>
	
	<ul id="comments-list-<?=$comment->id?>">
	<? print_comment_tree($comment); ?>
	</ul>
</li>
