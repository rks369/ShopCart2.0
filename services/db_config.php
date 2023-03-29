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

    public function beginTransaction()
    {
        $this->execute("BEGIN");
    }

    public function commitTransaction()
    {
        $this->execute("COMMIT");
    }
    public function rollBackTransaction()
    {
        $this->execute("ROLLBACK");
    }

    public function execute($query)
    {

        if (!pg_connection_busy($this->connection)) {
            pg_send_query($this->connection, $query);
        }

        $res = pg_get_result($this->connection);
        if($res)
        {
            if (pg_result_error($res)) {

                throw new Exception('Not Able to Execute Query'.pg_result_error($res));
            } else {
                $result = [];
                while ($result[] = pg_fetch_array($res, NULL, PGSQL_ASSOC));
                array_pop($result);
                return $result;
            }
        }else{

        }
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
        $res =  pg_insert($this->connection, $table, $data);
        if ($res) {
            return 'Sucess';
        } else {
            return null;
        }
    }

    public function update($table, $data, $condition)
    {
        $res =  pg_update($this->connection, $table, $data, $condition);
        if ($res) {
            return 'Sucess';
        } else {
            throw new Exception('Not Able to Update Data Base');

        }
    }

    public function updateWithException($table, $data, $condition)
    {
        $res =  pg_update($this->connection, $table, $data, $condition);
        if ($res) {
            return 'Sucess';
        } else {
            return 'Error';
        }
    }

    public function delete($table, $condition)
    {
        $res =  pg_delete($this->connection, $table, $condition);
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
