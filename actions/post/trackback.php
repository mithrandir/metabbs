<?php
$trackback = new Trackback($_POST);
$trackback->post_id = $post->id;
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<response>';
if ($trackback->save()) {
    echo '<error>0</error>';
} else {
    echo '<error>1</error>';
    echo '<message>Unable to create trackback</message>';
}
echo '</response>';
exit;
?>