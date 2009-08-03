<? if ($commentable): ?>
<h1><?=i('Delete Comment')?></h1>
<? include "_delete_form.php"; ?>
<? if (is_xhr()): ?>
<script type="text/javascript">
Event.observe('delete-form', 'submit', function (event) {
	deleteComment(this, <?=$comment->id?>, <?=$comment->has_child() ? 'true' : 'false'?>);
	Event.stop(event)
})
</script>
<? endif; ?>
<? endif; ?>