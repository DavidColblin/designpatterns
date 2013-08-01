<?php

class Database
{

    private $result;
    private $select = 'SELECT * FROM ';
    private $where = ' WHERE ';
    private $limit = ' LIMIT ';
    private $like = ' LIKE ';
    private static $connection;

    public static function createConnection()
    {
        if (empty(self::$connection))
        {
            self::$connection = new Database('localhost', 'root', '', 'utm_dpatterns');
        }

        return self::$connection;
    }

    private function __construct($host = 'localhost', $user = 'root', $password = '', $database = 'utm_dpatterns')
    {
        // connect to MySQL and select database
        if (!$conId = mysql_connect($host, $user, $password))
        {
            throw new Exception('Error connecting to the server');
        }
        if (!mysql_select_db($database, $conId))
        {
            throw new Exception('Error selecting database');
        }
    }

    // run SQL query
    public function custom_query($query)
    {
        $this->query($query);
        $rows = array();
        while ($row = $this->fetchRow())
        {
            $rows[] = $row;
        }
        return $rows;
    }
    
    // run SQL query
    public function query($query)
    {
        if (!$this->result = mysql_query($query))
        {
            throw new Exception('Error performing query ' . $query);
        }
    }

    // fetch one row
    public function fetchRow()
    {
        while ($row = mysql_fetch_array($this->result))
        {
            return $row;
        }
        return false;
    }

    // fetch all rows
    public function fetchAll($table = 'default_table')
    {
        $this->query('SELECT * FROM ' . $table);
        $rows = array();
        while ($row = $this->fetchRow())
        {
            $rows[] = $row;
        }
        return $rows;
    }

    // insert row
    public function insert($params = array(), $table = 'default_table')
    {

        $fields = implode(',', array_keys($params));
        $values = ('' . implode("','", array_values($params)) . '');
        $sql = "INSERT INTO $table ($fields) VALUES ('$values')";
        $this->query($sql);
    }

    // update row
    public function update($params = array(), $where, $table = 'default_table')
    {
        $args = array();
        foreach ($params as $field => $value)
        {
            $args[] = $field . '=' . "'" . $value . "'";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $args) . $this->where . $where;
        $this->query($sql);
    }

    // delete one or multiple rows
    public function delete($where = '', $table = 'default_table')
    {
        $sql = !$where ? 'DELETE FROM ' . $table : 'DELETE FROM ' . $table . $this->where . $where;
        $this->query($sql);
    }

    // fetch rows using 'WHERE' clause
    public function fetchWhere($where, $table = 'default_table')
    {
        $this->query($this->select . $table . $this->where . $where);
        $rows = array();
        while ($row = $this->fetchRow())
        {
            $rows[] = $row;
        }
        return $rows;
    }

    // fetch rows using 'LIKE' clause
    public function fetchLike($field, $like, $table = 'default_table')
    {
        $this->query($this->select . $table . $this->where . $field . $this->like . $like);
        $rows = array();
        while ($row = $this->fetchRow())
        {
            $rows[] = $row;
        }
        return $rows;
    }

    // fetch rows using 'LIMIT' clause
    public function fetchLimit($offset = 1, $numrows = 1, $table = 'default_table')
    {
        $this->query($this->select . $table . $this->limit . $offset . ',' . $numrows);
        $rows = array();
        while ($row = $this->fetchRow())
        {
            $rows[] = $row;
        }
        return $rows;
    }

}