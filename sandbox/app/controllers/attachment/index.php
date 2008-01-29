<?php
list($id) = explode('_', $id, 2);
$attachment = Attachment::find($id);
if (!$attachment->exists() || !$attachment->file_exists()) {
	print_notice('Attachment not found', "Attachment #$id is not exist or broken.<br />Please check the attachment id.");
}
permission_required('read', Post::find($attachment->post_id));
if (isset($_GET['thumb'])) {
	include 'lib/thumbnail.php';
	$orig_path = 'data/uploads/'.$attachment->id;
	$ext = get_image_extension($orig_path);
	$thumb_path = 'data/thumb/'.$attachment->id.'-small.'.$ext;
	if (create_thumbnail($orig_path, $thumb_path)) {
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
