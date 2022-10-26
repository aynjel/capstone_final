<?php
   session_start();
   require '../../config/config.php';

   if(isset($_GET['id'])){
      $id = $_GET['id'];
      $delete_coordinator = "DELETE FROM students WHERE student_id = :id";
      $stmt = $conn->prepare($delete_coordinator);
      $stmt->execute(
         array(
            'id' => $id
         )
      );
      $_SESSION['success'] = "Student deleted successfully";
      header("location: index.php");
   }else{
      header("location: index.php");
   }