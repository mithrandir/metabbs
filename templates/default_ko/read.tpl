{include file="header.tpl" title=$article->subject}

{literal}
<script language="JavaScript" type="text/javascript">
<!--
function enlarge(filename, imgurl) {
	w = window.open(imgurl, '', 'width=50,height=50,resizable=1');
	w.document.write('<html><head><title>'+filename+'</title><body><a href="#" onclick="window.close()"><img src="'+imgurl+'" id="img" border="0"/></a></body></html>');
	w.document.body.style.margin = 0;
	img = w.document.getElementById('img');
	w.resizeTo(img.width>640?640:img.width, img.height>480?480:img.height);
}
//-->
</script>
{/literal}

<div id="rubybbs">

<h2><span class="left">{$article->subject|escape}</span>
<span id="article-info">글쓴이: {$article->name|escape}, {$article->date|date_format:"%Y-%m-%d %H:%M:%S"}</span></h2>
<div class="text">{$article->text|escape|nl2br|autolink}</div>

{if count($attachments)}
<div id="attachments">
<ul>
{foreach from=$attachments item=attachment}
	<li>{if $attachment->isImage()}<small>{$attachment->filename}</small><div class="img" onmouseover="this.className='img_hover'" onmouseout="this.className='img'" onclick="enlarge('{$attachment->filename}','uploads/{$attachment->getHash()}')"><img src="uploads/{$attachment->getHash()}" onload="this.style.marginTop = ((this.height<100)?(100-this.height)/2:0)+'px';" /></div>{else}<small>내려받기: </small><br /><a href="download.php?fileid={$attachment->fileid}">{$attachment->filename}</a>{/if}</li>
{/foreach}
</ul>
</div>
{/if}

{if count($comments)}
<h3>댓글</h3>

<ul id="comments">
{foreach from=$comments item=comment}
	<li><span class="cname">{$comment->name|escape}</span>, <span class="cdate">{$comment->date|date_format:"%Y-%m-%d %H:%M:%S"}</span><p class="ctext">{$comment->text|escape|nl2br}</p></li>
{/foreach}
</ul>
{/if}

<h3>댓글 달기</h3>
<form method="post" action="post_cmt.php?bid={$bid}&amp;id={$article->id}&amp;page={$page}" id="cmt-form">
	<p>이름: <input type="text" name="name" class="text" size="10" tabindex="1" value="{$cache_name}" /><span style="padding: 0 10px">암호: <input type="password" name="passwd" class="text" size="10" tabindex="2" /></span> <input type="submit" value="쓰기" class="submit" accesskey="s" tabindex="4" /></p>
	<textarea name="text" cols="50" rows="5" tabindex="3"></textarea>
</form>

<ul id="nav">
	<li><a href="index.php?bid={$bid}&amp;page={$page}">목록보기</a></li>
	<li><a href="post.php?bid={$bid}&amp;page={$page}">글쓰기</a></li>
	<li><a href="delete.php?bid={$bid}&amp;page={$page}&amp;id={$article->id}">지우기</a></li>
	<li><a href="post.php?bid={$bid}&amp;page={$page}&amp;id={$article->id}">고치기</a></li>
	<li><a href="admin.php">관리</a></li>
</ul>
</div>

{include file="footer.tpl"}
