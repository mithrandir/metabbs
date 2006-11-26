	<li class="comment<?if(isset($_GET['ajax'])){echo" new";}?>" id="comment_<?=$comment->id?>">
		<div class="info"><?=$comment->name?> <small><?=meta_format_date("%Y-%m-%d %H:%M", $comment->created_at)?></small> <? if ($board->perm_delete <= $account->level || $account->id == $comment->user_id) { ?><a href="<?=url_for($comment, 'delete')?>">x</a><? } ?></div>
		<div class="body"><?=format($comment->body)?></div>
	</li>
