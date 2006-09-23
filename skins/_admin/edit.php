<form method="post" action="?tab=<?=$_GET['tab']?>">
<ul id="edit-section" class="tabs">
	<?=link_list_tab("?tab=general", 'general', i('General'))?>
	<?=link_list_tab("?tab=permission", 'permission', i('Permission'))?>
	<?=link_list_tab("?tab=skin", 'skin', i('Skin'))?>
<? if ($board->use_category) { ?>
	<?=link_list_tab("?tab=category", 'cateogry', i('Category'))?>
<? } ?>
</ul>

<?php include('skins/_admin/edit_'.$_GET['tab'].'.php'); ?>

<? if ($_GET['tab'] != 'category') { ?>
<p><input type="submit" value="OK" /></p>
<? } ?>
</form>
