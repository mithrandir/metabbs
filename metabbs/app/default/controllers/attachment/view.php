<?php 
if (isset($_GET['thumb'])) {
	permission_required('thumbnail', Post::find($attachment->post_id));
	$filename = $attachment->create_thumbnail(true);
	if (!$filename) {
		header('HTTP/1.1 404 Not Found');
		print_notice(i('Attachment is not Image'), i("Attachment #%d is not Image.", $params['id']));
	}
} else {
	permission_required('attachment', Post::find($attachment->post_id));
	$filename = 'data/uploads/' .$attachment->id;
}
header('Content-Type: ' . $attachment->get_content_type());
header('Content-Length: ' . filesize($filename));
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
	$attachment->filename = urlencode($attachment->filename);
}
header('Content-Disposition: inline; filename="' . $attachment->filename . '"');
header('Content-Transfer-Encoding: binary');
header('Last-Modified: ' . meta_format_date_RFC822(filemtime($filename)));
$fp = fopen($filename, 'rb');
fpassthru($fp);
fclose($fp);
exit;
?>
