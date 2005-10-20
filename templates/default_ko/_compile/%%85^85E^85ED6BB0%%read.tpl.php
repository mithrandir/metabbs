<?php /* Smarty version 2.6.6, created on 2005-01-22 10:15:35
         compiled from read.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'read.tpl', 19, false),array('modifier', 'date_format', 'read.tpl', 20, false),array('modifier', 'nl2br', 'read.tpl', 21, false),array('modifier', 'autolink', 'read.tpl', 21, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['article']->subject)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script language="JavaScript" type="text/javascript">
<!--
function enlarge(filename, imgurl) {
	w = window.open(imgurl, \'\', \'width=50,height=50,resizable=1\');
	w.document.write(\'<html><head><title>\'+filename+\'</title><body><a href="#" onclick="window.close()"><img src="\'+imgurl+\'" id="img" border="0"/></a></body></html>\');
	w.document.body.style.margin = 0;
	img = w.document.getElementById(\'img\');
	w.resizeTo(img.width>640?640:img.width, img.height>480?480:img.height);
}
//-->
</script>
'; ?>


<div id="rubybbs">

<h2><span class="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['article']->subject)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>
<span id="article-info">글쓴이: <?php echo ((is_array($_tmp=$this->_tpl_vars['article']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
, <?php echo ((is_array($_tmp=$this->_tpl_vars['article']->date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</span></h2>
<div class="text"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['article']->text)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('autolink', true, $_tmp) : smarty_modifier_autolink($_tmp)); ?>
</div>

<?php if (count ( $this->_tpl_vars['attachments'] )): ?>
<div id="attachments">
<ul>
<?php if (count($_from = (array)$this->_tpl_vars['attachments'])):
    foreach ($_from as $this->_tpl_vars['attachment']):
?>
	<li><?php if ($this->_tpl_vars['attachment']->isImage()): ?><small><?php echo $this->_tpl_vars['attachment']->filename; ?>
</small><div class="img" onmouseover="this.className='img_hover'" onmouseout="this.className='img'" onclick="enlarge('<?php echo $this->_tpl_vars['attachment']->filename; ?>
','uploads/<?php echo $this->_tpl_vars['attachment']->getHash(); ?>
')"><img src="uploads/<?php echo $this->_tpl_vars['attachment']->getHash(); ?>
" onload="this.style.marginTop = ((this.height<100)?(100-this.height)/2:0)+'px';" /></div><?php else: ?><small>내려받기: </small><br /><a href="download.php?fileid=<?php echo $this->_tpl_vars['attachment']->fileid; ?>
"><?php echo $this->_tpl_vars['attachment']->filename; ?>
</a><?php endif; ?></li>
<?php endforeach; unset($_from); endif; ?>
</ul>
</div>
<?php endif; ?>

<?php if (count ( $this->_tpl_vars['comments'] )): ?>
<h3>댓글</h3>

<ul id="comments">
<?php if (count($_from = (array)$this->_tpl_vars['comments'])):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
	<li><span class="cname"><?php echo ((is_array($_tmp=$this->_tpl_vars['comment']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>, <span class="cdate"><?php echo ((is_array($_tmp=$this->_tpl_vars['comment']->date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</span><p class="ctext"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['comment']->text)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p></li>
<?php endforeach; unset($_from); endif; ?>
</ul>
<?php endif; ?>

<h3>댓글 달기</h3>
<form method="post" action="post_cmt.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;id=<?php echo $this->_tpl_vars['article']->id; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
" id="cmt-form">
	<p>이름: <input type="text" name="name" class="text" size="10" tabindex="1" value="<?php echo $this->_tpl_vars['cache_name']; ?>
" /><span style="padding: 0 10px">암호: <input type="password" name="passwd" class="text" size="10" tabindex="2" /></span> <input type="submit" value="쓰기" class="submit" accesskey="s" tabindex="4" /></p>
	<textarea name="text" cols="50" rows="5" tabindex="3"></textarea>
</form>

<ul id="nav">
	<li><a href="index.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
">목록보기</a></li>
	<li><a href="post.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
">글쓰기</a></li>
	<li><a href="delete.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
&amp;id=<?php echo $this->_tpl_vars['article']->id; ?>
">지우기</a></li>
	<li><a href="post.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
&amp;id=<?php echo $this->_tpl_vars['article']->id; ?>
">고치기</a></li>
	<li><a href="admin.php">관리</a></li>
</ul>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>