<?php
require_once "../core/model.php";
require_once "../app/models/post.php";
require_once "../app/models/metadata.php";

class MetaModel extends Model {
	var $model = 'meta_model';
}

class MetadataTest extends UnitTestCase {
	function setUp() {
		$this->metadata = new Metadata(Post::find(5));
	}

	function testLoad() {
		$this->metadata->load();
		$this->assertEqual('bar', $this->metadata->attributes['foo']);
	}
	
	function testGet() {
		$this->assertEqual('bar', $this->metadata->get('foo'));
	}

	function testSet() {
		$this->metadata->set('edited', 'no');
		$this->assertEqual('no', $this->metadata->get('edited'));
		$this->metadata->set('edited', 'yes');
		$this->assertEqual('yes', $this->metadata->get('edited'));
	}

	function testReset() {
		$this->metadata->reset();
		$this->assertEqual('', $this->metadata->get('foo'));
	}
}
