<?xml version="1.0" encoding="UTF-8"?>
<!-- <?xml-stylesheet type="text/xsl" href="feed.xsl"?> -->
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="feed">
<html>
<body>
<h1>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="id" />
		</xsl:attribute>
		<xsl:value-of select="title" />
	</a>
</h1>
<p><xsl:value-of select="subtitle" /></p>
<xsl:for-each select="entry">
	<h2>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="id" />
		</xsl:attribute>
		<xsl:value-of select="title" />
	</a>
	</h2>
	<p><xsl:value-of select="content" /></p>
</xsl:for-each>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
