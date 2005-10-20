<?php /* Smarty version 2.6.6, created on 2005-01-22 08:39:37
         compiled from config.tpl */ ?>
<form method="post" action="admin.php?action=save_config&amp;bid=<?php echo $this->_tpl_vars['bid']; ?>
">
<table id="create">
<tr>
	<th>BBS Name</th><td><?php echo $this->_tpl_vars['bid']; ?>
</td>
</tr>
<tr>
	<th>Title</th><td><input type="text" name="title" size="50" value="<?php echo $this->_tpl_vars['cfg']['title']; ?>
" /></td>
</tr>
<tr>
	<th>Posts Per Page <span class="required">*</span></th><td><input type="text" name="factor" size="2" class="number" value="<?php echo $this->_tpl_vars['cfg']['factor']; ?>
" /></td>
</tr>
<tr>
	<th>Template <span class="required">*</span></th><td><select name="style"><?php if (count($_from = (array)$this->_tpl_vars['styles'])):
    foreach ($_from as $this->_tpl_vars['style']):
?><option value="<?php echo $this->_tpl_vars['style']; ?>
"<?php if ($this->_tpl_vars['style'] == $this->_tpl_vars['cfg']['style']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['style']; ?>
</option><?php endforeach; unset($_from); endif; ?></select></td></th>
</tr>
<tr>
	<th>Use Attachment</th><td><input type="checkbox" name="use_attachment" value="1" <?php if ($this->_tpl_vars['cfg']['use_attachment']): ?>checked="checked"<?php endif; ?>/></td>
</tr>
</table>
<div id="legend">
	<span class="left"><span class="required">*</span> required</span>
	<input type="submit" value="Save" class="right" />
</div>
</form>