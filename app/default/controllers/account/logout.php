<?php
login_required();

$nothing = null;
apply_filters('BeforeLogout', $nothing);
UserManager::logout();
apply_filters('AfterLogout', $nothing);
redirect_back();
?>
