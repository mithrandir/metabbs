<?php
if (is_post()) {
    $user = User::auth($params['user'], md5($params['password']));
    if ($user->exists()) {
        cookie_register("user", $user->user);
        cookie_register("password", $user->password);
        redirect_to($params['url']);
    } else {
        $user = new Guest;
        $flash = 'Login failed.';
    }
}
?>
