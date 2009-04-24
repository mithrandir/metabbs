<h1>정보 고치기</h1>
<form method="post" onsubmit="return checkForm(this)" action="?url=<?=$_GET['url']?>" id="signup-form">
<fieldset>
<h2>기본 정보</h2>
<p>
	<label><?=i('User ID')?></label>
	<?=$account->user?>
</p>
<p>
	<label><?=i('Password')?></label>
	<input type="password" name="user[password]" class="ignore" />
</p>
<p>
	<label><?=i('Screen name')?><span class="star">*</span></label>
	<input type="text" name="user[name]" value="<?=$account->name?>" />
</p>
</fieldset>
<fieldset>
<h2>추가 정보</h2>
<p>
	<label><?=i('E-Mail Address')?></label>
	<input type="text" name="user[email]" size="50" class="ignore" value="<?=$account->email?>" />
</p>
<p>
	<label><?=i('Signature')?></label>
	<textarea name="user[signature]" cols="50" rows="5" class="ignore"><?=$account->signature?></textarea>
</p>
<p><input type="submit" value="<?=i('Edit Info')?>" class="button"/><a href="#" class="button dialog-close" onclick="history.back();return false;">취소</a></p>
</fieldset>
</form>

<hr />
<script type="text/javascript">
function process_hompage(url) {
new Ajax.Updater('homepage-box', url, {
	method: 'get'
});	
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