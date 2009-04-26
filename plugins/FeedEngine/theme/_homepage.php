<? if ($account->url): ?>
<p>
	<label>대표 홈페이지</label>
	<?=$account->url?> 
	<a href="<?=url_for('feedengine','unset_homepage', array('url'=>urlencode($_SERVER['REQUEST_URI'])))?>">대표 홈페이지 삭제</a>
</p>
<? endif; ?>

<? $feeds = Feed::find_all_by_user($account); ?>
<? if (!empty($feeds)): ?>
<h3><?=i('Feed List')?></h3>
<ol>
<? foreach ($feeds as $feed): ?>
<?		$feed_user = FeedUser::find_by_user_and_feed($account, $feed); ?>
	<li>
	<a href="<?=$feed->link?>" title="<?=$feed->title?>"><?=$feed->title?></a>
	(<?=$feed->url?><?= $feed->is_owner($account) ? ', '.i('Owner'):''?>) -
	<a href="<?=url_for('feedengine','delete', array('id'=>$feed->id, 'url'=>urlencode($_SERVER['REQUEST_URI'])))?>" onclick="if (confirm('<?=i('Are you sure?')?>')) { var f = document.createElement('form');f.style.display = 'none';this.parentNode.appendChild(f);f.method = 'POST';f.action = this.href;f.submit();}return false;"><?=i('Delete')?></a>

	<? if ($feed->is_owner($account) && $feed->link != $account->url): ?>
		| <a href="<?=url_for('feedengine','set_homepage', array('id'=>$feed->id, 'url'=>urlencode($_SERVER['REQUEST_URI'])))?>" >대표 홈페이지 선정</a>
	<? endif; ?>
	
	<? if (!$feed->is_active()): ?>
		<? if (!$feed->is_owner($account)): ?>
			<? if ($feed_user->get_attribute('trackback-key')): ?>
	| <a href="<?=url_for('feedengine','unset_trackback_key', array('id'=>$feed->id, 'url'=>urlencode($_SERVER['REQUEST_URI'])))?>">트랙백 인증키 제거<a/>
			<? else: ?>
	| <a href="<?=url_for('feedengine','set_trackback_key', array('id'=>$feed->id, 'url'=>urlencode($_SERVER['REQUEST_URI'])))?>">트랙백 인증키 발급<a/>
			<? endif; ?>
		<? endif; ?>
	<? else: ?>
	<!-- 게시판 별로 피드 수집 링크 -->
	| <a href="<?=url_for('feedengine','collect', array('id'=>$feed->id, 'url'=>urlencode($_SERVER['REQUEST_URI'])))?>">피드 수집</a>	
	<? endif; ?>

	<? if (!$feed->is_active() && $feed_user->get_attribute('trackback-key')): ?>
		<br />트랙백 인증 주소 : <?=full_url_for('feedengine', 'owner', array('user'=>$account->id, 'id'=>$feed->id, 'key'=>$feed_user->get_attribute('trackback-key')))?>
	<? endif; ?>
	</li>
<? endforeach; ?>
</ol>
<? endif; ?>