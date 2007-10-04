<?php
// Converter Library

function print_header($step) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html lang="ko">
<head>
	<title>Zb2Metabbs Converter</title>
	<link rel="stylesheet" type="text/css" href="converter.css" />
</head>
<body>
<div id="wrap">
	<div id="header">
		<h1>Zeroboard to MetaBBS <span id="step">Step <?=$step?></span></h1>
	</div>
	<div id="content">
<?php
}

function print_footer() {
?>
	</div>
	<div id="footer">
		<p id="copyright">Copyright&copy; MetaBBS Team</p>
	</div>
</div>
</body>
</html>
<?php
}

function section($text) {
	echo "<h2>$text</h2>\n";
}

function error($msg) {
	echo "<div class=\"msg error\">$msg</div>\n";
}

function warning($msg) {
	echo "<div class=\"msg warning\">$msg</div>\n";
}

function ok($msg) {
	echo "<div class=\"msg ok\">$msg</div>\n";
}

function msg($msg) {
	echo "<div class=\"msg\">$msg</div>\n";
}

function form_start($next_step) {
	echo "<form action=\"{$_SERVER['SCRIPT_NAME']}\" method=\"post\">\n";
	input_hidden('step', $next_step);
}

function form_end() {
	echo "</form>\n";
}

function input_hidden($name, $value) {
	echo "<p class=\"hidden\"><input type=\"hidden\" name=\"$name\" value=\"$value\" /></p>\n";
}

function input_general($label, $type, $name, $value) {
	echo "<p>";
	if ($label != '') echo "<label>$label</label>";
	echo "<input type=\"$type\" name=\"$name\" value=\"$value\" /></p>\n";
}

function get_mysql_version() {
	preg_match('/[0-9]+\.[0-9]+(\.[0-9]+)?/', mysql_get_server_info(), $matches);
	return $matches[0];
}

?>
