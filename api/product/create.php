<?php
// Required Headers for create
header("Access-Control-Allow-Origin: *");
//the media type of the resource
header("Content-Type: application/json; charset=UTF-8");
//allowed methods - in this example post
header("Access-Control-Allow-Methods: POST");
//max num seconds results can be cached
header("Access-Control-Max-Age: 3600");
//what headers can be used in this http request
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get the database connection
include_once "../config/database.php";

//instanciate the product object
include_once "../objects/product.php";

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

//get the posted data
$data = json_decode(file_get_contents("php://input"));

//make sure the data is not empty when the user is creating a product (thing todo on the sesh)
if(
    !empty($data->title) 
) {
    // set the product property values
    $product->title = $data->title;
    $product->created = date("Y/m/d");

    //create the product
    if($product->create())
    {
        //set 201 response = created
        http_response_code(201);
        //tell the user
        echo json_encode(array("message" => "Sesh Item Created"));

    } else {
        // 503 response
        http_response_code(503);

        echo json_encode(array("message" => "Unable to create Sesh Item"));
    }
} else {
    // the data the user is trying to create is incomplete as title and created is empty
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Sesh Item. Data is Incomplete"));
}
?>



