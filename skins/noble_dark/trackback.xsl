<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="response">
<html>
<body>
<h1>Trackback Result</h1>
<p>
  트랙백이 실패하였습니다.<br />
  <xsl:value-of select="message" />
</p>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
