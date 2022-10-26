<?php
class User{
   
    // database connection and table name
   private $conn;

    // object properties
   public $user_id;
   public $name;
   public $email;
   public $password;
   public $role;
   public $organization_id;
   public $first_name;
   public $last_name;
   public $status;
   public $gender;
   public $age;
   public $coordinator_id;

    // constructor with $db as database connection
   public function __construct($db){
      $this->conn = $db;
   }
   
   // create user coordinator
   function createUserCoordinator()
   {

      // create data query and insert query
      $insert_to_user = "INSERT INTO users SET email=:email, password=:password, role=:role, status=:status";
      $insert_to_coordinator = "INSERT INTO coordinators SET coordinator_id=:coordinator_id, first_name=:first_name, last_name=:last_name, organization_id=:organization_id, gender=:gender, age=:age";
      
      // prepare query
      $stmt = $this->conn->prepare($insert_to_user);
      $stmt2 = $this->conn->prepare($insert_to_coordinator);

      // sanitize
      $this->email=htmlspecialchars(strip_tags($this->email));
      $this->password=htmlspecialchars(strip_tags($this->password));
      $this->role=htmlspecialchars(strip_tags($this->role));
      $this->status=htmlspecialchars(strip_tags($this->status));
      $this->coordinator_id=htmlspecialchars(strip_tags($this->coordinator_id));
      $this->first_name=htmlspecialchars(strip_tags($this->first_name));
      $this->last_name=htmlspecialchars(strip_tags($this->last_name));
      $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));
      $this->age=htmlspecialchars(strip_tags($this->age));
      $this->gender=htmlspecialchars(strip_tags($this->gender));

      // bind values
      $stmt->bindParam(":email", $this->email);
      $stmt->bindParam(":password", $this->password);
      $stmt->bindParam(":role", $this->role);
      $stmt->bindParam(":status", $this->status);
      $stmt2->bindParam(":coordinator_id", $this->coordinator_id);
      $stmt2->bindParam(":first_name", $this->first_name);
      $stmt2->bindParam(":last_name", $this->last_name);
      $stmt2->bindParam(":organization_id", $this->organization_id);
      $stmt2->bindParam(":age", $this->age);
      $stmt2->bindParam(":gender", $this->gender);

      // execute query
      if($stmt->execute()){
         $this->user_id = $this->conn->lastInsertId();
         $stmt2->execute();
         return true;
      }
      return false;
   }

   // read single user
   function readOne()
   {
      // query to read single record
      $query = "SELECT * FROM users WHERE user_id = ?";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind id of product to be updated
      $stmt->bindParam(1, $this->user_id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->user_id = $row['user_id'];
      $this->name = $row['name'];
      $this->email = $row['email'];
      $this->password = $row['password'];
      $this->role = $row['role'];
      $this->organization_id = $row['organization_id'];
      $this->status = $row['status'];
   }

   // update the user
   function update(){
      
      // update query
      $query = "UPDATE users SET name = :name, email = :email, password = :password, role = :role WHERE user_id = :user_id";
      
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      
      // bind new values
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':role', $this->role);
      $stmt->bindParam(':user_id', $this->user_id);
      
      // execute the query
      if($stmt->execute()){
         return true;
      }
      
      return false;
   }
}