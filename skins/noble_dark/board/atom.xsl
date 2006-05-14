<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:atom="http://www.w3.org/2005/Atom">
<xsl:template match="atom:feed">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><xsl:value-of select="atom:title" /> - MetaBBS Atom Feeds</title>
	<link rel="stylesheet" type="text/css" href="/metabbs/skins/noble_dark/board/feed.css" />
</head>
<body>
<h1>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="atom:id" />
		</xsl:attribute>
		<xsl:value-of select="atom:title" />
	</a>
</h1>
<p id="description"><xsl:value-of select="atom:subtitle" /></p>
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
	<div class="content"><xsl:value-of select="atom:content" /></div>
</div>
</xsl:for-each>
<div id="powered">
	<p>Powered by <a href="http://metabbs.org">MetaBBS</a></p>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
