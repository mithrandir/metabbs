<?php
$conn->rename_table('boards', 'board');
$conn->rename_table('users', 'user');
$conn->rename_table('posts', 'post');
$conn->rename_table('attachments', 'attachment');
$conn->rename_table('comments', 'comment');
$conn->rename_table('trackbacks', 'trackback');
?>
