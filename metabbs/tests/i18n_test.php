<?php
require_once '../core/config.php';
require_once '../core/i18n.php';

define('METABBS_DIR', 'fixtures'); // XXX

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
		$this->lang->load_from_file('fixtures/lang/test.php');
		$this->assertEqual('안녕, 세상!', $this->lang->translate('Hello, world!'));
		$this->assertEqual('안녕, world!', $this->lang->translate('Hello, %s!', array('world')));
	}

	function testHeaderParsing() {
		$this->assertIdentical(array(), parse_language_header(''));
		$this->assertEqual(array('ko'), parse_language_header('ko'));
		$this->assertEqual(array('ko', 'en'), parse_language_header('ko,en'));
		$this->assertEqual(array('ko', 'en-us', 'en'), parse_language_header('ko,en-us;q=0.7,en;q=0.3'));
	}

	function testImportSourceLanguage() {
		import_language(SOURCE_LANGUAGE);
		$this->assertEqual('blah blah', i('blah blah'));
		$this->assertEqual('blah blah', i('%s %s', 'blah', 'blah'));
	}

	function testImportLanguage() {
		$this->assertFalse(import_language('n/a'));

		$this->assertTrue(import_language('test'));
		$this->assertEqual('블라 블라', i('blah blah'));
	}

	function testImportDefaultLanguage() {
		global $config;
		$config = new Config('');
		$config->set('always_use_default_language', TRUE);
		$config->set('default_language', 'test');
		import_default_language();
		$this->assertEqual('블라 블라', i('blah blah'));

		$config->set('always_use_default_language', FALSE);
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = SOURCE_LANGUAGE;
		import_default_language();
		$this->assertEqual('blah blah', i('blah blah'));
	}
}
?>
