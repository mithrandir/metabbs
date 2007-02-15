<?php
require 'lib/common.php';

$style = $board->get_style();
// TODO: set global header
$style->set('board', $board);
$style->set('account', $account);
include 'controller/'.$controller.'.php';
?>
