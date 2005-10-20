{include file="header.tpl"}

{literal}
<script language="JavaScript" type="text/javascript">
<!--
function addFileField() {
	upload_list = document.getElementById('uploads');
	list_item = document.createElement("LI");
	file_field = document.createElement("INPUT");
	file_field.type = "file";
	file_field.name = "upload[]";
	file_field.size = 50;
	list_item.appendChild(file_field);
	upload_list.appendChild(list_item);
}
//-->
</script>
{/literal}

<div id="rubybbs">

<form method="post" action="post.php?bid={$bid}{if $id}&amp;id={$id}{/if}" enctype="multipart/form-data">
<table id="post">
<tr>
	<th>Name</th><td><input type="text" name="name" class="text" size="12" value="{$article->name}" /></td>
</tr>
<tr>
	<th>Password</th><td><input type="password" name="passwd" class="text" size="12" /></td>
</tr>
<tr>
	<th>Subject</th><td class="subject"><input type="text" name="subject" class="text" size="60" value="{$article->subject}" /></td>
</tr>
<tr>
	<td colspan="2">
		<textarea name="text" rows="15" cols="60">{$article->text}</textarea>
	</td>
</tr>
</table>

{if $cfg.use_attachment}
<h2><span class="left">Attachment</span><span id="article-info"><a href="#" onclick="addFileField()">Add File...</a></span></h2>
{if !isset($id)}
<ol id="uploads">
	<li><input type="file" name="upload[]" size="50" /></li>
</ol>
{else}
<ol id="uploads">
{foreach from=$article->getAttachments() item=attachment}
	<li>{$attachment->filename} <input type="checkbox" name="delete[]" id="delete{$attachment->fileid}" value="{$attachment->fileid}" class="checkbox" /><label for="delete{$attachment->fileid}">delete</label></li>
{/foreach}
</ol>
{/if}
{/if}

<input type="submit" value="{if isset($id)}Edit{else}Post{/if}" class="submit" accesskey="s" />
</form>

<ul id="nav">
	<li><a href="index.php?bid={$bid}&amp;page={$page}">list</a></li>
	<li><a href="post.php?bid={$bid}&amp;page={$page}">post</a></li>
{if isset($id)}
	<li><a href="{$article->getURL($page)}">return</a></li>
{/if}
	<li><a href="admin.php">admin</a></li>
</ul>
</div>

{include file="footer.tpl"}
