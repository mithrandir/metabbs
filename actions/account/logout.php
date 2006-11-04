<?php
if (UserManager::logout()) {
	redirect_back();
}
?>
