<?php

function cut_string($source, $limit=255) {
	if (strlen($source > $limit)) {
		return substr($source, 0, $limit);
	} else {
		return $source;
	}
}

function prepare_post($title, $excerpt, $blog_name, $url) {
	$query = "title=" . urlencode($title). "&excerpt=" . urlencode($excerpt);
	$query .= "&blog_name=" . urlencode($blog_name) . "&url=" . $url;
	return $query;
}

function prepare_query($query) {
	if (isset($query) && ($query != "")) {
		return "?" . $query;
	} else {
		return $query;
	}
}

function select_port($port) {
	if ((isset($port) && !is_numeric($port)) || !isset($port)) {
		return 80;
	} else {
		return $port;
	}
}

function sentence($path, $query, $host, $contents) {
	$data = "POST " . $path . $query . " HTTP/1.1\n";
	$data .= "Host: " . $host . "\n";
	$data .= "Content-Type: application/x-www-form-urlencoded; ";
	$data .= "charset=utf-8\n";
	$data .= "Content-Length: " . strlen($contents) . "\n";
	$data .= "User-agent: Metabbs/0.9\n\n";
	$data .= $contents;

	return $data;
}

function is_ok($response) {
	return strpos($response, "<error>0</error>") ? true : false;
}

function send_trackback($trackback) {
	$destination = $trackback['to'];
	unset($trackback['to']);

	$contents = prepare_post($trackback['title'],
								   cut_string($trackback['excerpt']),
								   $trackback['blog_name'],
								   $trackback['url']);
	$target = parse_url($destination);
	$query = prepare_query($target["query"]);
	$port = select_port($target["port"]);

	$socket = @fsockopen($target["host"], $port);

	if (!is_resource($socket)) {
		return false;
	}

	fputs($socket, $request = sentence($target["path"], $query, $target["host"],
							$contents));

	while (!feof($socket)) {
		$response .= fgets($socket);
	}

	fclose($socket);

	return is_ok($response);
}
?>
