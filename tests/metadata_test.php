<?php
require_once "../lib/model.php";
require_once "../app/models/post.php";
require_once "../app/models/metadata.php";

class MetaModel extends Model {
	var $model = 'meta_model';
}

class MetadataTest extends UnitTestCase {
	function setUp() {
		$this->metadata = new Metadata(Post::find(5));
		$this->metadata2 = new Metadata(new MetaModel(array('id' => 123)));
	}

	function testLoad() {
		$this->metadata->load();
		$this->assertEqual('bar', $this->metadata->attributes['foo']);
	}
	
	function testGet() {
		$this->metadata->load();
		$this->assertEqual('bar', $this->metadata->get('foo'));
	}

	function testSet() {
		$this->metadata->set('edited', 'no');
		$this->assertEqual('no', $this->metadata->get('edited'));
		$this->metadata2->set('edited', 'hello');
		$this->metadata->set('edited', 'yes');
		$this->assertEqual('yes', $this->metadata->get('edited'));
		$this->assertEqual('hello', $this->metadata2->get('edited'));
	}

	function testReset() {
		$this->metadata->reset();
		$this->assertEqual('', $this->metadata->get('foo'));
	}
}
