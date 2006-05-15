<?php
if (isset($user)) {
    cookie_unregister('user');
    cookie_unregister('password');
    redirect_to($params['url']);
}
?>
