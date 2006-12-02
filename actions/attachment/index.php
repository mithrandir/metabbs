<?php
$attachment = Attachment::find($id);
if (!$attachment->exists() || !$attachment->file_exists()) {
	print_notice('Attachment not found', "Attachment #$id is not exist or broken.<br />Please check the attachment id.");
}
$filename = 'data/uploads/' .$attachment->id;
header('Content-Type: application/octet-stream');
header('Content-Length: ' . filesize($filename));
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
	$attachment->filename = urlencode($attachment->filename);
}
header('Content-Disposition: inline; filename="' . $attachment->filename . '"');
header('Content-Transfer-Encoding: binary');
header('Last-Modified: ' . meta_format_date_RFC822(filemtime($filename)));
$fp = fopen($filename, 'rb');
while (!feof($fp)) {
	echo fread($fp, 4096);
}
fclose($fp);
exit;
?>
