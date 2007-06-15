<li id="comment_<?=$comment->id?>">
	<div class="comment">
	<div class="info">
		<div class="name"><?=$comment->name?></div>
		<div class="date"><?=strftime("%Y-%m-%d %H:%M", $comment->created_at)?></div>
		<div class="actions">
		<? if ($account->has_perm('comment', $post)) { ?>
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
	<? if ($comment->comments) { apply_filters_array('PostViewComment', $comment->comments); ?>
	<?
	$comment_stack[] = $comment;
	foreach ($comment->comments as $comment) {
		include($_skin_dir . '/_comment.php');
	}
	$comment = array_pop($comment_stack);
	?>
	<? } ?>
	</ul>
</li>
