<form method="post" style="line-height: 1.5">
<? foreach ($_POST['posts'] as $id) { ?>
<input type="hidden" name="posts[]" value="<?=$id?>" />
<? } ?>

<h2>글 관리</h2>
<h3>선택한 글</h3>
<ul>
<? foreach ($_POST['posts'] as $id) { $p = Post::find($id); ?>
	<li><?=htmlspecialchars($p->title)?></li>
<? } ?>
</ul>

<h3>동작</h3>
<p><input type="radio" name="action" value="hide" checked="checked" id="hide_box" /> <label for="hide_box">비밀글로 바꾸기</label></p>

<p><input type="radio" name="action" value="show" id="show_box" /> <label for="show_box">비밀글 풀기</label></p>

<p><input type="radio" name="action" value="delete" id="delete_box" /> <label for="delete_box">지우기</label></p>

<? if ($board->use_category) { ?>
<p>
<input type="radio" name="action" value="change-category" id="change_category_box" /> <label for="change_category_box">분류 바꾸기</label>
<select name="category">
<? foreach ($board->get_categories() as $category) { ?>
	<?=option_tag($category->id, $category->name)?>
<? } ?>
</select>
</p>
<? } ?>

<p>
<input type="radio" name="action" value="move" id="move_box" /> <label for="move_box">옮기기</label>
<select name="board_id">
<? foreach (Board::find_all() as $_board) { ?>
<? if ($_board->id != $board->id) { ?>
	<option value="<?=$_board->id?>"><?=$_board->get_title()?></option>
<? } ?>
<? } ?>
</select>
<br /><input type="checkbox" value="1" name="track" id="track" checked="checked" style="margin-left: 2em" /> <label for="track">글 옮길 때 흔적 남기기</a>
</p>

<p><input type="submit" value="확인" /></p>
</form>
