<?php
if (isset($board) && $board->use_trackback && isset($post) && $GLOBALS['controller'] == 'post') {
?>
<!--
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	 xmlns:dc="http://purl.org/dc/elements/1.1/"
	 xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
<rdf:Description
	 rdf:about="<?=full_url_for($post)?>"
	 dc:title="<?=$post->title?>"
	 dc:identifier="<?=full_url_for($post)?>"
	 trackback:ping="<?=full_url_for($post, 'trackback')?>" />
</rdf:RDF>
-->
<?php
}
