<li id="comment_<?=$comment->id?>">
<div class="comment">
	<div class="author">
		<cite><?=$comment->name?></cite>
		<abbr title="<?=meta_format_date_rfc822($comment->created_at)?>"><?=strftime("%Y-%m-%d %H:%M", $comment->created_at)?></abbr>
		<span class="actions">
		<? if ($account->has_perm('comment', $post)) { ?>
			<a href="<?=url_for($comment, 'reply')?>" onclick="loadReplyForm('comment_<?=$comment->id?>', this.href); return false"><?=i('Reply')?></a>
		<? } ?>
		<? if ($account->has_perm('delete', $comment)) { ?>
			| <?=link_to(i('Delete'), $comment, 'delete')?>
		<? } ?>
		<? if ($account->has_perm('edit', $comment)) { ?>
			| <?=link_to(i('Edit'), $comment, 'edit')?>
		<? } ?>
		</span>
	</div>
	<div class="content"><?=format($comment->body)?></div>
</div>
	<ol id="comments-list-<?=$comment->id?>" class="comments">
	<? if ($comment->comments) { apply_filters_array('PostViewComment', $comment->comments); ?>
	<?
	$comment_stack[] = $comment;
	foreach ($comment->comments as $comment) {
		include($_skin_dir . '/_comment.php');
	}
	$comment = array_pop($comment_stack);
	?>
	<? } ?>
	</ol>
</li>