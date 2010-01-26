<h1>받은 쪽지 목록</h1>
<ul>
<?php foreach ($messages as $message) { ?>
	<li>
		<? if ($message->from) { ?><?=link_to_user($message->get_sender())?>, <? } ?><?=date("Y-m-d H:i:s", $message->sent_at)?>
		<? if (!$message->read) { ?>/ <a href="<?=url_for($message, 'read')?>">Mark as read</a><? } ?>
		/ <a href="<?=url_for($message, 'delete')?>" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a>
		/ <a href="<?=url_for($message->get_sender(), 'send-message')?>" class="dialog">Reply</a>
		<div class="message-body">
		<?=format_plain($message->body)?>
		</div>
	</li>
<?php } ?>
</ul>
<p><a href="<?=METABBS_BASE_URI?>message/all/delete" onclick="return confirm('<?=i('Are you sure?')?>')"><?=i('Delete All')?></a></p>
