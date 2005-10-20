<?php /* Smarty version 2.6.6, created on 2004-12-30 11:14:42
         compiled from list.tpl */ ?>
<ul>
<?php if (count($_from = (array)$this->_tpl_vars['list'])):
    foreach ($_from as $this->_tpl_vars['bbs']):
?>
	<li><?php echo $this->_tpl_vars['bbs']->bid; ?>
 (<?php echo $this->_tpl_vars['bbs']->getTotal(); ?>
) <a href="index.php?bid=<?php echo $this->_tpl_vars['bbs']->bid; ?>
" target="_blank">[view]</a> <a href="admin.php?action=config&amp;bid=<?php echo $this->_tpl_vars['bbs']->bid; ?>
">[config]</a> <a href="admin.php?action=drop&amp;bid=<?php echo $this->_tpl_vars['bbs']->bid; ?>
" onclick="return window.confirm('Do you really want to drop \'<?php echo $this->_tpl_vars['bbs']->bid; ?>
\'?')">[drop]</a></li>
<?php endforeach; unset($_from); endif; ?>
</ul>