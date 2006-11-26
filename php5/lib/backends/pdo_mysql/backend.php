<?php
$column_type_map = array(
	'int' => 'Integer',
	'enum' => 'String',
	'varchar' => 'String',
	'longtext' => 'String',
	'text' => 'String',
	'timestamp' => 'Timestamp',
	'tinyint' => 'Short',
	'bool' => 'Boolean'
	);

function get_column_name($column) { return $column->name; }
function column_to_string($column) { return $column->to_string(); }
class Column {
	var $default = '';
	function Column($name) {
		$this->name = $name;
	}
	function set_value($value) {
		if ($value)
			$this->value = $value;
		else
			$this->value = $this->default;
	}
	function to_string() {
		return $this->value;
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
	function StringColumn($name) {
		$this->Column($name);
		$this->conn = get_conn();
	}
	function to_string() {
		return $this->conn->quote($this->value);
	}
	function to_spec($length) {
		return "`$this->name` varchar($length) NOT NULL DEFAULT '$this->default'";
	}
}
class TextColumn extends Column {
	function to_spec() {
		return "`$this->name` text NOT NULL";
	}
}
class TimestampColumn extends Column {
	function to_string() {
		return model_datetime();
	}
	function to_spec() {
		return "`$this->name` timestamp NOT NULL";
	}
}
class BooleanColumn extends Column {
	function to_string() {
		return !!$this->value ? 1 : 0;
	}
	function to_spec() {
		return "`$this->name` bool NOT NULL";
	}
}

function get_conn() {
    static $conn;
    global $config;
    if (!isset($conn)) {
        $conn = new MySQLAdapter;
        $conn->connect($config->get('host'), $config->get('user'), $config->get('password'), $config->get('dbname'));
        if ($config->get('force_utf8') == '1') {
            $conn->enable_utf8();
        }
    }
    return $conn;
}

class MySQLAdapter
{
    var $conn;

    function connect($host, $user, $password, $dbname) {
        $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password) or trigger_error("pdo_mysql - Can't connect database", E_USER_ERROR);
    }
	function enable_utf8() {
		$this->query('set names utf8');
	}

	function quote($query) {
		return $this->conn->quote($query);
	}
    function query($query, $data = array()) {
        if (!$query) return;
        $stmt = $this->conn->prepare($query);
		if ($stmt->execute($data)) {
	        return $stmt;
		} else {
			return null;
		}
    }
    function fetchall($query, $model = 'Model', $data = array(), $assoc = false) {
		$result = $this->query($query, $data);
		if ($result) {
			$result->setFetchMode(PDO::FETCH_CLASS, $model);
			if ($assoc) return $result->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
			else return $result->fetchAll();
		} else {
			return array();
		}
    }
    function fetchrow($query, $model = 'Model', $data = array()) {
        $result = $this->query($query, $data);
		if ($result) return $result->fetchObject($model);
		else return new $model;
    }
    function fetchone($query, $data = null) {
		$result = $this->conn->query($query, $data);
		if ($result) return $result->fetchColumn();
    }
    function insertid() {
        return $this->conn->lastInsertId();
    }
    function add_table($t) {
        $this->query($t->to_sql());
    }
    function rename_table($ot, $t) {
        $this->query("RENAME TABLE ".get_table_name($ot)." TO ".get_table_name($t));
    }
    function drop_table($t) {
        $this->query("DROP TABLE ".get_table_name($t));
    }
    function add_field($t, $name, $type, $length = null) {
    	$table = new Table($t);
    	$this->query("ALTER TABLE $table->table ADD " . $table->_column($name, $type, $length));
	}
	function add_index($t, $name) {
		$this->query("ALTER TABLE ".get_table_name($t)." ADD INDEX ${t}_$name ($name)");
	}
	function get_field_class_from_type($type) {
		global $column_type_map;
		list($t) = explode("(", $type);
		return $column_type_map[$t]."Column";
	}
	function get_columns($table) {
		$result = $this->query("SHOW COLUMNS FROM $table");
		$fields = array();
		foreach ($result as $column) {
			list($name, $type, /*null*/, $key, $default) = $column;
			if ($key == 'PRI') continue;
			$c = $this->get_field_class_from_type($type);
			$fields[] = new $c($name, $default);
		}
		return $fields;
	}
	function get_server_version() {
		list($major, $minor) = explode('.', $this->conn->getAttribute(PDO::ATTR_SERVER_VERSION), 3);
		return array($major, $minor);
	}
}
function model_datetime() {
    return date("YmdHis");
}
?>
