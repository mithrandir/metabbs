<?php
$posts = $user->get_posts((get_requested_page() - 1) * 10, 10);

render('user');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
