<? if ($commentable): ?>
<h1><?=i('Edit Comment')?></h1>

<? include "comment_form.php"; ?>

<script type="text/javascript">
/*Event.observe('edit-form', 'submit', function (event) {
	editComment(this, <?//=$comment->id?>)
	Event.stop(event)
})*/
</script>
<? endif; ?>