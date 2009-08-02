<? if ($commentable): ?>
<h1><?=i('Edit Comment')?></h1>
<? include "_comment_form.php"; ?>
<? if (is_xhr()): ?>
<script type="text/javascript">
Event.observe('<?=$form_id?>', 'submit', function (event) {
	editComment(this, <?=$comment_id?>)
	Event.stop(event)
})
</script>
<? endif; ?>
<? endif; ?>