<?php
$attachment = Attachment::find($id);
$board = $attachment->get_board();
?>
