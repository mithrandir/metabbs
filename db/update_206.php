<?php
$conn->rename_table('boards', 'board');
$conn->rename_table('users', 'user');
$conn->rename_table('posts', 'post');
$conn->rename_table('attachments', 'attachment');
$conn->rename_table('comments', 'comment');
$conn->rename_table('trackbacks', 'trackback');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
