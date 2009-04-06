<?
$user = User::find(params['id']);
$user->delete();
redirect_to(url_admin_for('user', null, array('page' => $_GET['page'])));
?>
