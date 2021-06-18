<?php
// 'user' object
class UserSearch{
 
    // database connection and table name
    private $conn;
 
    // object properties
    public $search;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 

    // check if given email exist in the database
    function search(){
        // query to check if email exists
        $query = "SELECT * FROM user_information
        WHERE fieldOfStudies LIKE :search ";
    
        // prepare the query
        $stmt = $this->conn->prepare( $query );
    
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->search));
        $s = "%".$this->search."%";  

        // bind given email value
        $stmt->bindParam(':search', $s);
    
        // execute the query
        $stmt->execute();
    
        // get number of rows
        $num = $stmt->rowCount();
    
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
    
            // get record details / values
        
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // return true because email exists in the database
            return $rows;
        }
    
        // return false if email does not exist in the database
        return false;
    }

    function search2(){
        // query to check if email exists
        $query = "SELECT * FROM user_information
        WHERE email LIKE :email ";
    
        // prepare the query
        $stmt = $this->conn->prepare( $query );
    
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->search));
        $s = "%".$this->search."%";  

        // bind given email value
        $stmt->bindParam(':email', $s);
    
        // execute the query
        $stmt->execute();
    
        // get number of rows
        $num = $stmt->rowCount();
    
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
    
            // get record details / values
        
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // return true because email exists in the database
            return $rows;
        }
    
        // return false if email does not exist in the database
        return false;
    }

}