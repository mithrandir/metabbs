<form method="post" action="?">
<h2><?=i('Rename')?></h2>
<p><?=$category->name?> &rarr; <input type="text" name="new_name" size="10" /></p>
<p><?=submit_tag('Rename')?></p>
</form>
