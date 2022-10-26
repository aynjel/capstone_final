<?php
   session_start();
   require '../../config/config.php';

   // set id property of organization to be deleted
   if (isset($_GET['id'])) {
      $id = $_GET['id'];

      // delete the organization
      $sql = "DELETE FROM organizations WHERE org_id = :org_id";
      $stmt = $conn->prepare($sql);
      $stmt->execute(['org_id' => $id]);

      // set success message with organization name
      $_SESSION['success'] = 'Organization deleted successfully';
      header('location: index.php');
   }else{
      // set error message
      $_SESSION['error'] = 'Something went wrong in deleting organization';
      header('location: index.php');
   }