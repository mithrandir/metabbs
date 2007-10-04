<div id="manage-posts-dialog" style="display: none">
<p>Select action:</p>
<p><input type="radio" name="action" value="delete" id="action-delete" checked="checked" /> <label for="action-delete">Delete</label>
<? if ($board->use_category) { ?>
<br /><input type="radio" name="action" value="change-category" id="action-change-category" /> <label for="action-change-category">Change category:</label><br />
<select name="category" style="margin-left: 2em">
<? foreach ($board->get_categories() as $category) { ?>
	<?=option_tag($category->id, $category->name)?>
<? } ?>
</select>
<? } ?>
</p>
<p><input type="submit" value="OK" /> or <a href="#" onclick="$('manage-posts-dialog').hide()">close</a></p>
</div>

<script type="text/javascript">
var form = $('manage-posts');
if (form) {
	Event.observe(form, 'submit', function (event) {
		var form = Event.element(event);
		var dialog = $('manage-posts-dialog');
		if (dialog.visible()) return true;
		dialog.setStyle({
			position: 'absolute',
			left: '50%',
			top: '50%',
			border: '5px solid #ccc',
			backgroundColor: '#fff',
			padding: '0.5em 1.5em',
			width: '15em'
		});
		dialog.setStyle({
			marginLeft: (-dialog.getWidth()/2) + 'px',
			marginTop: (-dialog.getHeight()/2) + 'px'
		});
		dialog.show();
		Event.stop(event);
	});
}
</script>
