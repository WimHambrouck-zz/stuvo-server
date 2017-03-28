<?php namespace mvdwcms\managers;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

include_once 'fix_mysql.inc.php'

/* MySQL Database class */
class DatabaseManager
{
    var $con;
	var $mysqldb;
    function __construct($db = array())
    {
    	$this->mysqldb = $db;
        $this->con = mysql_connect($db['hostname'], $db['username'], $db['password'], true) or die('Error connecting to MySQL');
        mysql_select_db($db['database'], $this->con) or die('Database ' . $db['database'] . ' does not exist!');
	}
    function __destruct()
    {
        mysql_close($this->con);
    }
    function query($s = '', $rows = false, $organize = true)
    {
        if (!$q = mysql_query($s, $this->con))
            return false;
        if ($rows !== false)
            $rows = intval($rows);
        $rez   = array();
        $count = 0;
        $type  = $organize ? MYSQL_NUM : MYSQL_ASSOC;
        while (($rows === false || $count < $rows) && $line = mysql_fetch_array($q, $type)) {
            if ($organize) {
                foreach ($line as $field_id => $value) {
                    $table = mysql_field_table($q, $field_id);
                    if ($table === '')
                        $table = 0;
                    $field                       = mysql_field_name($q, $field_id);
                    $rez[$count][$table][$field] = $value;
                }
            } else {
                $rez[$count] = $line;
            }
            ++$count;
        }
        if (!mysql_free_result($q))
            return false;
        return $rez;
    }
    function execute($s = '')
    {
        if (mysql_query($s, $this->con))
            return true;
        return false;
    }
    function select($options)
    {
        $default = array(
            'table' => '',
            'fields' => '*',
            'condition' => '1',
            'order' => '1',
            'limit' => 50
        );
        $options = array_merge($default, $options);
        $sql     = "SELECT {$options['fields']} FROM {$options['table']} WHERE {$options['condition']} ORDER BY {$options['order']} LIMIT {$options['limit']}";
		if ($this->mysqldb['debug'] == true)
			var_dump($sql);
		return $this->query($sql);
    }
    function row($options)
    {
        $default = array(
            'table' => '',
            'fields' => '*',
            'condition' => '1',
            'order' => '1'
        );
        $options = array_merge($default, $options);
        $sql     = "SELECT {$options['fields']} FROM {$options['table']} WHERE {$options['condition']} ORDER BY {$options['order']}";
        $result  = $this->query($sql, 1, false);
		if ($this->mysqldb['debug'] == true)
			var_dump($sql);
		if (empty($result[0]))
            return false;
        return $result[0];
    }
    function get($table = null, $field = null, $conditions = '1')
    {
    	$table = $this->mysqldb['prefix'].$table;
        if ($table === null || $field === null)
            return false;
        $result = $this->row(array(
            'table' => $table,
            'condition' => $conditions,
            'fields' => $field
        ));
        if (empty($result[$field]))
            return false;
        return $result[$field];
    }
    function update($table = null, $array_of_values = array(), $conditions = 'FALSE')
    {
    	$table = $this->mysqldb['prefix'].$table;
        if ($table === null || empty($array_of_values))
            return false;
        $what_to_set = array();
        foreach ($array_of_values as $field => $value) {
            if (is_array($value) && !empty($value[0]))
                $what_to_set[] = "`$field`='{$value[0]}'";
            else
                $what_to_set[] = "`$field`='" . mysql_real_escape_string($value, $this->con) . "'";
        }
        $what_to_set_string = implode(',', $what_to_set);
		if ($this->mysqldb['debug'] == true)
			var_dump("UPDATE $table SET $what_to_set_string WHERE $conditions");
        return $this->execute("UPDATE $table SET $what_to_set_string WHERE $conditions");
    }
    function insert($table = null, $array_of_values = array())
    {
    	$table = $this->mysqldb['prefix'].$table;
        if ($table === null || empty($array_of_values) || !is_array($array_of_values))
            return false;
        $fields = array();
        $values = array();
        foreach ($array_of_values as $id => $value) {
            $fields[] = $id;
            if (is_array($value) && !empty($value[0]))
                $values[] = $value[0];
            else
                $values[] = "'" . mysql_real_escape_string($value, $this->con) . "'";
        }
        $s = "INSERT INTO $table (`" . implode('`,`', $fields) . '`) VALUES (' . implode(',', $values) . ')';
		if ($this->mysqldb['debug'] == true)
			var_dump($s);
	    if (mysql_query($s, $this->con))
            return mysql_insert_id($this->con);
        return false;
    }
    function delete($table = null, $conditions = 'FALSE')
    {
    	$table = $this->mysqldb['prefix'].$table;
        if ($table === null)
            return false;
		if ($this->mysqldb['debug'] == true)
			var_dump("DELETE FROM `$table` WHERE $conditions");
        return $this->execute("DELETE FROM `$table` WHERE $conditions");
    }
	function drop($table = null)
	{
		$table = $this->mysqldb['prefix'].$table;
        if ($table === null)
            return false;
        return $this->execute("DROP TABLE IF EXISTS `$table`");
	}
 	function create($table = null, $columns)
    {
    	$table = $this->mysqldb['prefix'].$table;
        if ($table === null)
            return false;
        return $this->execute("CREATE TABLE IF NOT EXISTS `$table` ($columns) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
    }
    function exists($table = null){
        $table = $this->mysqldb['prefix'].$table;
        if ($table === null)
            return false;
        if ($this->row(array('table' => $table)) == false){
            return false;
        }else{
            return true;
        }
    }
    function escape($data){
        return mysql_real_escape_string($data,$this->con);
    }
	function getPrefix(){
		$table = $this->mysqldb['prefix'];
        if ($table === null || empty($array_of_values))
            return "";
		return $table;
	}
}
?>
