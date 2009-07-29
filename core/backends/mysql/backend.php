<?php
function get_column_name($column) { return $column->name; }
function column_to_string($column) { return $column->to_string(); }

class Column {
	function Column($name) {
		$this->name = $name;
	}
}
class IntegerColumn extends Column {
	var $default = 0;
	function to_spec() {
		return "`$this->name` integer(10) NOT NULL DEFAULT '$this->default'";
	}
}
class ShortColumn extends IntegerColumn {
	function to_spec() {
		return "`$this->name` tinyint NOT NULL DEFAULT '$this->default'";
	}
}
class UShortColumn extends IntegerColumn {
	function to_spec() {
		return "`$this->name` tinyint UNSIGNED NOT NULL DEFAULT '$this->default'";
	}
}
class StringColumn extends Column {
	var $default = '';
	function to_spec($length) {
		return "`$this->name` varchar($length) NOT NULL DEFAULT '$this->default'";
	}
}
class TextColumn extends Column {
	function to_spec() {
		return "`$this->name` text NOT NULL";
	}
}
class LongTextColumn extends Column {
	function to_spec() {
		return "`$this->name` longtext NOT NULL";
	}
}
class TimestampColumn extends Column {
	function to_spec() {
		return "`$this->name` integer(10) NOT NULL";
	}
}
class BooleanColumn extends Column {
	function to_spec() {
		return "`$this->name` bool NOT NULL";
	}
}

function &get_conn() {
	global $config, $__db;
	if (!isset($__db)) {
		$__db = new MySQLConnection;
		$__db->connect($config->get('host'), $config->get('user'), $config->get('password'));
		$__db->selectdb($config->get('dbname'));
		if ($config->get('force_utf8') == '1') {
			$__db->enable_utf8();
		}
	}
	return $__db;
}

function &switch_on_conn($host, $user, $password, $dbname) {
	global $config, $__db;

	$__db->disconnect();
	unset($__db);
	$__db = new MySQLConnection;
	$__db->connect($host, $user, $password);
	$__db->selectdb($dbname);
	if ($config->get('force_utf8') == '1') {
		$__db->enable_utf8();
	}

	return $__db;
}

function &switch_off_conn() {
	global $__db;

	$__db->disconnect();
	unset($__db);
	$__db = get_conn();
	return $__db;
}

/**
 * MySQL 연결 클래스
 */
class MySQLConnection
{
	var $conn;
	var $utf8 = false;
	var $real_escape = true;
	var $prefix;

	function connect($host, $user, $password) {
		$this->conn = mysql_connect($host, $user, $password) or trigger_error(mysql_error(), E_USER_ERROR);
		$this->real_escape = function_exists('mysql_real_escape_string') && mysql_real_escape_string('ㅋ') == 'ㅋ';
	}
	function disconnect() {
		mysql_close($this->conn);
	}
	function selectdb($dbname) {
		mysql_select_db($dbname, $this->conn) or trigger_error(mysql_error(), E_USER_ERROR);
	}
	function enable_utf8() {
		$this->execute('set names utf8');
		$this->utf8 = true;
	}

	function execute($query, $data = NULL) {
		if ($data) $query = $this->_q($query, $data);
		$result = mysql_query($query, $this->conn);
		if (!$result) {
			echo '<br />Error query: ' . htmlspecialchars($query);
			trigger_error(mysql_error($this->conn), E_USER_ERROR);
		}
		return $result;
	}
	function query($query, $data = NULL) {
		return new MySQLResult($this->execute($query, $data));
	}
	function escape($query) {
		if ($this->real_escape) {
			return mysql_real_escape_string($query, $this->conn);
		} else {
			return mysql_escape_string($query);
		}
	}
	function _q($query, $data) {
		$tokens = preg_split('/([?!])/', $query, -1, PREG_SPLIT_DELIM_CAPTURE);
		foreach ($tokens as $i => $token) {
			if ($token == '?')
				$tokens[$i] = "'".$this->escape(array_shift($data))."'";
			else if ($token == '!')
				$tokens[$i] = array_shift($data);
		}
		return implode('', $tokens);
	}
	function fetchall($query, $model = 'Model', $data = NULL, $assoc = false) {
		$results = array();
		$result = $this->query($query, $data);
		while ($data = $result->fetch()) {
			if ($assoc)
				$results[$data['id']] = new $model($data);
			else
				$results[] = new $model($data);
		}
		return $results;
	}
	function fetchrow($query, $model = 'Model', $data = NULL) {
		$result = $this->query($query, $data);
		return new $model($result->fetch());
	}
	function fetchone($query, $data = NULL) {
		$result = $this->query($query, $data);
		return $result->fetch_column();
	}
	function insertid() {
		return mysql_insert_id($this->conn);
	}
	function add_table($t) {
		$sql = $t->to_sql();
		if ($this->utf8)
			$sql .= 'CHARACTER SET utf8 COLLATE utf8_general_ci';
		$this->execute($sql);
	}
	function rename_table($ot, $t) {
		$this->execute("RENAME TABLE ".get_table_name($ot)." TO ".get_table_name($t));
	}
	function drop_table($t) {
		$this->execute("DROP TABLE ".get_table_name($t));
	}
	function add_field($t, $name, $type, $length = NULL) {
		$table = new Table($t);
		$this->execute("ALTER TABLE $table->table ADD " . $table->_column($name, $type, $length));
	}
	function change_field($t, $old_name, $new_name, $type, $length = NULL) {
		$table = new Table($t);
		$this->execute("ALTER TABLE $table->table CHANGE `$old_name` " . $table->_column($new_name, $type, $length));
	}
	function drop_field($t, $name) {
		$this->execute("ALTER TABLE ".get_table_name($t)." DROP COLUMN $name");
	}
	function add_index($t, $name) {
		$this->execute("ALTER TABLE ".get_table_name($t)." ADD INDEX ${t}_$name ($name)");
	}
	function get_columns($table) {
		$result = $this->query("SHOW COLUMNS FROM $table");
		$fields = array();
		while ($name = $result->fetch_column()) {
			$fields[] = $name;
		}
		return $fields;
	}
	function get_server_version() {
		list($major, $minor) = explode('.', mysql_get_server_info($this->conn), 3);
		return array($major, $minor);
	}
	function get_created_tables() {
		$result = $this->query("SHOW TABLES LIKE '".get_table_name("%")."'");
		$tables = array();
		while ($data = $result->fetch()) {
			$tables[] = array_shift($data);
		}
		return $tables;
	}
	function quote_identifier($id) {
		return "`$id`";
	}
	function quote($value) {
		if (is_bool($value)) return (int)$value;
		else return "'".$this->escape($value)."'";
	}
}

class MySQLResult {
	function MySQLResult($result) {
		$this->result = $result;
	}
	function fetch() {
		return mysql_fetch_assoc($this->result);
	}
	function fetch_column() {
		list($value) = mysql_fetch_row($this->result);
		return $value;
	}
	function count() {
		return mysql_num_rows($this->result);
	}
}
?>
