<? if (isset($msg)) : ?>
<p class="flash"><?=$msg?></p>
<? endif; ?>

<? if ($account->url): ?>
<p>
	<label>대표 홈페이지</label>
	<?=$account->url?> <a href="<?=url_for('feedengine','account')?>unset_default?url=<?=urlencode($_SERVER['REQUEST_URI'])?>"  onclick="process_hompage(this.href); return false;">대표 홈페이지 삭제</a>
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
	(<a href="<?=$feed->url?>">Feed URL</a> <?= $feed->is_owner($account) ? '소유':''?>) -
	<a href="<?=url_for('feedengine','account')?>remove?feed_id=<?=$feed->id?>&url=<?=urlencode($_SERVER['REQUEST_URI'])?>" onclick="if (confirm('이 피드로 모았던 글들도 삭제됩니다.')) process_hompage(this.href); return false;" >삭제</a>

	<? if ($feed->is_active()): ?>
	| <a href="<?=url_for('feedengine','account')?>collect_feed?feed_id=<?=$feed->id?>&url=<?=urlencode($_SERVER['REQUEST_URI'])?>" onclick="process_hompage(this.href); return false;">피드 수집</a>
	<? else: ?>
		<? if (!$feed->is_owner($account)): ?>
			<? if ($feed_user->get_attribute('trackback-key')): ?>
			| <a href="<?=url_for('feedengine','account')?>unset_trackback_key?feed_id=<?=$feed->id?>&url=<?=urlencode($_SERVER['REQUEST_URI'])?>" onclick="process_hompage(this.href); return false;">트랙백 인증키 제거<a/>
			<? else: ?>
			| <a href="<?=url_for('feedengine','account')?>set_trackback_key?feed_id=<?=$feed->id?>&url=<?=urlencode($_SERVER['REQUEST_URI'])?>" onclick="process_hompage(this.href); return false;">트랙백 인증키 발급<a/>
			<? endif; ?>
		<? endif; ?>
	<? endif; ?>


	<? if ($feed->is_owner($account)): ?>
		<? if ($feed->link != $account->url): ?>
		| <a href="<?=url_for('feedengine','account')?>set_default?feed_id=<?=$feed->id?>&url=<?=urlencode($_SERVER['REQUEST_URI'])?>" onclick="process_hompage(this.href); return false;">대표 홈페이지 선정</a>
		<? endif; ?>
	<? endif; ?>

	<? if (!$feed->is_active()): ?>
		<? if ($feed_user->get_attribute('trackback-key')): ?>
		<br />트랙백 인증 주소 : <?=full_url_for('feedengine', 'feed').'owner?user='.$account->id.'&feed='.$feed->id.'&key='.$feed_user->get_attribute('trackback-key')?>
		<? endif; ?>
	<? endif; ?>
	</li>
<? endforeach; ?>
</ol>
<? endif; ?>