<?php
redirect_to(url_for($comment->get_post()) . '#comment_' . $comment->id);
?>
