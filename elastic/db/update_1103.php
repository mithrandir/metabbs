<?php
$conn->rename_table('post_meta', 'metadata');
$conn->change_field('metadata', 'post_id', 'model_id', 'integer');
$conn->add_field('metadata', 'model', 'string', 20);
update_all('metadata', array('model' => 'post'));
?>
