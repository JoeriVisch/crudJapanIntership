<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $email;
    public $roll;
    public $password;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
    
 
// create new user record
    function create(){
    
        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    email = :email,
                    password = :password,
                    roll = :roll,
                    Created = NOW()";
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->roll=htmlspecialchars(strip_tags($this->roll));
        $this->password=htmlspecialchars(strip_tags($this->password));
    
        // bind the values
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':roll', $this->roll);
    
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // check if given email exist in the database
function emailExists(){
 
    // query to check if email exists
    $query = "SELECT id, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind given email value
    $stmt->bindParam(1, $this->email);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // if email exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // assign values to object properties
        $this->id = $row['id'];
        $this->password = $row['password'];
 
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}

    public function rollCheck(){
        $query = "SELECT roll FROM " . $this->table_name . "
            WHERE id = ?
        ";
        $stmt = $this->conn->prepare( $query );
 
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind given email value
        $stmt->bindParam(1, $this->email);
     
        // execute the query
        $stmt->execute();
    }
    public function update(){
        //var_dump($this->password);
        // if password needs to be updated
        //$password_set=!empty($this->password) ? " password = :password" : "";
        //if(empty($password_set)) {
        //    return false;
        //}
        // if no posted password, do not update the password
        $query = "UPDATE " . $this->table_name . "
                SET
                    password = :password
                WHERE email = :email";
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        //$this->firstname=htmlspecialchars(strip_tags($this->firstname));
        //$this->lastname=htmlspecialchars(strip_tags($this->lastname));
        //$this->email=htmlspecialchars(strip_tags($this->email));
    
        // bind the values from the form
        //$stmt->bindParam(':firstname', $this->firstname);
        //$stmt->bindParam(':lastname', $this->lastname);
        //$stmt->bindParam(':email', $this->email);
    
        // hash the password before saving to database
        /*if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }*/
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        // unique ID of record to be edited
        $stmt->bindParam(':email', $this->email);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
}
