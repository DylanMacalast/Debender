<?php

/**
 * This is the endpoint for the API 
 * It can be read by anyone *
 * Will return data in JSON format
 **/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files here - TODO: use composer autload for this once you have finished it!
include_once '../config/database.php';
include_once '../objects/product.php';

//instanciate the database and product object
$database = new Database();
$db = $database->getConnection();

//initialize the object
$product = new Product($db);

// query products
$stmt = $product->read();
$num = $stmt->rowCount();

// Check if more then 0 records found
if($num > 0){

    //products array
    $products_arr = array();
    $products_arr["records"]=array();

    //retrieve all db table contents
    //using fetch() as its quicker then fetchAll()
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extract row - makes $row['name'] = $name
        extract($row);
        $product_item = array(
            "ID" => $ID,
            "Title" => $Title,
            "Created" => $Created
        );

        array_push($products_arr["records"], $product_item);
    }
    // set the response code  - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($products_arr);
} else {
    // no products found here:
    // set http response
    http_response_code(404);

    echo json_encode(
        array("message" => "No Products Found")
    );

}



