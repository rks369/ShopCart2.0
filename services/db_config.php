<?php
class DataBase
{
    public $connection;

    public function __construct()
    {
        $host        = "host = 127.0.0.1";
        $port        = "port = 5432";
        $dbname      = "dbname = ShopCart";
        $credentials = "user = postgres password=123456";

        $this->connection = pg_connect("$host $port $dbname $credentials");
    }

    public function select($table, $conditions = array())
    {
        $res =  pg_select($this->connection, $table, $conditions);
        if ($res) {
            return $res;
        } else {
            return null;
        }
    }

    public function insert($table, $data)
    {
        $res =  pg_insert($this->connection, $table, $data, PGSQL_DML_EXEC);
        if ($res) {
            return 'Sucess';
        } else {
            return 'Error';
        }
    }

    public function __destruct()
    {
        pg_close($this->connection);
    }
}
