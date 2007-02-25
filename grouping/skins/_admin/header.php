<div id="meta-admin">
<h1><?=i('MetaBBS Administration')?></h1>
<div id="header">
<?=link_to(i('Boards'), 'admin')?> |
<?=link_to(i('Users'), 'admin', 'users')?> |
<?=link_to(i('Settings'), 'admin', 'settings')?> |
<?=link_to(i('Plugins'), 'admin', 'plugins')?> |
<?=link_to(i('Uninstall'), 'admin', 'uninstall')?> |
<? foreach ($__admin_menu as $item) echo $item . ' | '; ?>
<a href="<?=url_with_referer_for('account', 'logout')?>"><?=i('Logout')?> &raquo;</a></p>
</div>
<div id="body">
<? if (isset($flash)) { ?>
<div class="flash <?=$flash_class?>">
<p><?=$flash?></p>
</div>
<? } ?>
