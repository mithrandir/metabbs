<?php
/*
MySQL backend by:
Kim Taeho aka ditto <dittos@gmail.com>
http://ditto.exca.net/
*/

$column_type_map = array(
	'int' => 'Integer',
	'varchar' => 'String',
	'text' => 'String',
	'timestamp' => 'Timestamp'
	);

function get_column_name($column) { return $column->name; }
function column_to_string($column) { return $column->to_string(); }
class Column {
	function Column($name, $default) {
		$this->name = $name;
		$this->default = $default;
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
class IntegerColumn extends Column {}
class StringColumn extends Column {
	function to_string() {
		return "'" . mysql_real_escape_string($this->value) . "'";
	}
}
class TimestampColumn extends Column {}

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
            trigger_error(mysql_error($this->conn), E_USER_WARNING);
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
        $this->query("RENAME TABLE meta_$ot TO meta_$t");
    }
    function drop_table($t) {
        $this->query("DROP TABLE meta_$t");
    }
    function add_field($t, $name, $type, $length = null) {
    	$table = new Table($t);
    	$this->query("ALTER TABLE meta_$t ADD " . $table->_column($name, $type, $length));
	}
	function add_index($t, $name) {
		$this->query("ALTER TABLE meta_$t ADD INDEX ${t}_$name ($name)");
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
function model_insert($model, $data) {
    $db = get_conn();
    $query = 'INSERT INTO ';
    $query .= get_table_name($model);
    $query .= ' ('.implode(',', array_keys($data)).') VALUES(';
    foreach ($data as $key => $value) {
        $query .= '\''.$value.'\',';
    }
    $query = substr($query, 0, -1);
    $query .= ')';
    $db->query($query);
    return $db->insertid();
}
function model_update($model, $data, $condition = '1') {
    $db = get_conn();
    $query = 'UPDATE ';
    $query .= get_table_name($model);
    $query .= ' SET ';
    foreach ($data as $key => $value) {
        $query .= $key.'=\''.$value.'\',';
    }
    $query = substr($query, 0, -1);
    $query .= ' WHERE '.$condition;
    $db->query($query);
}
function model_datetime() {
    return date("YmdHis");
}

?>
