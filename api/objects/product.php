<?php
/**
 * This class will act as a model to the API
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

    /**
     * Create method
     * This will allow the user to create data
     **/
    public function create()
    {

        //sanitize user inputed data
        $this->title = htmlspecialchars(strip_tags($this->title));

        //query to insert into db
        $query = "INSERT INTO " . $this->table_name . " SET Title='$this->title', Created='$this->created'";

        //prepare query
        $stmt = $this->conn->prepare($query);    

        //get errors
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        //execute query
        if($stmt->execute())
        {
            return true;
        }

        // will return false if data is not added into the database
        return false;

    }



}
