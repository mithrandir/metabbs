<?php
$board->delete();
Flash::set('Board has been deleted.');
redirect_to(url_admin_for('board'));
?>
