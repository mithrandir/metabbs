<form method="post" action="<?=url_for($comment, 'reply')?>" onsubmit="return replyComment(this, 'comments-list-<?=$comment->id?>')" id="reply-form">
<? include '_comment_form.php'; ?>
</form>
