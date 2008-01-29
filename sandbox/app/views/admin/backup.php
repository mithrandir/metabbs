<h2><?=i('Backup')?></h2>
<form method="get" action="?">
<input type="hidden" name="format" value="sql" />
<p>데이터베이스를 백업합니다. SQL 파일이 생성되며, 첨부 파일과 일부 플러그인의 설정 파일은 포함되지 <strong>않습니다.</strong> 첨부 파일은 data/ 디렉토리를 FTP나 SSH를 사용하여 직접 백업하십시오.</p>
<p><input type="submit" value="<?=i('Backup')?>" /></p>
</form>

<h2><?=i('Restore')?></h2>
<form method="post" action="<?=url_for('admin', 'restore')?>" enctype="multipart/form-data">
<p>데이터베이스를 복원합니다. 데이터를 복원할 때는 <strong>기존의 모든 데이터가 삭제</strong>됩니다. 또한 복원 후에 관리자 로그인을 다시 해야할 수도 있습니다.</p>
<p><input type="file" name="data" size="30" /> <input type="submit" value="<?=i('Restore')?>" /></p>
</form>
