<?php
// generate json web token
include_once 'layout/header.php';
include_once 'config/core.php';
include_once 'objects/user_search.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

//make search object
$user_search = new UserSearch($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$search = (isset($data->search) ? $data->search : '');

// check if email exists and if password is correct
if($search != ''){
    $user_search->search = $search;
  
    $results = $user_search->search();
    echo json_encode($results);

} else {
 
    // set response code
    http_response_code(204);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}

?>