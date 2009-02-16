<?php
list($id) = explode('_', $id, 2);
$attachment = Attachment::find($id);
if (!$attachment->exists() || !$attachment->file_exists()) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('Attachment not found'), i("Attachment #%d doesn't exist.", $id));
}
permission_required('read', Post::find($attachment->post_id));
if (isset($_GET['thumb'])) {
	include 'core/thumbnail.php';
	$orig_path = 'data/uploads/'.$attachment->id;
	$ext = get_image_extension($orig_path);
	$thumb_path = 'data/thumb/'.$attachment->id.'-small.'.$ext;

	if (create_thumbnail($orig_path, $thumb_path, $attachment->get_kind(), $attachment->get_options())) {
		chmod($thumb_path, 0606);
		redirect_to(METABBS_BASE_PATH.$thumb_path);
	}
}
$filename = 'data/uploads/' .$attachment->id;
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
