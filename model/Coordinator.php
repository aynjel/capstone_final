<?php
class Coordinator{
   
   // database connection and table name
   private $conn;
   private $table_name = "coordinators";

    // object properties
   public $id;
   public $coordinator_id;
   public $first_name;
   public $last_name;
   public $organization_id;
   public $gender;
   public $age;

    // constructor with $db as database connection
   public function __construct($db){
      $this->conn = $db;
   }

   // read coordinators
   function readOne()
   {
      // query to read single record
      $query = "SELECT * FROM coordinators WHERE coordinator_id = ?";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind id of product to be updated
      $stmt->bindParam(1, $this->id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->coordinator_id = $row['coordinator_id'];
      $this->first_name = $row['first_name'];
      $this->last_name = $row['last_name'];
      $this->organization_id = $row['organization_id'];
      $this->age = $row['age'];
      $this->gender = $row['gender'];
   }
   
   // update the coordinator
   function update(){
      
      // update query
      $query = "UPDATE coordinators SET first_name = :first_name, last_name = :last_name, organization_id = :organization_id, age = :age, gender = :gender WHERE coordinator_id = :coordinator_id";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->first_name=htmlspecialchars(strip_tags($this->first_name));
      $this->last_name=htmlspecialchars(strip_tags($this->last_name));
      $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));
      $this->id=htmlspecialchars(strip_tags($this->id));

      // bind new values
      $stmt->bindParam(':first_name', $this->first_name);
      $stmt->bindParam(':last_name', $this->last_name);
      $stmt->bindParam(':organization_id', $this->organization_id);
      $stmt->bindParam(':age', $this->age);
      $stmt->bindParam(':gender', $this->gender);
      $stmt->bindParam(':coordinator_id', $this->coordinator_id);

      // execute the query
      if($stmt->execute()){
         return true;
      }

      return false;
   }

   //get coordinators
   function read(){
         
         // select all query
         $query = "SELECT * FROM users INNER JOIN coordinators ON users.user_id = coordinators.coordinator_id";
         
         // prepare query statement
         $stmt = $this->conn->prepare($query);
         
         // execute query
         $stmt->execute();
         
         return $stmt;
   }

   // get organization name of coordinator
   function getOrganizationName(){
      $query = "SELECT * FROM organizations WHERE id = ?";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind id of product to be updated
      $stmt->bindParam(1, $this->organization_id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->organization_name = $row['name'];
   }

   // show coordinators
   function show(){
      $query = "SELECT * FROM coordinators WHERE user_id = ?";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind id of product to be updated
      $stmt->bindParam(1, $this->id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->id = $row['user_id'];
      $this->first_name = $row['first_name'];
      $this->last_name = $row['last_name'];
      $this->phone = $row['phone'];
      $this->address = $row['address'];
      $this->organization_id = $row['organization_id'];
   }
}