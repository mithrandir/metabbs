<h1>User Information</h1>
<div id="profile">
<p><span class="name"><?=$user->name?></span> (<?=htmlspecialchars($user->user)?>)</p>
<p>
<? if ($user->email) { ?>
E-mail: <a href="mailto:<?=htmlspecialchars($user->email)?>"><?=str_replace("@", " at ", htmlspecialchars($user->email))?></a><br />
<? } ?>
<? if ($user->url) { ?>
Homepage: <?=link_text(htmlspecialchars($user->get_url()))?><br />
<? } ?>
</p>
<p><?=$user->get_post_count()?> posts, <?=$user->get_comment_count()?> comments</p>
<? if ($user->signature) { ?>
<p id="signature"><?=format_plain($user->signature)?></p>
<? } ?>
<? if ($user->additional_info) { ?>
<div id="info">
<?=$user->additional_info?>
</div>
<? } ?>
</div>
