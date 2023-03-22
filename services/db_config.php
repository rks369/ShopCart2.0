<?php
class DataBase{
    public $connection;

    public function __construct()
    {
        $host        = "host = 127.0.0.1";
        $port        = "port = 5432";
        $dbname      = "dbname = ShopCart";
        $credentials = "user = postgres password=123456";

        $this->connection = pg_connect( "$host $port $dbname $credentials"  );
    }

    public function excecuteQuery($query) 
    {

        if (!pg_connection_busy($this->connection)) {
            pg_send_query($this->connection,$query);
        }
        
        $res1 = pg_get_result($this->connection);
        if(!$res1){
            return 'done';
        }else{

            return pg_result_error($res1);
        }


    }

    public function __destruct()
    {
        // pg_close($this->connection);
    }
}
