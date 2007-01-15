<form method="post" action="?" onsubmit="return checkForm(this)">
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name", "comment", "name")?> <?=text_field("comment", "name", $name)?></p>
<p><?=label_tag("Password", "comment", "password")?> <?=password_field("comment", "password")?></p>
<? } ?>
<p><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></p>
<p><?=submit_tag("Comment")?></p>
</form>
