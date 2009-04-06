<? if (!$already_reset) { ?>
<h2>암호를 초기화했습니다.</h2>
<p><?=htmlspecialchars($user->name)?><small>(<?=htmlspecialchars($user->user)?>)</small> 사용자의 암호를 초기화했습니다. 해당 사용자에게 다음 주소를 전달하여 새로운 암호를 입력할 수 있게 하십시오.</p>
<? } else { ?>
<h2>이미 암호 초기화 상태입니다.</h2>
<p><?=htmlspecialchars($user->name)?><small>(<?=htmlspecialchars($user->user)?>)</small> 사용자의 암호가 이미 초기화 되어 있습니다. 해당 사용자에게 다음 주소를 전달하여 새로운 암호를 입력할 수 있게 하십시오.</p>
<? } ?>
<p><a href="<?=htmlspecialchars($reset_url)?>" onclick="return false"><?=htmlspecialchars($reset_url)?></a></p>
<p><a href="<?=url_admin_for('user')?>">&laquo; 돌아가기</a></p>
