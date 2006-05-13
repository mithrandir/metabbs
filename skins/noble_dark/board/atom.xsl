<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:atom="http://www.w3.org/2005/Atom">
<xsl:template match="atom:feed">
<html>
<body>
<h1>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="atom:id" />
		</xsl:attribute>
		<xsl:value-of select="atom:title" />
	</a>
</h1>
<p><xsl:value-of select="atom:subtitle" /></p>
<xsl:for-each select="atom:entry">
	<h2>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="atom:id" />
		</xsl:attribute>
		<xsl:value-of select="atom:title" />
	</a>
	</h2>
	<p><xsl:value-of select="atom:content" /></p>
</xsl:for-each>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
