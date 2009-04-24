<hr />
<script type="text/javascript">
function process_hompage(url) {
new Ajax.Updater('homepage-box', url, { method: 'get' });
}
function add_feed(url) { 
new Ajax.Updater('homepage-box', url, { method: 'post', parameters: { feed_url : $('feed_url').value } });	
}
</script>
<form method="post" onsubmit="Ajax.Updater('homepage-box', this.action, { method: 'post', parameters: { feed_url : $('feed_url').value } }); return false;" action="/feedengine/account/add?url=<?=urlencode($_SERVER['REQUEST_URI'])?>" id="feed-form">
<h2><?=i('Homepage')?></h2>
<div id="homepage-box">
<? include "_homepage.php"; ?>
</div>

<h3><?=i('Add Feed')?></h3>
<fieldset>
<p>
	<label><?=i('URL')?></label>
	<input type="text" id="feed_url" name="feed_url" size="50" />
</p>
<p><input type="submit" value="Add" class="button"/></p>
</fieldset>
</form>
