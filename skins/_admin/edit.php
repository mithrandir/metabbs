<form method="post">
<ul id="edit-section" class="tabs">
    <li id="tab-general"<?=$_GET['tab']=='general'?' class="selected"':''?>><a href="?tab=general"><?=i('General')?></a></li>
    <li id="tab-permission"<?=$_GET['tab']=='permission'?' class="selected"':''?>><a href="?tab=permission"><?=i('Permission')?></a></li>
    <li id="tab-skin"<?=$_GET['tab']=='skin'?' class="selected"':''?>><a href="?tab=skin"><?=i('Skin')?></a></li>
<? if ($board->use_category) { ?>
    <li id="tab-category"<?=$_GET['tab']=='category'?' class="selected"':''?>><a href="?tab=category"><?=i('Category')?></a></li>
<? } ?>
</ul>

<?php include('skins/_admin/edit_'.$_GET['tab'].'.php'); ?>

<? if ($_GET['tab'] != 'category') { ?>
<p><input type="submit" value="OK" /></p>
<? } ?>
</form>
