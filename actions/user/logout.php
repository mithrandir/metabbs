<?php
if (isset($user)) {
    unset($_SESSION['user_id']);
    redirect_to($params['url']);
}
?>
