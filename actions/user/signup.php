<?php
if (is_post()) {
    $user = new User($params['user']);
    $user->password = md5($user->password);
    if ($user->valid()) {
        $user->save();
        redirect_to($params['url']);
    } else {
        $guest = new Guest;
        $guest->name = $user->name;
        $guest->email = $user->email;
        $guest->url = $user->url;
        $user = $guest;
        $flash = "User ID already exists.";
    }
}
?>
