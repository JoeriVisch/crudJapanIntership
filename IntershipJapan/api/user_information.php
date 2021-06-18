<?php
class User_information{
    private $conn;
    private $table_name = "user_information";

    public $email;
    public $firstname;
    public $lastname;
    public $phoneNumber;
    public $country;
    public $middlename;
    public $currentlyLiving;
    public $fieldOfStudies;
    public $alreadyGraduated;
    public $currentUniverstiryStudent;
    public $NativeLanguage;
    public $language;
    public $Linkedinprofile;
    public $realEmploymeant;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create(){
        $query = "INSERT INTO " . $this->table_name . "
            SET 
                email = :email,
                firstname = :firstname,
                lastname = :lastname,
                phoneNumber = :phoneNumber,
                country = :country,
                middlename = :middlename,
                currentlyLiving = :currentlyLiving,
                fieldOfStudies = :fieldOfStudies,
                alreadyGraduated = :alreadyGraduated,
                currentUniverstiryStudent = :currentUniverstiryStudent,
                NativeLanguage = :NativeLanguage,
                language = :language,
                Linkedinprofile = :Linkedinprofile,
                realEmploymeant = :realEmploymeant
               ";
        $stmt = $this->conn->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->middlename=htmlspecialchars(strip_tags($this->middlename));
        $this->currentlyLiving=htmlspecialchars(strip_tags($this->currentlyLiving));
        $this->fieldOfStudies=htmlspecialchars(strip_tags($this->fieldOfStudies));
        $this->alreadyGraduated=htmlspecialchars(strip_tags($this->alreadyGraduated));
        $this->currentUniverstiryStudent=htmlspecialchars(strip_tags($this->currentUniverstiryStudent));
        $this->NativeLanguage=htmlspecialchars(strip_tags($this->NativeLanguage));
        $this->language=htmlspecialchars(strip_tags($this->language));
        $this->Linkedinprofile=htmlspecialchars(strip_tags($this->Linkedinprofile));
        $this->realEmploymeant=htmlspecialchars(strip_tags($this->realEmploymeant));

        //bind the values
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
         $stmt->bindParam(':phoneNumber', $this->phoneNumber);
         $stmt->bindParam(':country', $this->country);
         $stmt->bindParam(':middlename', $this->middlename);
        $stmt->bindParam(':currentlyLiving', $this->currentlyLiving);
         $stmt->bindParam(':fieldOfStudies', $this->fieldOfStudies);
        $stmt->bindParam(':alreadyGraduated', $this->alreadyGraduated);
        $stmt->bindParam(':currentUniverstiryStudent', $this->currentUniverstiryStudent);
         $stmt->bindParam(':NativeLanguage', $this->NativeLanguage);
         $stmt->bindParam(':language', $this->language);
        $stmt->bindParam(':Linkedinprofile', $this->Linkedinprofile);
         $stmt->bindParam(':realEmploymeant', $this->realEmploymeant);
        $stmt->execute();
       
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function update(){
        $query = "UPDATE " . $this->table_name . "
            SET 
                email = :email,
                firstname = :firstname,
                lastname = :lastname,
                phoneNumber = :phoneNumber,
                country = :country,
                middlename = :middlename,
                currentlyLiving = :currentlyLiving,
                fieldOfStudies = :fieldOfStudies,
                alreadyGraduated = :alreadyGraduated,
                currentUniverstiryStudent = :currentUniverstiryStudent,
                NativeLanguage = :NativeLanguage,
                language = :language,
                Linkedinprofile = :Linkedinprofile,
                realEmploymeant = :realEmploymeant
                WHERE email = :email;
        ";
        $stmt = $this->conn->prepare($query);
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->middlename=htmlspecialchars(strip_tags($this->middlename));
        $this->currentlyLiving=htmlspecialchars(strip_tags($this->currentlyLiving));
        $this->fieldOfStudies=htmlspecialchars(strip_tags($this->fieldOfStudies));
        $this->alreadyGraduated=htmlspecialchars(strip_tags($this->alreadyGraduated));
        $this->currentUniverstiryStudent=htmlspecialchars(strip_tags($this->currentUniverstiryStudent));
        $this->NativeLanguage=htmlspecialchars(strip_tags($this->NativeLanguage));
        $this->language=htmlspecialchars(strip_tags($this->language));
        $this->Linkedinprofile=htmlspecialchars(strip_tags($this->Linkedinprofile));
        $this->realEmploymeant=htmlspecialchars(strip_tags($this->realEmploymeant));

        //bind the values
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':middlename', $this->middlename);
        $stmt->bindParam(':currentlyLiving', $this->currentlyLiving);
        $stmt->bindParam(':fieldOfStudies', $this->fieldOfStudies);
        $stmt->bindParam(':alreadyGraduated', $this->alreadyGraduated);
        $stmt->bindParam(':currentUniverstiryStudent', $this->currentUniverstiryStudent);
        $stmt->bindParam(':NativeLanguage', $this->NativeLanguage);
        $stmt->bindParam(':language', $this->language);
        $stmt->bindParam(':LinkedinProfile', $this->Linkedinprofile);
        $stmt->bindParam(':realEmploymeant', $this->realEmploymeant);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function readinformation(){
 
        // query to check if email exists
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE email LIKE ':email";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
        $mail = "%".$this->email."%";
        //bind the values
        $stmt->bindParam(':email', $mail);
       
     
        // execute the query
        $stmt->execute();
     
    }
}