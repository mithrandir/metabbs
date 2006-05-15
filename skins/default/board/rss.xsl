<?xml version="1.0" encoding="UTF-8"?>
<!-- <?xml-stylesheet type="text/xsl" href="feed.xsl"?> -->
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="rss">
<html>
<body>
<h1>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="channel/link" />
		</xsl:attribute>
		<xsl:value-of select="channel/title" />
	</a>
</h1>
<p><xsl:value-of select="channel/description" /></p>
<xsl:for-each select="channel/item">
	<h2>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="link" />
		</xsl:attribute>
		<xsl:value-of select="title" />
	</a>
	</h2>
	<p><xsl:value-of select="description" /></p>
</xsl:for-each>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
