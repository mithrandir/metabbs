<?xml version="1.0" encoding="UTF-8"?>
<!-- <?xml-stylesheet type="text/xsl" href="feed.xsl"?> -->
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
<xsl:template match="rss">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><xsl:value-of select="channel/title" /> - MetaBBS RSS Feeds</title>
	<link rel="stylesheet" type="text/css" href="/metabbs/skins/noble_dark/board/feed.css" />
	<script type="text/javascript" src="/metabbs/skins/noble_dark/fix_html.js"></script>
</head>
<body>
<h1>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="channel/link" />
		</xsl:attribute>
		<xsl:value-of select="channel/title" />
	</a>
</h1>
<p id="description" class="content"><xsl:value-of select="channel/description" disable-output-escaping="yes" /></p>
<xsl:for-each select="channel/item">
<div class="post">
	<h2>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="link" />
		</xsl:attribute>
		<xsl:value-of select="title" />
	</a>
	</h2>
	<div class="content"><xsl:value-of select="description" disable-output-escaping="yes" /></div>
</div>
</xsl:for-each>
<div id="powered">
	<p>Powered by <a href="http://metabbs.org">MetaBBS</a></p>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
