<?php /* Smarty version 2.6.6, created on 2005-01-08 13:15:42
         compiled from list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'list.tpl', 15, false),array('modifier', 'truncate', 'list.tpl', 16, false),array('modifier', 'date_format', 'list.tpl', 17, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="rubybbs">
<div id="info">
	Total <?php echo $this->_tpl_vars['total']; ?>
 article<?php if ($this->_tpl_vars['total'] > 1): ?>s<?php endif; ?>. <a href="rss.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
"><img src="<?php echo $this->_tpl_vars['tpl_dir']; ?>
/rss.png" width="16" height="16" style="border: 0; vertical-align: middle" alt="RSS" /></a>
</div>
<table id="list">
<tr class="header">
	<th class="name">Name</th>
	<th class="subject">Subject</th>
	<th class="date">Date</th>
</tr>
<?php if (count($_from = (array)$this->_tpl_vars['list'])):
    foreach ($_from as $this->_tpl_vars['article']):
?>
<tr>
	<td class="name"><?php echo ((is_array($_tmp=$this->_tpl_vars['article']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
	<td class="subject"><a href="<?php echo $this->_tpl_vars['article']->getURL($this->_tpl_vars['page']); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['article']->subject)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 45) : smarty_modifier_truncate($_tmp, 45)); ?>
</a><?php if ($this->_tpl_vars['article']->total_cmts > 0): ?><span class="total-comments">[<?php echo $this->_tpl_vars['article']->getTotalComments(); ?>
]</span><?php endif; ?></td>
	<td class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['article']->date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
</tr>
<?php endforeach; unset($_from); endif; ?>
</table>

<ul id="page-list">
<?php if ($this->_tpl_vars['prev']): ?>
	<li class="prev"><a href="index.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['prev']; ?>
">prev</a></li>
<?php endif; ?>
<?php if (count($_from = (array)$this->_tpl_vars['pages'])):
    foreach ($_from as $this->_tpl_vars['p']):
?>
<?php if ($this->_tpl_vars['p'] == $this->_tpl_vars['page']): ?>
	<li class="page-current"><?php echo $this->_tpl_vars['p']; ?>
</li>
<?php else: ?>
	<li class="page"><a href="index.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['p']; ?>
"><?php echo $this->_tpl_vars['p']; ?>
</a></li>
<?php endif; ?>
<?php endforeach; unset($_from); endif; ?>
<?php if ($this->_tpl_vars['next'] <= $this->_tpl_vars['total_pages']): ?>
	<li class="next"><a href="index.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['next']; ?>
">next</a></li>
<?php endif; ?>
</ul>

<ul id="nav">
	<li><a href="index.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
">list</a></li>
	<li><a href="post.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
">post</a></li>
	<li><a href="admin.php">admin</a></li>
</ul>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>