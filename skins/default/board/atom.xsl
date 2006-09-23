<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:atom="http://www.w3.org/2005/Atom">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
<xsl:template match="atom:feed">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><xsl:value-of select="atom:title" /> - MetaBBS Atom Feeds</title>
	<link rel="stylesheet" type="text/css" href="?mode=css" />
	<script type="text/javascript" src="../../skins/default/fix_html.js"></script>
</head>
<body>
<h1>
	<a href="{atom:id}"><xsl:value-of select="atom:title" /></a>
</h1>
<p id="description" class="content"><xsl:value-of select="atom:subtitle" disable-output-escaping="yes" /></p>
<xsl:for-each select="atom:entry">
<div class="post">
	<h2>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="atom:id" />
		</xsl:attribute>
		<xsl:value-of select="atom:title" />
	</a>
	</h2>
	<div class="content"><xsl:value-of select="atom:content" disable-output-escaping="yes" /></div>
</div>
</xsl:for-each>
<div id="powered">
	<p>Powered by <a href="http://metabbs.org">MetaBBS</a></p>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
