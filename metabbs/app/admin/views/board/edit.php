<? $layout->title = htmlspecialchars(i('Edit Settings') . ' - ' . $board->get_title()); ?>
<ul id="edit-section" class="tabs">
	<?=link_list_tab("?tab=general", 'general', i('General'))?>
	<?=link_list_tab("?tab=permission", 'permission', i('Permission'))?>
	<?=link_list_tab("?tab=skin", 'skin', i('Appearance'))?>
<? if ($board->use_category) { ?>
	<?=link_list_tab("?tab=category", 'category', i('Category'))?>
<? } ?>
	<?=link_list_tab("?tab=thumbnail", 'thumbnail', i('Thumbnail'))?>
	<li>|</li>
	<?=link_list_tab(url_for($board), 'preview', i('Preview').' &raquo;')?>
</ul>

<p><?=i('Board URL')?>: <a href="<?=full_url_for($board)?>" onclick="return false"><?=full_url_for($board)?></a></p>

<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<?php include('app/admin/views/board/edit_'.$_GET['tab'].'.php'); ?>
