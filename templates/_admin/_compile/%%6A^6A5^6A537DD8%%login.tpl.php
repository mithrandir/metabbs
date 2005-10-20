<?php /* Smarty version 2.6.6, created on 2005-01-15 07:27:00
         compiled from login.tpl */ ?>
<form method="post" action="admin.php">
<?php if ($this->_tpl_vars['changed'] == 1): ?>
<p>password changed</p>
<?php endif; ?>
Password: <input type="password" name="passwd" /> <input type="submit" value="Login" />
</form>