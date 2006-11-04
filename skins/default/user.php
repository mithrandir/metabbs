<h1>User Information</h1>
<div id="profile">
<p><span class="name"><?=$user->name?></span> (<?=$user->user?>)</p>
<p>
<? if ($user->email) { ?>
E-mail: <a href="mailto:<?=$user->email?>"><?=str_replace("@", " at ", $user->email)?></a><br />
<? } ?>
<? if ($user->url) { ?>
Homepage: <?=link_text($user->get_url())?><br />
<? } ?>
</p>
<p><?=$user->get_post_count()?> posts, <?=$user->get_comment_count()?> comments</p>
<? if ($user->signature) { ?>
<p id="signature"><?=format($user->signature)?></p>
<? } ?>
</div>
