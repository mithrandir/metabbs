<h1>사용자 정보</h1>
<div id="profile">
<p><span class="name"><?=$user->name?></span> (<?=htmlspecialchars($user->user)?>)</p>
<? if ($user->signature): ?>
<div id="signature"><?=format_plain($user->signature)?></div>
<? endif; ?>

<? if ($user->email): ?>
<p class="email"><?=i('E-Mail Address')?>: <?=str_replace("@", " at ", htmlspecialchars($user->email))?></p>
<? endif; ?>

<? if ($user->url): ?>
<p class="homepage"><?=i('Homepage')?>: <?=link_text(htmlspecialchars($user->get_url()))?></p>
<? endif; ?>

<p>글 <?=$user->get_post_count()?>개, 댓글 <?=$user->get_comment_count()?>개 씀</p>

<? if ($user->additional_info): ?>
<div id="info">
<?=$user->additional_info?>
</div>
<? endif; ?>

</div>
