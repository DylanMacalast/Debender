<?php
namespace App\objects;
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
    public $audit_created;   

    // Constructor setting $conn to the database object
    // When this object is instanciated you need to pass in the database object!
    public function __construct($db) 
    {
        $this->conn = $db;
    }


    /**
     * Read method 
     * This will return all the data from the database tabel
     * NOTE: the endpoint for read is designed for read all - to get read all just change query
     * you could also change the limit to get more then 1 item
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
        //query to insert into db
        $query = "INSERT INTO 
                    " . $this->table_name . "
                 SET 
                    Title=:Title, Audit_created=:Audit_created";

        //prepare query
        $stmt = $this->conn->prepare($query);    

        //sanitize user inputed data
        $this->title = htmlspecialchars(strip_tags($this->title));

        //bind params
        $stmt->bindParam(':Title', $this->title);
        $stmt->bindParam(':Audit_created', $this->audit_created, \PDO::PARAM_STR, 12);


        
        //get errors
        $this->conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        // will return false if data is not added into the database
        return false;

    }

    /**
     * readOne method
     * GET one sesh item 
     **/
    public function readOne()
    {
        // query to read single record from db table
        $query = "SELECT 
                    *
                FROM
                    " . $this->table_name . " 
                    WHERE `ID` = ? 
                LIMIT 
                    0,1";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //bind params for id of product
        $stmt->bindParam(1, $this->id);

        //execute
        $stmt->execute();

        // get retrieved row from db table
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        //set values of this class propertys
        $this->title = $row["Title"];
        $this->audit_created = $row["Audit_created"];



    }



}
