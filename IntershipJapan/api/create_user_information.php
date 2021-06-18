<?php
include_once 'layout/header.php';
include_once 'user_information.php';
// get database connection

$database = new Database();
$db = $database->getConnection();
// instantiate product object
$user_information = new User_information($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// set product property values
$user_information->email = (isset($data->email) ? $data->email : '');
$user_information->firstname = (isset($data->firstname) ? $data->firstname : '');
$user_information->lastname = (isset($data->lastname) ? $data->lastname : '');
$user_information->phoneNumber = (isset($data->phoneNumber) ? $data->phoneNumber : '');
$user_information->country = (isset($data->country) ? $data->country : '');
$user_information->middlename = (isset($data->middlename) ? $data->middlename : '');
$user_information->currentlyLiving = (isset($data->currentlyLiving) ? $data->currentlyLiving : '');
$user_information->fieldOfStudies = (isset($data->fieldOfStudies) ? $data->fieldOfStudies : '');
$user_information->alreadyGraduated = (isset($data->alreadyGraduated) ? $data->alreadyGraduated : '');
$user_information->currentUniverstiryStudent = (isset($data->currentUniverstiryStudent) ? $data->currentUniverstiryStudent : '');
$user_information->NativeLanguage = (isset($data->NativeLanguage) ? $data->NativeLanguage : '');
$user_information->language = (isset($data->language) ? $data->language : '');
$user_information->Linkedinprofile = (isset($data->Linkedinprofile) ? $data->Linkedinprofile : '');
$user_information->realEmploymeant = (isset($data->realEmploymeant) ? $data->realEmploymeant : '');
// create the user



if(
    !empty($user_information->email) &&
    !empty($user_information->firstname) &&
    !empty($user_information->lastname) &&
    $user_information->create()
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