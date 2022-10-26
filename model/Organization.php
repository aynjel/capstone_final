<?php
class Organization{
   // DB stuff
   private $conn;
   private $table = 'organizations';

   // Organization Properties
   public $org_id;
   public $name;
   public $description;
   public $address;
   public $email;
   

   // Constructor with DB
   public function __construct($db){
      $this->conn = $db;
   }

   // create organization
   function create(){
      // query to insert record
      $query = 'INSERT INTO ' . $this->table . ' SET org_name = :name, org_description = :description, org_address = :address, org_email = :email';

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->name=htmlspecialchars(strip_tags($this->name));
      $this->description=htmlspecialchars(strip_tags($this->description));
      $this->address=htmlspecialchars(strip_tags($this->address));
      $this->email=htmlspecialchars(strip_tags($this->email));

      // bind values
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':address', $this->address);
      $stmt->bindParam(':email', $this->email);

      // execute query
      if($stmt->execute()){
         return true;
      }

      return false;
   }

   // read all organizations by id
   function read(){
      // select all query
      $query = 'SELECT * FROM ' . $this->table . ' ORDER BY org_id DESC';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // execute query
      $stmt->execute();

      return $stmt;
   }
   
   // read single organization for specific id
   function readOne(){
      // query to read single record
      $query = 'SELECT * FROM ' . $this->table . ' WHERE org_id = ?';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind id of organization to be updated
      $stmt->bindParam(1, $this->id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->name = $row['org_name'];
      $this->description = $row['org_description'];
      $this->address = $row['org_address'];
      $this->email = $row['org_email'];
   }

   // find by id
   function find($id){
      // query to read single record
      $query = 'SELECT * FROM ' . $this->table . ' WHERE org_id = ?';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind id of organization to be updated
      $stmt->bindParam(1, $id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->name = $row['name'];
      $this->description = $row['description'];
      $this->address = $row['address'];
      $this->email = $row['email'];

      return $this;
   }
   // update the organization
   function update(){
      // update query
      $query = 'UPDATE ' . $this->table . ' SET org_name = :name, org_description = :description, org_address = :address, org_email = :email WHERE org_id = :id';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind new values
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':address', $this->address);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':id', $this->id);

      // execute the query
      if($stmt->execute()){
         return true;
      }

      return false;
   }

   // delete the organization
   function delete(){
      // delete query
      $query = 'DELETE FROM ' . $this->table . ' WHERE org_id = ?';

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->id=htmlspecialchars(strip_tags($this->id));

      // bind id of record to delete
      $stmt->bindParam(1, $this->id);

      // execute query
      if($stmt->execute()){
         return true;
      }

      return false;
   }

   // select organization to be deleted
   function selectOne(){
      // query to read single record
      $query = 'SELECT * FROM ' . $this->table . ' WHERE org_id = ?';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind id of organization to be updated
      $stmt->bindParam(1, $this->id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->name = $row['name'];
      $this->description = $row['description'];
      $this->address = $row['address'];
      $this->email = $row['email'];
   }

   //get organization name of a specific id
   function getOrganizationName($id){
      // query to read single record
      $query = 'SELECT name FROM ' . $this->table . ' WHERE org_id = ?';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind id of organization to be updated
      $stmt->bindParam(1, $id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      return $row['name'];
   }

   // read all organizations
   function readAll(){
      // select all query
      $query = 'SELECT * FROM ' . $this->table . ' ORDER BY name';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // execute query
      $stmt->execute();

      return $stmt;
   }
}