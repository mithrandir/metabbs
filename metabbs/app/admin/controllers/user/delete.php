<?
if (is_post()) {
	$user = User::find($params['id']);
	$user->delete();
	Flash::set(i('User has been deleted'));
	redirect_back();
}
?>
