<ul id="edit-section" class="tabs">
	<?=link_list_tab("?tab=general", 'general', i('General'))?>
	<?=link_list_tab("?tab=permission", 'permission', i('Permission'))?>
	<?=link_list_tab("?tab=skin", 'skin', i('Skin'))?>
<? if ($board->use_category) { ?>
	<?=link_list_tab("?tab=category", 'category', i('Category'))?>
<? } ?>
	<li>|</li>
	<?=link_list_tab(url_for($board), 'preview', i('Preview').' &raquo;')?>
</ul>

<?php include('skins/_admin/edit_'.$_GET['tab'].'.php'); ?>
