<?php
   require '../../config/config.php';
   session_start();

   if(isset($_POST['create'])){
      if(empty($_POST['email']) || 
         empty($_POST['password']) || 
         empty($_POST['first_name']) || 
         empty($_POST['last_name']) || 
         empty($_POST['age']) ||
         empty($_POST['gender']))
      {
         $error = 'All fields are required';
   } else {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $role = 'Coordinator';
      $status = 'Active';

      $insert_into_users = $conn->prepare("INSERT INTO users (email, password, role, status) VALUES (:email, :password, :role, :status)");
      $insert_into_users->execute([
         ':email' => $email,
         ':password' => $password,
         ':role' => $role,
         ':status' => $status
      ]);

      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $age = $_POST['age'];
      $gender = $_POST['gender'];
      $organization_id = $_POST['organization_id'];

      $insert_into_coordinator = $conn->prepare("INSERT INTO coordinators (coordinator_id, first_name, last_name, age, gender, organization_id) VALUES (:coordinator_id, :first_name, :last_name, :age, :gender, :organization_id)");
      $insert_into_coordinator->execute([
         ':coordinator_id' => $conn->lastInsertId(),
         ':first_name' => $first_name,
         ':last_name' => $last_name,
         ':age' => $age,
         ':gender' => $gender,
         ':organization_id' => $organization_id,
      ]);

      if ($insert_into_users && $insert_into_coordinator) {
         $_SESSION['success'] = 'Coordinator ' . $first_name . ' ' . $last_name . ' created successfully';
         header('location: index.php');
      } else {
         $error = 'Coordinator creation failed';
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

   <title>Create Coordinator</title>

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
               echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            }
         ?>
         <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
               <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-building"></i> Create Coordinators</h1>
            </div>
            <div class="card-body">
               <form action="create.php" method="POST">
                  <div class="row mb-3">
                     <div class="col-md-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                           value="<?php echo $_POST['email'] ?? ''; ?>" placeholder="Enter Coordinators Email">
                     </div>
                     <div class="col-md-4">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                           placeholder="Enter Coordinators Password">
                     </div>
                     <div class="col-md-4">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                           placeholder="Confirm Coordinators Password">
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col-md-3">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                           value="<?php echo $_POST['first_name'] ?? ''; ?>"
                           placeholder="Enter Coordinators First Name">
                     </div>
                     <div class="col-md-3">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                           value="<?php echo $_POST['last_name'] ?? ''; ?>" placeholder="Enter Coordinators Last Name">
                     </div>
                     <div class="col-md-3">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control"
                           value="<?php echo $_POST['age'] ?? ''; ?>" placeholder="Enter Coordinators Age">
                     </div>
                     <div class="col-md-3">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                           <option selected disabled hidden>Select Gender</option>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col-md-12">
                        <label for="organization_id">Organization</label>
                        <select name="organization_id" id="organization_id" class="form-control">
                           <option selected disabled hidden>Select Organization</option>
                           <?php
                              $organizations = $conn->query("SELECT * FROM organizations");
                              while($organization = $organizations->fetch(PDO::FETCH_OBJ)) : ?>

                           <option value="<?php echo $organization->org_id; ?>">
                              <?php echo $organization->org_name; ?>
                           </option>

                           <?php 
                              // last selected
                              if(isset($_POST['organization_id']) && $_POST['organization_id'] == $organization->org_id){
                                 echo '<option value="'.$_POST['organization_id'].'" selected>'.$organization->org_name.'</option>';
                              }
                              endwhile;
                           ?>
                        </select>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary" name="create">Create</button>
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