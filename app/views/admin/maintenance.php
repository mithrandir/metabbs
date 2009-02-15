<form method="get" action="<?=url_for('admin', 'backup')?>" id="backup">
<h2><?=i('Backup')?></h2>
<input type="hidden" name="format" value="sql" />
<p>데이터베이스를 백업합니다. SQL 파일이 생성되며, 첨부 파일과 일부 플러그인의 설정 파일은 포함되지 <strong>않습니다.</strong> 첨부 파일은 data/ 디렉토리를 FTP나 SSH를 사용하여 직접 백업하십시오.</p>
<p><input type="submit" value="<?=i('Backup')?>" /></p>
</form>

<form method="post" action="<?=url_for('admin', 'restore')?>" enctype="multipart/form-data" id="restore">
<?=form_token_field()?>
<h2><?=i('Restore')?></h2>
<p>데이터베이스를 복원합니다. 데이터를 복원할 때는 <strong>기존의 모든 데이터가 삭제</strong>됩니다. 또한 복원 후에 관리자 로그인을 다시 해야할 수도 있습니다.</p>
<p><input type="file" name="data" size="30" /> <input type="submit" value="<?=i('Restore')?>" /></p>
</form>

<form method="post" action="<?=url_for('admin', 'purge-session')?>" id="purge-session">
<?=form_token_field()?>
<h2>세션 정리</h2>
<p>사용되지 않는 세션 정보를 삭제합니다.</p>
<p><input type="submit" value="정리하기" /></p>
</form>

<form method="post" action="<?=url_for('admin', 'uninstall')?>" id="uninstall">
<?=form_token_field()?>
<h2><?=i('Uninstall')?></h2>
<p>모든 자료와 설정 파일을 지웁니다.</p>
<p><input type="submit" value="언인스톨" /></p>
</form>
