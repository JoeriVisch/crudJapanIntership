<?php
include_once 'layout/header.php';
// required to encode json web token
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once 'user_information.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$user_information = new User_information($db);
 
// retrieve given jwt here
// get posted data
var_dump(file_get_contents("php://input"));
$data = json_decode(file_get_contents("php://input"));
var_dump($data);
var_dump($_POST);
var_dump($_FILES);
 
// get jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt){
 
    // if decode succeed, show user details
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        // set user property values
        $user_information->email = $data->email;
        $user_information->firstname = $data->firstname;
        $user_information->lastname = $data->lastname;
        $user_information->phoneNumber = $data->phoneNumber;
        $user_information->country = $data->country;
        $user_information->middlename = $data->middlename;
        $user_information->currentlyLiving = $data->currentlyLiving;
        $user_information->fieldOfStudies = $data->fieldOfStudies;
        $user_information->alreadyGraduated = $data->alreadyGraduated;
        $user_information->currentUniverstiryStudent = $data->currentUniverstiryStudent;
        $user_information->NativeLanguage = $data->NativeLanguage;
        $user_information->language = $data->language;
        $user_information->Linkedinprofile = $data->LinkedinProfile;
        $user_information->realEmploymeant = $data->realEmploymeant;

        if(empty($data->email) or !isset($data->email)){
            http_response_code(401);
            echo json_encode(
                array(
                    "message" => "Email was not provided.",
                    "jwt" => $jwt
                )
            );
        } else {
            //var_dump($user->update());
            if($user_information->update()){
                // regenerate jwt will be here
                $token = array(
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "iss" => $issuer,
                    "data" => array(
                        "email" => $user_information->email,
                        "firstname" => $user_information->firstname,
                        "lastname" => $user_information->lastname,
                        "phoneNumber" => $user_information->phoneNumber,
                        "country" => $user_information->country,
                        "middlename" => $user_information->middlename,
                        "currentlyLiving" => $user_information->currentlyLiving,
                        "fieldOfStudies" => $user_information->fieldOfStudies,
                        "alreadyGraduated" => $user_information->alreadyGraduated,
                        "currentUniverstiryStudent"=> $user_information->currentUniverstiryStudent,
                        "NativeLanguage" => $user_information->NativeLanguage,
                        "language" => $user_information->language,
                        "Linkedinprofile" => $user_information->Linkedinprofile,
                        "realEmploymeant" => $user_information->realEmploymeant
                    )
                 );
                 $jwt = JWT::encode($token, $key);
                  
                 // set response code
                 http_response_code(200);
                  
                 // response in json format
                 echo json_encode(
                         array(
                             "message" => "User was updated.",
                             "jwt" => $jwt
                         )
                     );
            }
            // message if unable to update user
            else{
                // set response code
                http_response_code(401);
                // show error message
                echo json_encode(array("message" => "Unable to update user."));
            }   
        }
        // update the user record   
    }
    // catch failed decoding will be here
    // if decode fails, it means jwt is invalid
    catch (Exception $e){
        // set response code
        http_response_code(401);
    
        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} // show error message if jwt is empty
else{
    // set response code
    http_response_code(401);
    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}