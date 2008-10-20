<?php
$trackback = Trackback::find($id);
permission_required('delete', $trackback);
$trackback->delete();

redirect_to(url_for($trackback->get_post()));
?>
