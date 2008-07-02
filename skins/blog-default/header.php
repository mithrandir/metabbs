<div id="blog-title">
	<a href="<?=blog_url($board)?>"><?=htmlspecialchars($board->get_title())?></a>
	<a href="<?=$link_rss?>"><img src="<?=$skin_dir?>/feed.png" alt="RSS Feed" /></a>
</div>

<div id="account-info">
<? if ($account->has_perm('write', $board)): ?>
<a href="<?=url_for($board, 'post')?>"><strong>글쓰기</strong></a>
<? endif; ?>
<? if ($guest): ?>
<a href="<?=$link_login?>" class="dialog">로그인</a>
<? else: ?>
<a href="<?=$link_logout?>">로그아웃</a>
<? if ($link_admin): ?><a href="<?=$link_admin?>">관리자 페이지</a><? endif; ?>
<? endif; ?>
</div>

<div id="blog-content">
