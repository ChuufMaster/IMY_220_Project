<?php
class Database
{
    private $connection;

    public static function instance($host, $username, $password, $database)
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new Database($host, $username, $password, $database);
        }
        return $instance;
    }

    public function __construct($host, $username, $password, $database)
    {
        $this->connection = $this->connect($host, $username, $password, $database);
    }

    private function connect($host, $username, $password, $database)
    {
        $connection = new mysqli($host, $username, $password, $database);

        if ($connection->connect_error)
        {
            die('Failed to connect to MySQL: ' . $connection->connect_error);
        }

        return $connection;
    }

    public function execute_query($query)
    {
        $result = $this->connection->query($query);

        if (!$result)
        {
            return $this->connection->error;
        }

        return $result;
    }

    public function check_isset($statement, $key, $callback)
    {
        if (!isset($statement[$key]))
            return '';
        return $this->$callback($statement[$key]);
    }
    public function SELECT($statement, $execute = true)
    {
        $query = "SELECT ";
        if (!is_array($statement["tables"]))
        {
            $query .= isset($statement['columns']) ? $this->columns($statement['columns']) : '*';
            $query .= ' FROM ' . $statement['tables'];
            $query .= (isset($statement['where'])) ? (' WHERE ' . $this->conditionals($statement["where"])) : '';
            $query .= isset($statement['order_by']) ? $this->check_isset($statement, 'order_by', 'order_by') : '';
            $query .= isset($statement['limit']) ? " LIMIT $statement[limit] " : '';
            return $execute === true ? $this->execute_query($query) : $query;
        }

        if (isset($statement['columns']))
            for ($table_index = 0; $table_index < count($statement["tables"]); $table_index++)
            {
                $table = $statement["tables"][$table_index];
                $query .= $this->columns($statement["columns"][$table_index], $table);
            }
        else
            $query .= ' *';
        $query .= ' FROM ';
        for ($table_index = 0; $table_index < count($statement["tables"]); $table_index++)
        {
            $table = $statement["tables"][$table_index];
            $query .= $table . ' ' . $table;
        }
        if (isset($statement["join"]))
            $query .= $this->joins($statement["join"], "JOIN");
        if (isset($statement["left_join"]))
            $query .= $this->joins($statement["left_join"], "LEFT JOIN");
        if (isset($statement["right_join"]))
            $query .= $this->joins($statement["right_join"], "RIGHT JOIN");

        if (isset($statement["where"]))
        {
            $query .= " WHERE ";
            foreach ($statement["where"] as $table_name => $conditions)
            {
                $query .= $this->conditionals($conditions, $table_name) . ", ";
            }
            $query = rtrim($query, ", ");
        }

        if (isset($statement['order_by']))
        {
            $query .= ' ORDER BY ';
            foreach ($statement["order_by"] as $table_name => $order)
            {
                $query .= $this->order_by($order, $table_name) . ",";
            }
            $query = rtrim($query, ", ");
        }

        $query .= isset($statement['limit']) ? " LIMIT $statement[limit] " : '';
        return $execute === true ? $this->execute_query($query) : $query;
    }

    public function columns($columns, $table = '')
    {
        if (!isset($columns))
            return '*';
        if (!is_array($columns))
            return $columns;
        return implode(($table !== '' ? $table . '.' : '') . ', ', $columns);
    }

    public function conditionals($conditions, $table = '')
    {
        if (!isset($conditions) || empty($conditions))
            return '';
        $condition = '';
        $table = ($table !== '' ? $table . '.' : '');
        foreach ($conditions as $column => $value)
        {
            $condition .= "$table$column $value[1] " . (is_array($value[0]) ? $value[0][0] . "." . $value[0][1] : "'" . $value[0] . "'") . " " . (isset($value[2]) ? $value[2].' ' : '');
        }
        return $condition;
    }

    public function order_by($order_by, $table = '')
    {
        if (!isset($order_by))
            return '';
        $order_out = "";
        foreach ($order_by as $column => $order)
        {
            $order_out .= " $table.$column $order, ";
        }
        return $order_out = rtrim($order_out, ', ');
    }

    public function joins($join, $join_type)
    {
        $query = '';
        if (!isset($join))
            return '';
        for ($table_index = 0; $table_index < count($join["tables"]); $table_index++)
        {
            $query .= " $join_type ";
            $table = $join["tables"][$table_index];
            $query .= "$table $table ON ";
            foreach ($join["columns"][$table_index] as $column => $value)
            {
                $query .= "$table.$column $value[1] " . (is_array($value[0]) ? $value[0][0] . "." . $value[0][1] : $value[0]);
            }
        }
        return $query;

    }

    public function INSERT($statement, $execute = true)
    {
        $columns = implode(', ', array_keys($statement['data']));
        $values = '';
        foreach ($statement['data'] as $value)
        {
            if (!is_array($value))
            {
                $values .= "'" . $value . "', ";
            }
            else
            {
                $values .= $value[0] . ", ";
            }
        }
        $values = rtrim($values, ", ");
        $table = $statement['table'];
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        if ($execute)
           $result = $this->execute_query($query);

        return $execute ? $result : $query;
    }

    public function UPDATE($statement, $execute = true)
    {
        $values = '';
        foreach ($statement['data'] as $key => $value)
        {
            $values .= $key ."= '" . $value . "', "; 
        }
        
        $values = rtrim($values, ", ");
        $table = $statement['table'];
        
        $conditions = $this->conditionals($statement['where']);

        $query = "UPDATE $table SET $values WHERE $conditions";

        if ($execute)
            $this->execute_query($query);

        return $execute ? mysqli_insert_id($this->connection) : $query;
    }
    public function delete($table, $conditions)
    {
        if (!is_array($conditions))
        {
            $conditions = array($conditions);
        }

        $query = "DELETE FROM $table";

        $where_conditions = array();
        foreach ($conditions as $column => $value)
        {
            $escaped_value = mysqli_real_escape_string($this->connection, $value);
            $where_conditions[] = "$column = '$escaped_value'";
        }
        $query .= " WHERE " . implode(' AND ', $where_conditions);


        return $this->execute_query($query);
    }

    public function close()
    {
        mysqli_close($this->connection);
    }
}

?>