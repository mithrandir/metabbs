<?xml version="1.0" encoding="UTF-8"?>
<!-- <?xml-stylesheet type="text/xsl" href="feed.xsl"?> -->
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="rss">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><xsl:value-of select="channel/title" /> - MetaBBS RSS Feeds</title>
	<link rel="stylesheet" type="text/css" href="/metabbs/skins/default/board/feed.css" />
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
<p id="description"><xsl:value-of select="channel/description" /></p>
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
	<div class="content"><xsl:value-of select="description" /></div>
</div>
</xsl:for-each>
<div id="powered">
	<p>Powered by <a href="http://metabbs.org">MetaBBS</a></p>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
