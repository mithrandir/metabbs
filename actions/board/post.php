<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include('actions/post/save.php');
} else {
	$post = new Post;
}
?>
