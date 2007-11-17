<?php
require '../lib/i18n.php';

class I18NTest extends UnitTestCase {
	function setUp() {
		$this->lang = new Language('test');
	}

	function tearDown() {
		unset($this->lang);
	}

	function testNoTranslation() {
		$this->assertEqual('Hello, world!', $this->lang->translate('Hello, world!'));
		$this->assertEqual('Hello, world!', $this->lang->translate('Hello, %s!', array('world')));
	}

	function testAddingTranslation() {
		$this->lang->add_translation('Hello, world!', '안녕, 세상!');
		$this->assertEqual('안녕, 세상!', $this->lang->translate('Hello, world!'));

		$this->lang->add_translation('Hello, %s!', '안녕, %s!');
		$this->assertEqual('안녕, world!', $this->lang->translate('Hello, %s!', array('world')));
	}

	function testLoadFromFile() {
		$fp = fopen('test.txt', 'w');
		fwrite($fp, "<?php/*\n");
		fwrite($fp, "Hello, world!=안녕, 세상!\n");
		fwrite($fp, "Hello, %s!=안녕, %s!\n");
		fclose($fp);

		$this->lang->load_from_file('test.txt');
		$this->assertEqual('안녕, 세상!', $this->lang->translate('Hello, world!'));
		$this->assertEqual('안녕, world!', $this->lang->translate('Hello, %s!', array('world')));

		unlink('test.txt');
	}

	function testHeaderParsing() {
		$this->assertIdentical(array(), parse_language_header(''));
		$this->assertEqual(array('ko'), parse_language_header('ko'));
		$this->assertEqual(array('ko', 'en'), parse_language_header('ko,en'));
		$this->assertEqual(array('ko', 'en-us', 'en'), parse_language_header('ko,en-us;q=0.7,en;q=0.3'));
	}

	function testGlobalFunctions() {
		import_language(SOURCE_LANGUAGE);
		$this->assertEqual('blah blah', i('blah blah'));
		$this->assertEqual('blah blah', i('%s %s', 'blah', 'blah'));
	}
}
?>
