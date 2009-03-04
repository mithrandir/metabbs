<?php $GLOBALS['sck_context'] = new SCKManagerMenu; ?>
<h2><?=i('Settings')?></h2>

<form method="post" action="">
<p>사이트 이름: <input type="text" name="site_name" size="30" value="<?=sck_site_name()?>" /></p>
<p>스타일시트:<br /><textarea name="css" cols="80" rows="15"><? sck_stylesheet() ?></textarea></p>
<p><input type="submit" value="OK" /></p>
</form>
