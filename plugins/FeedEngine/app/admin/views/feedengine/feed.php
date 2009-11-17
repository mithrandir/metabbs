<? include '_menu.php' ?>

<table>
<tr>
	<th><?=i('URL')?></th>
	<th><?=i('Users')?></th>
	<th><?=i('Owner')?></th>
	<th><?=i('Owner Name')?></th>
	<th><?=i('Status')?></th>
	<th><?=i('Actions')?></th>
</tr>
<?php foreach ($feeds as $feed) { 
	$users = $feed->get_users();
	if(count($users) > 0)
		$first_user = $users[0];
	else
		$first_user = New Guest();
	$owner = User::find($feed->owner_id); ?>
<tr>
	<td><a href="<?=$feed->link?>" title="<?=$feed->title?>"><?=$feed->link?></a> - <a href="<?=$feed->url?>">Feed URL</a></td>
	<td><?= $first_user->exists() ? $first_user->name . "($first_user->user)" . ($feed->get_user_count() > 1 ? '외 ' . $feed->get_user_count() . '명':''): '' ?></td>
	<td><?=$owner->exists() ? $owner->name:''?><span id="owner-<?=$feed->id?>"></span></td>
	<td><?=$feed->owner_name ?><span id="owner-name-<?=$feed->id?>"></span></td>
	<td><?=link_admin_to($feed->is_active() ? i('Active') : i('Unactive'), 'feedengine', 'feed', array('active'=>$feed->id)) ?>
	</td>
	<td><a href="<?=url_admin_for('feedengine','feed', array('owner'=>$feed->id))?>" onclick="edit('owner-<?=$feed->id?>', this.href); return false"><?=i('Owner')?></a>
	| <a href="<?=url_admin_for('feedengine','feed', array('owner-name'=>$feed->id))?>" onclick="edit('owner-name-<?=$feed->id?>', this.href); return false"><?=i('Owner Name')?></a>
	| <?=link_admin_with_dialog_by_post_to(i('Delete'), 'feedengine', 'feed', array('delete' => $feed->id))?>
</tr>
<?php } ?>
</table>

<h3><?=i('Add')?></h3>
<form method="post" action="?tab=feed" enctype="multipart/form-data">
<dl>
	<dt><label><?=i('User ID')?></label></dt>
	<dd><input type="text" name="userid" size="30" />
	<input type="checkbox" name="as_owner" value="1"/> As Owner</dd>
</dl>
<dl>
	<dt><label><?=i('Feed URL')?></label></dt>
	<dd><input type="text" name="feed_url" size="50" /></dd>
</dl>
<p><input type="submit" value="Add" /></p>
</form>