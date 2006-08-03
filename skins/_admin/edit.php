<form method="post">
<style type="text/css">
#tab-<?=$_GET['tab']?> { font-weight: bold; }
</style>
<ul id="edit-section">
    <li id="tab-general"><a href="?tab=general"><?=i('General')?></a></li>
    <li id="tab-permission"><a href="?tab=permission"><?=i('Permission')?></a></li>
    <li id="tab-skin"><a href="?tab=skin"><?=i('Skin')?></a></li>
<? if ($board->use_category) { ?>
    <li id="tab-category"><a href="?tab=category"><?=i('Category')?></a></li>
<? } ?>
</ul>

<?php include('skins/_admin/edit_'.$_GET['tab'].'.php'); ?>

<? if ($_GET['tab'] != 'category') { ?>
<p><input type="submit" value="OK" /></p>
<? } ?>
</form>
