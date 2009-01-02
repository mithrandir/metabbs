<form method="post" enctype="multipart/form-data" action="">
<div id="post-form">
<h1>글쓰기</h1>
<table>
<? if ($guest): ?>
<tr>
	<th>이름</th>
	<td class="name"><input type="text" name="author" value="<?=$post->author?>" /></td>

	<th>암호</th>
	<td class="password"><input type="password" name="password" /></td>
</tr>
<? endif; ?>

<tr>
	<th>제목</th>
	<td colspan="3"><input type="text" name="title" size="50" value="<?=$post->title?>" id="post_title" /></td>
</tr>

<tr class="options">
	<th></th>
	<td colspan="3">
		<? if ($categories): ?>
		<select name="category">
		<? foreach ($categories as $category): ?>
			<option value="<?=$category->id?>" <?=$category->selected?>><?=$category->name?></option>
		<? endforeach; ?>
		</select>
		<? endif; ?>

		<? if ($admin): ?><input type="checkbox" name="notice" value="1" <?=$notice_checked?> /> 공지사항<? endif; ?>
		<input type="checkbox" name="secret" value="1" <?=$secret_checked?> /> 비밀글
	</td>
</tr>

<tr>
	<td colspan="4" class="body"><textarea name="body" id="post_body" cols="40" rows="15"><?=$post->body?></textarea></td>
</tr>
<? if ($guest): ?>
	<? if ($board->use_captcha() && isset($captcha) && $captcha->ready()): ?>
<tr>
	<th>CAPTCHA</th>
	<td class="captcha" colspan="3"><?= $captcha->get_html() ?>
		<? if (!empty($captcha->error)): ?>
		<span style="captcha notice"><?=i($captcha->error)?></p>
		<? endif; ?>
	</td>
</tr>
	<? endif; ?>
<? endif; ?>
<? if ($preview): ?>
	<tr>
		<td colspan="4" class="preview"><?=$preview->body?></td>
	</tr>
<? endif; ?>

<? if ($taggable): ?>
	<tr>
		<th>태그</th>
		<td colspan="3">
			<input type="text" name="tags" value="<?=$post->tags?>" size="40" id="post_tags" /> 태그 사이는 쉼표(,)로 구분합니다.
		</td>
	</tr>
<? endif; ?>

<? foreach ($additional_fields as $field): ?>
<tr>
	<th><?=$field->name?></th>
	<td colspan="3"><?=$field->output?></td>
</tr>
<? endforeach; ?>
</table>

<? if ($uploadable): ?>
<div id="upload">
<h2>파일 올리기</h2>
<p>최대 업로드 크기: <?=$upload_limit?></p>
<ul id="uploads">
<? foreach ($attachments as $attachment): ?>
	<li><?=$attachment->filename?> <input type="checkbox" name="delete[]" value="<?=$attachment->id?>" /> 삭제</li>
<? endforeach; ?>
	<li><input type="file" name="upload[]" size="50" /></li>
</ul>
<p><a href="#" onclick="addFileEntry(); return false" class="button">파일 추가...</a></p>
</div>
<? endif; ?>

<? if ($admin): ?>
<div id="trackback">
<h2>트랙백 보내기</h2>
<ul id="trackback_input">
	<li><input type="text" name="trackback" size="63" /></li>
</ul>
</div>
<? endif; ?>
</div>

<div id="meta-nav">
	<button type="submit" name="action" value="save" class="save">
		<? if ($editing): ?>고치기<? else: ?>글쓰기<? endif; ?>
	</button>
	<button type="submit" name="action" value="preview">미리보기</button>
<? if ($link_cancel): ?><a href="<?=$link_cancel?>">취소</a><? endif; ?>
</div>
</form>
