<li class="comment" id="comment_<?=$comment->id?>">
	<div class="info">
		<span class="name">
			<? if ($comment->user_id) { ?>
				<?=link_to_user($comment->get_user())?>
			<? } else { ?>
				<?=$comment->name?>
			<? } ?>
		</span>
		<span class="date"><?=meta_format_date("%Y-%m-%d %H:%M", $comment->created_at)?></span>
		<span class="actions">
		<? if ($board->perm_delete <= $account->level || $account->id == $comment->user_id) { ?>
			<?=link_to(i('Delete'), $comment, 'delete')?> |
			<?=link_to(i('Edit'), $comment, 'edit')?>
		<? } ?>
		</span>
	</div>
	<div class="body"><?=format($comment->body)?></div>
</li>
