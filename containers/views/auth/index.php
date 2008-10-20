<form method="post" action="<?=$return_url?>">
<p>Password required.</p>
<?php if (isset($_GET['retry'])) { ?>
<p style="color:red">Error: Wrong password</p>
<?php } ?>
<p><?=i('Password')?>: <input type="password" name="_auth_password" /> <input type="submit" value="OK" /></p>
</form>
