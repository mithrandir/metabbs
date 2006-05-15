<?php
if (is_post()) {
    $user = User::auth($params['user'], $params['password']);
    if ($user->exists()) {
        $_SESSION['user_id'] = $user->id;
        redirect_to($params['url']);
    } else {
        $user = new Guest;
        $flash = 'Login failed.';
    }
}
?>
