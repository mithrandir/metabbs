<h2><?=i('Boards')?></h2>

<table id="contents">
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
<tbody id="boards-body">
<? foreach ($boards as $board) { ?>
<? include('app/admin/views/board/_board.php'); ?>
<? } ?>
</tbody>
</table>
<form method="post" action="<?=url_admin_for('board', 'new')?>">
<?=form_token_field()?>
<h3><?=i('New Board')?></h3>
<dl>
	<dt><?=i('Name')?></dt>
	<dd><input type="text" name="name" value="<?=isset($params['name']) ? $params['name'] : ''?>" /></dd>
	
	<dt><?=i('Profile')?></dt>
	<dd>
		<select name="profile">
			<option value="board" <?=isset($params['profile']) && $params['profile'] == 'board' ? 'selected="selected"' : ''?>>일반 게시판</option>
			<option value="gallery" <?=isset($params['profile']) && $params['profile'] == 'gallery' ? 'selected="selected"' : ''?>>이미지 갤러리</option>
			<option value="blog" <?=isset($params['profile']) && $params['profile'] == 'blog' ? 'selected="selected"' : ''?>>블로그</option>
		</select>

		<small>옵션 모음을 적용합니다.</small>
	</dd>
</dl>
<p><input type="submit" value="<?=i('Create')?>" id="create-board" /></p>
</form>
