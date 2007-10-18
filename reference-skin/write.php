<form method="post" enctype="multipart/form-data">
<dl>
<? if ($guest): ?>
	<dt>이름</dt>
	<dd><input type="text" name="author" value="<?=$post->author?>" /></dd>

	<dt>암호</dt>
	<dd><input type="password" name="password" /></dd>
<? endif; ?>

	<dt>제목</dt>
	<dd><input type="text" name="title" size="50" value="<?=$post->title?>" /></dd>

<? if ($categories): ?>
	<dt>분류</dt>
	<dd>
		<select name="category">
		<? foreach ($categories as $category): ?>
			<option value="<?=$category->id?>" <?=$category->selected?>><?=$category->name?></option>
		<? endforeach; ?>
		</select>
	</dd>
<? endif; ?>

	<dt>기타 옵션</dt>
	<dd>
		<? if ($admin): ?>
		<input type="checkbox" name="notice" value="1" <?=$notice_checked?> /> 공지사항
		<? endif; ?>
		<input type="checkbox" name="secret" value="1" <?=$secret_checked?> /> 비밀글
	</dd>

	<dt>내용</dt>
	<dd><textarea name="body" cols="40" rows="12"><?=$post->body?></textarea></dd>

	<? foreach ($additional_fields as $field): ?>
	<dt><?=$field->name?></dt>
	<dd><?=$field->output?></dd>
	<? endforeach; ?>
</dl>

<? if ($uploadable): ?>
	<h2>파일 올리기</h2>
	<p>최대 업로드 크기: <?=$upload_limit?></p>
	<ul id="uploads">
	<? foreach ($attachments as $attachment): ?>
		<li><?=$attachment->filename?> <input type="checkbox" name="delete[]" value="<?=$attachment->id?>" /> 삭제</li>
	<? endforeach; ?>
		<li><input type="file" name="upload[]" size="50" /></li>
	</ul>
	<p><a href="#" onclick="addFileEntry()">파일 추가...</a></p>
<? endif; ?>

<? if ($editing): ?>
	<input type="submit" value="수정하기" />
<? else: ?>
	<input type="submit" value="글쓰기" />
<? endif; ?>
</form>

<div id="meta-nav">
<a href="<?=$link_list?>">목록보기</a>
<? if ($link_cancel): ?><a href="<?=$link_cancel?>">돌아가기</a><? endif; ?>
</div>
