<?php
if (isset($board) && $board->use_trackback && isset($post) && $routes['controller'] == 'post') {
?>
<!--
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	 xmlns:dc="http://purl.org/dc/elements/1.1/"
	 xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
<rdf:Description
	 rdf:about="<?=full_url_for_metabbs('post', null, array('id'=>$post->id))?>"
	 dc:title="<?=str_replace('--', '&#x2d;&#x2d;', $post->title)?>"
	 dc:identifier="<?=full_url_for_metabbs('post', null, array('id'=>$post->id))?>"
	 trackback:ping="<?=full_url_for_metabbs('post', 'trackback', array('id'=>$post->id))?>" />
</rdf:RDF>
-->
<?php
}
?>
