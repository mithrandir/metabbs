<?php
$attachment = Attachment::find($id);
if (!$attachment->exists() || !$attachment->file_exists()) {
	print_notice('Attachment not found', "Attachment #$id is not exist or broken.<br />Please check the attachment id.");
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
