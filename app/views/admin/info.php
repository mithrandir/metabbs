<h2>정보</h2>
<dl>
	<dt>버전</dt>
	<dd>MetaBBS <?=METABBS_VERSION?></dd>

	<dt>데이터베이스 리비전</dt>
	<dd>r<?=$config->get('revision')?></dd>

	<dt>설치한 때</dt>
	<dd><?=date('Y-m-d H:i:s', filectime('.htaccess'))?></dd>
</dl>

<h2>코드 생성</h2>
<pre class="code">&lt;?php
@define("METABBS_BASE_PATH",&nbsp;"<?=METABBS_BASE_PATH?>");
@define("METABBS_BASE_URI",&nbsp;"<?=METABBS_BASE_URI?>");
require_once('<?=str_replace("\\", "/", METABBS_DIR)?>/site_manager.php');
?&gt;</pre>
<p>쓰는 방법은 <a href="http://metabbs.org/manual/site_management.html">사이트 구축하기</a> 도움말을 보세요.</p>
