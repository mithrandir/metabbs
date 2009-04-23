<?php
login_required();

if (is_post()) {
	$openid = Openid::find($params['id']);
	if ($openid->exists()) {
		$openid->delete();
	} else
		Flash::set('Verification cancelled');

	redirect_back();
}
?>