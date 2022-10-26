<?php
   session_start();
   require '../../config/config.php';
   
   if(isset($_POST['create'])){
      if(empty($_POST['org_name']) || empty($_POST['org_address']) || empty($_POST['org_email']) || empty($_POST['org_description'])){
         $error = "All fields are required";
      }else if(!filter_var($_POST['org_email'], FILTER_VALIDATE_EMAIL)){
         $error = "Invalid email address";
      }else{
         $org_name = $_POST['org_name'];
         $org_address = $_POST['org_address'];
         $org_email = $_POST['org_email'];
         $org_description = $_POST['org_description'];
         
         $sql = "INSERT INTO organizations (org_name, org_description, org_email, org_address) VALUES (:org_name, :org_description, :org_email, :org_address)";
         $stmt = $conn->prepare($sql);
         $stmt->execute(
            array(
               ':org_name' => $org_name,
               ':org_description' => $org_description,
               ':org_email' => $org_email,
               ':org_address' => $org_address
            )
         );

         if($stmt){
            // display success message
            $_SESSION['success'] = 'Organization ' . $org_name . ' created successfully';
            header('location: index.php');
         }else{
            $error = 'Something went wrong. Please try again';
         }
      }
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
            <a href="index.php" class="link-primary" style="font-size: 22px;"><i class="fas fa-angle-left"></i>
               Back</a>
         </nav>
         <!-- End of Topbar -->
         <?php
            if(isset($error)){
               echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
         ?>
         <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
               <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-building"></i> Create Organization</h1>
            </div>
            <div class="card-body">
               <form action="create.php" method="POST">
                  <div class="row mb-3">
                     <div class="col-md-4">
                        <label for="org_name">Name</label>
                        <input type="text" name="org_name" id="org_name" class="form-control"
                           value="<?php if(isset($_POST['org_name'])){ echo $_POST['org_name']; } ?>"
                           placeholder="Enter Organization Name">
                     </div>
                     <div class="col-md-4">
                        <label for="org_email">Email</label>
                        <input type="email" name="org_email" id="org_email" class="form-control"
                           value="<?php if(isset($_POST['org_email'])){ echo $_POST['org_email']; } ?>"
                           placeholder="Enter Organization Email">
                     </div>
                     <div class="col-md-4">
                        <label for="org_address">Address</label>
                        <input type="text" name="org_address" id="org_address" class="form-control"
                           value="<?php if(isset($_POST['org_address'])){ echo $_POST['org_address']; } ?>"
                           placeholder="Enter Organization Address">
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col-md-12">
                        <label for="org_description">Description</label>
                        <textarea name="org_description" id="org_description" class="form-control"
                           placeholder="Enter Organization Description"><?php if(isset($_POST['org_description'])) { echo $_POST['org_description']; } ?></textarea>
                     </div>
                  </div>
                  <button type="submit" name="create" class="btn btn-primary"><i class="fas fa-plus"></i>
                     Create</button>
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