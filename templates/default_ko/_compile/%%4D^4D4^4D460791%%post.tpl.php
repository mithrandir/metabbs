<?php /* Smarty version 2.6.6, created on 2005-01-22 08:47:44
         compiled from post.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script language="JavaScript" type="text/javascript">
<!--
function addFileField() {
	upload_list = document.getElementById(\'uploads\');
	list_item = document.createElement("LI");
	file_field = document.createElement("INPUT");
	file_field.type = "file";
	file_field.name = "upload[]";
	file_field.size = 50;
	list_item.appendChild(file_field);
	upload_list.appendChild(list_item);
}
//-->
</script>
'; ?>


<div id="rubybbs">

<form method="post" action="post.php?bid=<?php echo $this->_tpl_vars['bid'];  if ($this->_tpl_vars['id']): ?>&amp;id=<?php echo $this->_tpl_vars['id'];  endif; ?>" enctype="multipart/form-data">
<table id="post">
<tr>
	<th>이름</th><td><input type="text" name="name" class="text" size="12" value="<?php echo $this->_tpl_vars['article']->name; ?>
" /></td>
</tr>
<tr>
	<th>암호</th><td><input type="password" name="passwd" class="text" size="12" /></td>
</tr>
<tr>
	<th>제목</th><td class="subject"><input type="text" name="subject" class="text" size="60" value="<?php echo $this->_tpl_vars['article']->subject; ?>
" /></td>
</tr>
<tr>
	<td colspan="2">
		<textarea name="text" rows="15" cols="60"><?php echo $this->_tpl_vars['article']->text; ?>
</textarea>
	</td>
</tr>
</table>

<?php if ($this->_tpl_vars['cfg']['use_attachment']): ?>
<h2><span class="left">Attachment</span><span id="article-info"><a href="#" onclick="addFileField()">Add File...</a></span></h2>
<?php if (! isset ( $this->_tpl_vars['id'] )): ?>
<ol id="uploads">
	<li><input type="file" name="upload[]" size="50" /></li>
</ol>
<?php else: ?>
<ol id="uploads">
<?php if (count($_from = (array)$this->_tpl_vars['article']->getAttachments())):
    foreach ($_from as $this->_tpl_vars['attachment']):
?>
	<li><?php echo $this->_tpl_vars['attachment']->filename; ?>
 <input type="checkbox" name="delete[]" id="delete<?php echo $this->_tpl_vars['attachment']->fileid; ?>
" value="<?php echo $this->_tpl_vars['attachment']->fileid; ?>
" class="checkbox" /><label for="delete<?php echo $this->_tpl_vars['attachment']->fileid; ?>
">delete</label></li>
<?php endforeach; unset($_from); endif; ?>
</ol>
<?php endif; ?>
<?php endif; ?>

<input type="submit" value="쓰기" class="submit" accesskey="s" />
</form>

<ul id="nav">
	<li><a href="index.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
">목록보기</a></li>
	<li><a href="post.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
&amp;page=<?php echo $this->_tpl_vars['page']; ?>
">글쓰기</a></li>
<?php if (isset ( $this->_tpl_vars['id'] )): ?>
	<li><a href="<?php echo $this->_tpl_vars['article']->getURL($this->_tpl_vars['page']); ?>
">돌아가기</a></li>
<?php endif; ?>
	<li><a href="admin.php">관리</a></li>
</ul>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>