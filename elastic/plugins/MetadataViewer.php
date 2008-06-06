<?php
class MetadataViewer extends Plugin {
	var $plugin_name = '추가 정보 표시';
	var $description = '글의 추가 정보를 보입니다. (테스트용)';
	function on_init() {
		add_filter('PostList', array(&$this, 'print_metadata'), 10000);
		add_filter('PostView', array(&$this, 'print_metadata'), 10000);
	}
	function print_metadata(&$post) {
		if (!$post->body) return;
		ob_start();
		$attributes = $post->get_attributes();
		if (!$attributes) return;
?>
<table class="metadata">
<tr>
	<th>Key</th>
	<th>Value</th>
</tr>
<? foreach ($attributes as $key => $value) { ?>
<tr>
	<td><?=htmlspecialchars($key)?></td>
	<td><?=htmlspecialchars($value)?></td>
</tr>
<? } ?>
</table>
<?php
		$post->body .= ob_get_contents();
		ob_end_clean();
	}
}

register_plugin('MetadataViewer');
?>
