<?php /* Smarty version 2.6.6, created on 2005-01-17 17:41:59
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'header.tpl', 5, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<head>
	<title><?php echo $this->_tpl_vars['cfg']['title'];  if ($this->_tpl_vars['title']): ?> : <?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  endif; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
	<link rel="Stylesheet" href="<?php echo $this->_tpl_vars['tpl_dir']; ?>
/default.css" type="text/css" />
	<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="rss.php?bid=<?php echo $this->_tpl_vars['bid']; ?>
" />
</head>

<body>