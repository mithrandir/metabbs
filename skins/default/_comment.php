<li id="comment_<?=$comment->id?>">
	<div class="comment">
	<div class="info">
		<span class="name"><?=$comment->name?></span>
		<span class="date"><?=meta_format_date("%Y-%m-%d %H:%M", $comment->created_at)?></span>
		<span class="actions">
		<? if ($board->perm_comment <= $account->level) { ?>
			<?=link_to(i('Reply'), $comment, 'reply')?> |
		<? } ?>
		<? if ($board->perm_delete <= $account->level || $account->id == $comment->user_id) { ?>
			<?=link_to(i('Delete'), $comment, 'delete')?> |
			<?=link_to(i('Edit'), $comment, 'edit')?>
		<? } ?>
		</span>
	</div>
	<div class="body"><?=format($comment->body)?></div>
	</div>
	
	<? if ($comment->comments) { apply_filters_array('PostViewComment', $comment->comments); ?>
	<ul>
	<?
	$comment_stack[] = $comment;
	foreach ($comment->comments as $comment) {
		include($_skin_dir . '/_comment.php');
	}
	$comment = array_pop($comment_stack);
	?>
	</ul>
	<? } ?>
</li>
