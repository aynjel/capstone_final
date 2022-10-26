<?php
   session_start();
   require '../../config/config.php';

   if (isset($_GET['id'])) {
      $id = $_GET['id'];

      // show the organization
      $sql = "SELECT * FROM organizations WHERE org_id = :org_id";
      $stmt = $conn->prepare($sql);
      $stmt->execute(['org_id' => $id]);
      $organization = $stmt->fetch(PDO::FETCH_OBJ);

   }
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <title>Organization Details</title>

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
            <a href="index.php" class="link-primary" style="font-size: 22px;"><i class="fas fa-angle-left"></i>
               Back
            </a>
            <div></div>
         </nav>
         <!-- End of Topbar -->
         <?php
            // display success message
            if (isset($_SESSION['success'])) {
               echo '
                  <div class="alert alert-success" role="alert">
                     ' . $_SESSION['success'] . '
                  </div>
               ';
               unset($_SESSION['success']);
            }
         ?>

         <div class="card shadow mb-4">
            <div class="card-header">
               <h1 class="h4 text-gray-800"><i class="fas fa-building"></i> Organizations</h1>
               <a href="create.php" class="btn btn-primary btn-icon-split float-right">
                  <span class="icon text-white-50">
                     <i class="fas fa-plus"></i>
                  </span>
                  <span class="text">Create</span>
               </a>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="card">
                        <div class="card-body">
                           <h5 class="card-title"><?php echo $organization->org_name; ?></h5>
                           <p class="card-text"><?php echo $organization->org_address; ?></p>
                           <p class="card-text"><?php echo $organization->org_email; ?></p>
                           <p class="card-text"><?php echo $organization->org_description; ?></p>
                           <a href="edit.php?id=<?php echo $organization->org_id; ?>"
                              class="btn btn-primary btn-icon-split">
                              <span class="icon text-white-50">
                                 <i class="fas fa-edit"></i>
                              </span>
                              <span class="text">Edit</span>
                           </a>
                           <a href="delete.php?id=<?php echo $organization->org_id; ?>"
                              onclick="return confirm('Are you sure you want to delete this organization?')"
                              class="btn btn-danger btn-icon-split">
                              <span class="icon text-white-50">
                                 <i class="fas fa-trash"></i>
                              </span>
                              <span class="text">Delete</span>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
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