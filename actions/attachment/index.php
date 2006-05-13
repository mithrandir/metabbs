<?php
$attachment = Attachment::find($id);
if (!$attachment->exists() || !$attachment->exist()) {
	$controller = 'notice';
	$action = 'attachment';
	return;
}
$filename = 'data/uploads/' .$attachment->id;
header('Content-Type: application/octet-stream');
header('Content-Length: ' . filesize($filename));
header('Content-Disposition: attachment; filename="' . $attachment->filename . '"');
header('Content-Transfer-Encoding: binary');
header('Pragma: no-cache');
header('Expires: 0');
readfile($filename);
exit;
?>
