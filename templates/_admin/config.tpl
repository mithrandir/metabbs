<form method="post" action="admin.php?action=save_config&amp;bid={$bid}">
<table id="create">
<tr>
	<th>BBS Name</th><td>{$bid}</td>
</tr>
<tr>
	<th>Title</th><td><input type="text" name="title" size="50" value="{$cfg.title}" /></td>
</tr>
<tr>
	<th>Posts Per Page <span class="required">*</span></th><td><input type="text" name="factor" size="2" class="number" value="{$cfg.factor}" /></td>
</tr>
<tr>
	<th>Template <span class="required">*</span></th><td><select name="style">{foreach from=$styles item=style}<option value="{$style}"{if $style==$cfg.style} selected{/if}>{$style}</option>{/foreach}</select></td></th>
</tr>
<tr>
	<th>Use Attachment</th><td><input type="checkbox" name="use_attachment" value="1" {if $cfg.use_attachment}checked="checked"{/if}/></td>
</tr>
</table>
<div id="legend">
	<span class="left"><span class="required">*</span> required</span>
	<input type="submit" value="Save" class="right" />
</div>
</form>
