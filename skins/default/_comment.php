	<li class="comment<?if(isset($_POST['ajax'])){echo" new";}?>" id="comment_<?=$comment->id?>">
		<div class="info"><span class="name"><?=link_to_user($comment->get_user())?></span> <span class="date"><?=date_format("%Y-%m-%d %H:%m", $comment->created_at)?></span> <? if ($board->perm_delete <= $account->level || $account->id == $comment->user_id) { ?><?=link_to('x', $comment, 'delete')?><? } ?></div>
		<div class="body"><?=format($comment->body)?></div>
	</li>
