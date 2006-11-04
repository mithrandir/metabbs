<?php
$trackback = new Trackback($_POST);
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<response>\n";
// TODO: spam filtering
$url = parse_url($trackback->url);
if ($url['path'] == '/') {
	$trackback->valid = false;
}
apply_filters('PostTrackback', $trackback);
if (is_post() && $trackback->validate()) {
	$post->add_trackback($trackback);
	echo "<error>0</error>\n";
} else {
	echo "<error>1</error>\n";
	echo "<message>Unable to create trackback</message>\n";
}
echo '</response>';

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
