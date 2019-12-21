<?php
/**
 * This class will act as a model to the API
 * TODO: Need to create a query wich will get a random ID from the database each time it is called
 **/
class Product
{
    // database connection and table name within that database
    private $conn;
    private $table_name = "products";

    // Object properties
    public $id;
    public $title;
    public $created;   

    // Constructor setting $conn to the database object
    // When this object is instanciated you need to pass in the database object!
    public function __construct($db) 
    {
        $this->conn = $db;
    }


    /**
     * Read method 
     * This will return all the data from the database tabel
     **/
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY RAND() LIMIT 1";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;
    }



}
