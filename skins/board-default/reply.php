<h1>답글 달기</h1>

<? include "comment_form.php"; ?>

<script type="text/javascript">
Event.observe('<?=$form_id?>', 'submit', function (event) {
	replyComment(this, <?=$comment->id?>);
	Event.stop(event)
})
</script>
