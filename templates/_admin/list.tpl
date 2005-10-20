<ul>
{foreach from=$list item=bbs}
	<li>{$bbs->bid} ({$bbs->getTotal()}) <a href="index.php?bid={$bbs->bid}" target="_blank">[view]</a> <a href="admin.php?action=config&amp;bid={$bbs->bid}">[config]</a> <a href="admin.php?action=drop&amp;bid={$bbs->bid}" onclick="return window.confirm('Do you really want to drop \'{$bbs->bid}\'?')">[drop]</a></li>
{/foreach}
</ul>
