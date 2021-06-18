<?php
include_once 'layout/header.php';
include_once 'objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
// set product property values
$user->email = (isset($data->email) ? $data->email : '');
$user->roll = (isset($data->roll) ? $data->roll : '');
$user->password = (isset($data->password) ? $data->password : '');

// create the user
if(
    !empty($user->email) &&
    !empty($user->roll) &&
    !empty($user->password) &&
    $user->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}