<form method="post">
<?php print_flash() ?>
<p><label for="password">Password:</label> <input type="password" id="password" name="password" /> <input type="submit" value="Go" /></p>
<p><?=link_to_post($this->post, "Back")?></p>
</form>
