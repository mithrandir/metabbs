<?php
$description = 'adding per board header/footer field';
$conn->add_field('board', 'header', 'string', 255);
$conn->add_field('board', 'footer', 'string', 255);
?>
