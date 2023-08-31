<?php
class Database
{
    private $connection; // Database connection

    public static function instance($host, $username, $password, $database)
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new Database($host, $username, $password, $database);
        }
        return $instance;
    }

    // Constructor
    public function __construct($host, $username, $password, $database)
    {
        $this->connection = $this->connect($host, $username, $password, $database);
    }

    // Connect to the database
    private function connect($host, $username, $password, $database)
    {
        $connection = mysqli_connect($host, $username, $password, $database);

        // Check connection
        if (mysqli_connect_errno())
        {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

        return $connection;
    }

    // Execute an SQL query
    public function execute_query($query)
    {
        $result = mysqli_query($this->connection, $query);

        // Check for errors
        if (!$result)
        {
            return mysqli_error($this->connection);
        }

        return $result;
    }

    // Perform a SELECT query with JOIN operations. Tables and Columns have to be arrays even if it is just one.
    //SELECT columns FROM table JOIN table ON clause LEFT JOIN table ON clause WHERE clause ORDER BY clause LIMIT limit,
    //public function 
    /* WITH cte AS (
    SELECT
        department_id,
        AVG(salary) AS avg_salary
    FROM
        employees
    WHERE
        salary > 50000
    GROUP BY
        department_id
    HAVING
        COUNT(*) > 2
    )
    SELECT
        e.employee_id,
        e.first_name || ' ' || e.last_name AS full_name,
        e.salary,
        d.department_name,
        CASE
            WHEN e.salary > c.avg_salary THEN 'Above Avg'
            ELSE 'Below Avg'
        END AS salary_status
    FROM
        employees e
    JOIN
        departments d ON e.department_id = d.department_id
    LEFT JOIN
        cte c ON d.department_id = c.department_id
    WHERE
        e.salary > 45000
    ORDER BY
        e.salary DESC
    LIMIT 10;
 */
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
            $condition .= "$table$column $value[1] " . (is_array($value[0]) ? $value[0][0] . "." . $value[0][1] : "'" . $value[0] . "'") . " " . (isset($value[2]) ? $value[2] : '');
        }
        //return $condition = rtrim($condition, ', ');
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

    /*public function select($tables, $columns = '*', $joins = '', $conditions = array(), $order = '', $limit = '', $or_and = "AND", $gt_lt = '=', $fuzzy = false)
    {


        if (!is_array($columns))
            $columns = array($columns);
        if (!is_array($tables))
            $tables = array($tables);
        if (!is_array($joins))
            $joins = array($joins);

        $query = "SELECT " . implode(', ', $columns);
        $query .= " FROM " . implode(', ', $tables);

        if (!empty($joins))
        {
            $query .= " " . implode(' ', $joins);
        }


        $condition = empty($gt_lt) ? '=' : $gt_lt;
        $wildcard = '';
        if ($fuzzy)
        {
            $condition = 'LIKE';
            $wildcard = '%';
        }


        if (!empty($conditions))
        {
            $whereConditions = array();
            foreach ($conditions as $column => $value)
            {
                $escaped_value = mysqli_real_escape_string($this->connection, $value);
                $whereConditions[] = "$column $condition '$wildcard$escaped_value$wildcard'";
            }
            $query .= " WHERE " . implode(" $or_and ", $whereConditions);
        }

        if (!empty($order))
        {
            $query .= " ORDER BY " . $order;
        }

        if (!empty($limit))
        {
            $query .= " LIMIT " . $limit;
        }

        return $this->execute_query($query);
        //return $query;
    }*/

    // Perform an INSERT query. Columns has to be an array in the format (column => value)
    public function INSERT($statement, $execute = true)
    {
        $columns = implode(', ', array_keys($statement['data']));
        //$values = implode("', '", array_values($statement['data']));
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
        //echo $statement;    
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        if ($execute)
            $this->execute_query($query);

        return $execute ? mysqli_insert_id($this->connection) : $query;
    }

    // Perform an UPDATE query
    public function update($table, $columns, $conditions)
    {
        if (!is_array($conditions))
        {
            $conditions = array($conditions);
        }

        $wheres = array();

        foreach ($conditions as $where => $value)
        {
            $value = mysqli_real_escape_string($this->connection, $value);
            array_push($wheres, "$where = '$value'");
        }

        $set = '';
        foreach ($columns as $column => $value)
        {
            $value = mysqli_real_escape_string($this->connection, $value);
            $set .= "$column = '$value', ";
        }
        $set = rtrim($set, ', ');

        $conditions = implode(' AND ', $conditions);
        $wheres = implode(' AND ', $wheres);

        $query = "UPDATE $table SET $set WHERE $wheres";

        return $this->execute_query($query);
        //return $query;
    }

    // Perform a DELETE query
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

    // Close the database connection
    public function close()
    {
        mysqli_close($this->connection);
    }
}

?>