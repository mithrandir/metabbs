<?php
$trackback = new Trackback($_POST);
$trackback->post_id = $post->id;
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<response>\n";
// TODO: spam filtering
$url = parse_url($trackback->url);
if ($url['path'] == '/') {
	exit;
}
if (is_post() && $trackback->validate()) {
	$trackback->create();
	echo "<error>0</error>\n";
} else {
	echo "<error>1</error>\n";
	echo "<message>Unable to create trackback</message>\n";
}
echo '</response>';
?>
