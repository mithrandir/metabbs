<?php
	$t = new Table('openid');
	$t->column('openid', 'string', 255);
	$t->column('position', 'integer');
	$t->column('user_id', 'integer');	
	$t->column('created_at', 'timestamp');
	$t->add_index('openid');
	$t->add_index('user_id');
	$conn->add_table($t);
	
	// user테이블에서 openid를 추출해서 openid테이블에 넣는다. 
?>