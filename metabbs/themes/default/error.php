<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$text?></title>
	<style type="text/css">
	body { background-color: #999; margin: 2em; font-family: Verdana, Arial, sans-serif; }
	a { color: #000; }
	#wrap { border: 10px solid #ccc; background: #eee url(<?=METABBS_BASE_PATH?>themes/default/error.png) no-repeat 1em 1em; width: 30em; }
	#wrap { margin: 0 auto; padding: 1em 0 1em 6em; }
	h1 { font-size: 1.3em; margin: 0.25em 0 0.5em 0; }
	p { font-size: 0.8em; }
	#metabbs { font-size: 0.6em; color: #666; margin-top: 3em; }
	</style>
</head>
<body>
<div id="wrap">
<h1><?=$text?></h1>
<p><?=$description?></p>
<p id="metabbs">Powered by <a href="http://metabbs.org/">MetaBBS</a> (<?=METABBS_VERSION?>)</p>
</div>
</body>
</html>
