<?php /* Smarty version 2.6.6, created on 2005-02-04 21:01:23
         compiled from create.tpl */ ?>
<form method="post" action="admin.php?action=create">
<table id="create">
<tr>
	<th>BBS Name <span class="required">*</span></th><td><input type="text" name="bid" size="20" /></td>
</tr>
<tr>
	<th>Title</th><td><input type="text" name="title" size="50" value="RubyBBS" /></td>
</tr>
<tr>
	<th>Posts Per Page <span class="required">*</span></th><td><input type="text" name="factor" size="2" class="number" value="15" /></td>
</tr>
<tr>
	<th>Template <span class="required">*</span></th><td><select name="style"><?php if (count($_from = (array)$this->_tpl_vars['styles'])):
    foreach ($_from as $this->_tpl_vars['style']):
?><option value="<?php echo $this->_tpl_vars['style']; ?>
"><?php echo $this->_tpl_vars['style']; ?>
</option><?php endforeach; unset($_from); endif; ?></select></td></th>
</tr>
<tr>
	<th>Use Attachment</th><td><input type="checkbox" name="use_attachment" value="1" /></td>
</tr>
</table>
<div id="legend">
	<span class="left"><span class="required">*</span> required</span>
	<input type="submit" value="Create" class="right" />
</div>
</form>