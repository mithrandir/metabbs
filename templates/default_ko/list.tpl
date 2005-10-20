{include file="header.tpl"}

<div id="rubybbs">
<div id="info">
	모두 {$total}개의 글이 있습니다. <a href="rss.php?bid={$bid}"><img src="{$tpl_dir}/rss.png" width="16" height="16" style="border: 0; vertical-align: middle" alt="RSS" /></a>
</div>
<table id="list">
<tr class="header">
	<th class="name">글쓴이</th>
	<th class="subject">제목</th>
	<th class="date">날짜</th>
</tr>
{foreach from=$list item=article}
<tr>
	<td class="name">{$article->name|escape}</td>
	<td class="subject"><a href="{$article->getURL($page)}">{$article->subject|escape|truncate:45}</a>{if $article->total_cmts > 0}<span class="total-comments">[{$article->getTotalComments()}]</span>{/if}</td>
	<td class="date">{$article->date|date_format:"%Y-%m-%d %H:%M:%S"}</td>
</tr>
{/foreach}
</table>

<ul id="page-list">
{if $prev}
	<li class="prev"><a href="index.php?bid={$bid}&amp;page={$prev}">이전 쪽</a></li>
{/if}
{foreach from=$pages item=p}
{if $p==$page}
	<li class="page-current">{$p}</li>
{else}
	<li class="page"><a href="index.php?bid={$bid}&amp;page={$p}">{$p}</a></li>
{/if}
{/foreach}
{if $next <= $total_pages}
	<li class="next"><a href="index.php?bid={$bid}&amp;page={$next}">다음 쪽</a></li>
{/if}
</ul>

<ul id="nav">
	<li><a href="index.php?bid={$bid}&amp;page={$page}">목록보기</a></li>
	<li><a href="post.php?bid={$bid}&amp;page={$page}">글쓰기</a></li>
	<li><a href="admin.php">관리</a></li>
</ul>
</div>

{include file="footer.tpl"}
