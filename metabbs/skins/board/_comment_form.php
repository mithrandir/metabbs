<table id="commentform">
<? if ($account->is_guest()) { ?>
<tr>
	<th><?=label_tag("Name", "comment", "name")?></th>
	<td><?=text_field("comment", "name", $name)?></td>
	<th><?=label_tag("Password", "comment", "password")?></th>
	<td><?=password_field("comment", "password")?></td>
</tr>
<? } ?>
<tr>
	<td colspan="4"><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></td>
</tr>
</table>
<p><?=submit_tag("Comment")?></p>
