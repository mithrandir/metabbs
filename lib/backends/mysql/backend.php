<?php
/*
MySQL backend by:
Kim Taeho aka ditto <dittos@gmail.com>
http://ditto.exca.net/
*/

$column_type_map = array(
	'int' => 'Integer',
	'enum' => 'String',
	'varchar' => 'String',
	'longtext' => 'String',
	'text' => 'String',
	'timestamp' => 'Timestamp'
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
class StringColumn extends Column {
	function to_string() {
		// return "'" . mysql_real_escape_string($this->value) . "'";
		return "'" . $this->value . "'";
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

function get_conn() {
    static $conn;
    global $config;
    if (!isset($conn)) {
        $conn = new MySQLAdapter;
        $conn->connect($config->get('host'), $config->get('user'), $config->get('password'));
        $conn->selectdb($config->get('dbname'));
        if ($config->get('force_utf8') == '1') {
            $conn->query('set names utf8');
        }
    }
    return $conn;
}

class MySQLAdapter
{
    var $conn;

    function connect($host, $user, $password) {
        $this->conn = @mysql_connect($host, $user, $password) or trigger_error("mysql - Can't connect database",E_USER_ERROR);
        register_shutdown_function(array(&$this, 'disconnect'));
    }
    function disconnect() {
        @mysql_close($this->conn);
    }
    function selectdb($dbname) {
        @mysql_select_db($dbname, $this->conn) or trigger_error("mysql - Can't select database",E_USER_ERROR);
    }

    function query($query, $check_error = true) {
        if (!$query) {
            return;
        }
        $result = mysql_query($query, $this->conn);
        if (!$result && $check_error) {
            trigger_error(mysql_error($this->conn), E_USER_ERROR);
        }
        return $result;
    }
    function query_from_file($name) {
        $data = trim(implode('', file($name)));
        $statements = explode(';', $data);
        array_walk($statements, array($this, 'query'));
    }
    function fetchall($query, $model = 'Model') {
        $results = array();
        $result = $this->query($query);
        while ($data = mysql_fetch_assoc($result)) {
            $results[] = new $model($data);
        }
        return $results;
    }
    function fetchrow($query, $model = 'Model') {
        return new $model(mysql_fetch_assoc($this->query($query)));
    }
    function fetchone($query) {
        $result = mysql_fetch_row($this->query($query));
        return $result[0];
    }
    function insertid() {
        return mysql_insert_id($this->conn);
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
    	$this->query("ALTER TABLE ".get_table_name($t)." ADD " . $table->_column($name, $type, $length));
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
		$result = $this->query("SHOW COLUMNS FROM $table", "Model");
		$fields = array();
		while (list($name, $type, /*null*/, $key, $default) = mysql_fetch_row($result)) {
			if ($key == 'PRI') continue;
			$c = $this->get_field_class_from_type($type);
			$fields[] = new $c($name, $default);
		}
		return $fields;
	}
}
function model_datetime() {
    return date("YmdHis");
}

?>
