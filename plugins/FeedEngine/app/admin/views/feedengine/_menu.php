<ul id="edit-section" class="tabs">
	<?=link_list_tab(url_admin_for('feedengine'), 'general', i('General'))?>
	<?=link_list_tab(url_admin_for('feedengine','feed'), 'feed', i('Feed'))?>
	<?=link_list_tab(url_admin_for('feedengine','board'), 'board', i('Board'))?>
	<?=link_list_tab(url_admin_for('feedengine','group'), 'group', i('Group'))?>
	<?//=link_list_tab(url_admin_for('feedengine','cache_purge'), 'cache_purge', i('Cache Purge'))?>
</ul>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<script type="text/javascript">
function edit(id, url) {
	$(id).innerHTML = '&rarr; <form method="post" action="' + url + '"><input type="text" name="value" size="10" /></form>';
}
</script>