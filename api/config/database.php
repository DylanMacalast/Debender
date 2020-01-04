<?php

class Database
{
    private $host = "vlvlnl1grfzh34vj.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
    private $db_name = "dcwwlhsbw34cjcah";
    private $username = "oo99hwn9jv2h6ezv";
    private $password= "vk9n5tj0cd0xd857";
    public $conn;

    //get database connection
    public function getConnection()
    {
        $this->conn = null;

        try{

            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

            $this->conn->exec("set names utf8");

        } catch(PDOException $exception) {

            echo "connection error: " . $exception->getMessage();

        }

        return $this->conn;

    }
}


