<li id="comment_<?=$comment->id?>">
<div class="comment">
	<div class="author">
		<cite><?=$comment->name?></cite>
		<abbr title="<?=meta_format_date_rfc822($comment->created_at)?>"><?=strftime("%Y-%m-%d %H:%M", $comment->created_at)?></abbr>
		<span class="actions">
		<? if ($board->perm_comment <= $account->level) { ?>
			<a href="<?=url_for($comment, 'reply')?>" onclick="loadReplyForm('comment_<?=$comment->id?>', this.href); return false"><?=i('Reply')?></a>
		<? } ?>
		<? if ($board->perm_delete <= $account->level || $account->id == $comment->user_id) { ?>
			| <?=link_to(i('Delete'), $comment, 'delete')?>
			| <?=link_to(i('Edit'), $comment, 'edit')?>
		<? } ?>
		</span>
	</div>
	<div class="content"><?=format($comment->body)?></div>
</div>
	<ol id="comments-list-<?=$comment->id?>" class="comments">
	<? print_comment_tree($comment); ?>
	</ol>
</li>
