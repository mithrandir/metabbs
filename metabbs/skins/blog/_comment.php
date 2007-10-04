<li id="comment_<?=$comment->id?>">
<div class="comment">
	<div class="author">
		<cite><?=$comment->name?></cite>
		<abbr title="<?=meta_format_date_rfc822($comment->created_at)?>"><?=strftime("%Y-%m-%d %H:%M", $comment->created_at)?></abbr>
		<span class="actions">
		<? if ($account->has_perm('reply', $comment)) { ?>
			<a href="<?=url_for($comment, 'reply')?>" onclick="loadReplyForm('comment_<?=$comment->id?>', this.href); return false"><?=i('Reply')?></a>
		<? } ?>
		<? if ($account->has_perm('delete', $comment)) { ?>
			| <span class="delete"><?=link_to(i('Delete'), $comment, 'delete')?></span>
		<? } ?>
		<? if ($account->has_perm('edit', $comment)) { ?>
			| <span class="edit"><a href="<?=url_for($comment, 'edit')?>" onclick="editComment('comment_<?=$comment->id?>', this.href); return false"><?=i('Edit')?></a></span>
		<? } ?>
		</span>
	</div>
	<div class="content"><?=format($comment->body)?></div>
</div>
	<ol id="comments-list-<?=$comment->id?>" class="comments">
	<? print_comment_tree($comment); ?>
	</ol>
</li>
