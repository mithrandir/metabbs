<? $layout->title = htmlspecialchars(i('Edit Settings') . ' - ' . $board->get_title()); ?>
<ul id="edit-section" class="tabs">
	<?=link_list_tab("?tab=general", 'general', i('General'))?>
	<?=link_list_tab("?tab=permission", 'permission', i('Permission'))?>
	<?=link_list_tab("?tab=skin", 'skin', i('Appearance'))?>
<? if ($board->use_category) { ?>
	<?=link_list_tab("?tab=category", 'category', i('Category'))?>
<? } ?>
	<li>|</li>
	<?=link_list_tab(url_for_metabbs('board', null, array('board-name'=>$board->name)), 'preview', i('Preview').' &raquo;')?>
</ul>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>

<?php include($dispatcher->get_view_path('edit_'.$_GET['tab'])); ?>