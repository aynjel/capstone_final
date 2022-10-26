<?php
   session_start();
   require '../../config/config.php';

   if(isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM organizations WHERE org_id = $id";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $org = $stmt->fetch(PDO::FETCH_OBJ);

      // if the form was submitted
      if (isset($_POST['update'])) {
         // get the form data
         $org_name = $_POST['org_name'];
         $org_address = $_POST['org_address'];
         $org_email = $_POST['org_email'];
         $org_description = $_POST['org_description'];

         // update the record
         $sql = "UPDATE organizations SET org_name = :org_name, org_address = :org_address, org_email = :org_email, org_description = :org_description WHERE org_id = :org_id";
         $stmt = $conn->prepare($sql);
         $stmt->execute(['org_name' => $org_name, 'org_address' => $org_address, 'org_email' => $org_email, 'org_description' => $org_description, 'org_id' => $id]);

         // redirect to the show page and display success message using session with organization name
         $_SESSION['success'] = 'Organization ' . $org_name . ' updated successfully';
         header('Location: show.php?id=' . $id);
         exit();
      }
   }else {
      header('Location: index.php');
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <title>Create Organization</title>

   <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- Custom styles for this template-->
   <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

   <!-- Content Wrapper -->
   <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" class="container-fluid">

         <!-- Topbar -->
         <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow rounded d-flex justify-content-between">
            <a href="show.php?id=<?php echo $org->org_id; ?>" class="btn btn-primary">Back</a>
         </nav>


         <!-- End of Topbar -->


         <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
               <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-building"></i> Update Organization</h1>
            </div>
            <div class="card-body">
               <?php
                  
               ?>
               <form action="edit.php?id=<?php echo $org->org_id; ?>" method="POST">
                  <div class="row">
                     <div class="col-md-6">
                        <label for="org_name">Name</label>
                        <input type="text" name="org_name" id="org_name" class="form-control"
                           placeholder="Enter Organization Name" value="<?php echo $org->org_name; ?>">
                     </div>
                     <div class="col-md-6">
                        <label for="org_email">Email</label>
                        <input type="email" name="org_email" id="org_email" class="form-control"
                           placeholder="Enter Organization Email" value="<?php echo $org->org_email; ?>">
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-md-6">
                        <label for="org_address">Address</label>
                        <input type="text" name="org_address" id="org_address" class="form-control"
                           placeholder="Enter Organization Address" value="<?php echo $org->org_address; ?>">
                     </div>
                     <div class="col-md-6">
                        <label for="org_description">Description</label>
                        <input type="text" name="org_description" id="org_description" class="form-control"
                           placeholder="Enter Organization Description" value="<?php echo $org->org_description; ?>">
                     </div>
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary" name="update"
                     onclick="return confirm('Are you sure you want to Update?')">Save</button>
               </form>
            </div>
         </div>

      </div>

   </div>
   <!-- End of Content Wrapper -->

   <!-- Scroll to Top Button-->
   <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
   </a>



   <script src="../../assets/vendor/jquery/jquery.min.js"></script>
   <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
   <script src="../../assets/vendor/chart.js/Chart.min.js"></script>
   <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

   <!-- Custom scripts for all pages-->
   <script src="../../assets/js/sb-admin-2.min.js"></script>
   <!--
      <script src="../assets/js/demo/chart-area-demo.js"></script>
      <script src="../assets/js/demo/chart-pie-demo.js"></script>
      -->

</body>

</html>