	<li class="comment<?if(isset($_POST['ajax'])){echo" new";}?>" id="comment_<?=$comment->id?>">
		<div class="info"><?=link_to_user($comment->get_user())?> <small><?=date_format("%Y-%m-%d %H:%m", $comment->created_at)?></small> <? if ($board->perm_delete <= $user->level || $user->id == $comment->user_id) { ?><?=link_to('x', $comment, 'delete')?><? } ?></div>
		<div class="body"><?=format($comment->body)?></div>
	</li>
