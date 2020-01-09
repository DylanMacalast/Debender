<?php
// autoloading classes
require __DIR__ .'/../config/bootstrap.php';
use \App\Includes\Models\BaseModel as BaseModel;
use \App\config\database as Database;
use \App\objects\product as Product;

/**
 * Read one item api endpoint
 **/

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");


// get db info
$database = new Database();
$db = $database->getConnection();

//prepare product object
$product = new Product($db);
//set id property of the id we want to read
// if no id set kill page
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of that product 
$product->readOne();
// if the title is not null then create data array
if($product->title !== null)
{
    $product_arr = array(
        "ID" => $product->id,
        "Title" => $product->title,
        "Audit_created" => $product->audit_created
    );

    //set response code
    http_response_code(200);

    //json
    echo json_encode($product_arr);
} else {
    // set response code
    http_response_code(404);
    echo json_encode(array("message" => "Sesh Item Does not Exist"));
}


