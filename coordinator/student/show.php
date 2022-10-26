<?php
   session_start();
   require '../../config/config.php';

   if (isset($_GET['id'])) {
      $id = $_GET['id'];

      // show the student
      $show_student = $conn->prepare("SELECT * FROM students WHERE student_id = :id");
      $show_student->execute([
         ':id' => $id
      ]);
      $student = $show_student->fetch(PDO::FETCH_OBJ);

      // show the coordinator of the student
      $show_coordinator = $conn->prepare("SELECT * FROM coordinators WHERE coordinator_id = :id");
      $show_coordinator->execute([
         ':id' => $student->coordinator_id
      ]);
      $coordinator = $show_coordinator->fetch(PDO::FETCH_OBJ);

      // get user credentials
      $sql = "SELECT * FROM users WHERE user_id = :user_id";
      $stmt = $conn->prepare($sql);
      $stmt->execute([
         ':user_id' => $student->student_id
      ]);
      $user = $stmt->fetch(PDO::FETCH_OBJ);
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <title>Student Details</title>

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
            if (isset($_SESSION['success'])) {
               echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> " . $_SESSION['success'] . "
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
               </div>";
               unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
               echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Error!</strong> " . $_SESSION['error'] . "
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
               </div>";
               unset($_SESSION['error']);
            }
         ?>
         <div class="card shadow mb-4">
            <div class="card-header">
               <h1 class="h4 text-gray-800"><i class="fas fa-building-user"></i> Student Details</h1>
            </div>
            <div class="card-body">
               <div class="row mb-4">
                  <div class="col-md-3">
                     <label for="first_name">First Name</label>
                     <input type="text" class="form-control" name="first_name" id="first_name"
                        value="<?php echo $student->first_name; ?>" disabled>
                  </div>
                  <div class="col-md-3">
                     <label for="last_name">Last Name</label>
                     <input type="text" class="form-control" name="last_name" id="last_name"
                        value="<?php echo $student->last_name; ?>" disabled>
                  </div>
                  <div class="col-md-3">
                     <label for="email">Email</label>
                     <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $user->email; ?>" disabled>
                  </div>
                  <div class="col-md-3">
                     <label for="password">Password</label>
                     <input type="text" class="form-control" id="password" name="password"
                        value="<?php echo $user->password; ?>" disabled>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-md-3">
                     <label for="role">Role</label>
                     <input type="text" class="form-control" id="role" name="role" value="<?php echo $user->role; ?>"
                        disabled>
                  </div>
                  <div class="col-md-3">
                     <label for="status">Status</label>
                     <input type="text" class="form-control" id="status" name="status"
                        value="<?php echo $user->status; ?>" disabled>
                  </div>
                  <div class="col-md-3">
                     <label for="age">Age</label>
                     <input type="text" class="form-control" id="age" name="age" value="<?php echo $student->age; ?>"
                        disabled>
                  </div>
                  <div class="col-md-3">
                     <label for="gender">Gender</label>
                     <input type="text" class="form-control" id="gender" name="gender"
                        value="<?php echo $student->gender; ?>" disabled>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-md-3">
                     <label for="coordinator_id">Coordinator</label>
                     <div class="input-group mb-3">
                        <input type="text" class="form-control" id="coordinator_id" name="coordinator_id"
                           value="<?php echo $coordinator->first_name . ' ' . $coordinator->last_name; ?>" disabled>
                        <a href="../coordinator/show.php?id=<?php echo $coordinator->coordinator_id; ?>" target="_blank"
                           class="input-group-text btn btn-primary btn-icon-split" id="basic-organization">
                           <span class="icon">
                              <i class="fas fa-eye"></i>
                           </span>
                           <span class="text">View</span>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <a href='edit.php?id=<?php echo $student->student_id; ?>' class='btn btn-primary btn-icon-split'>
                        <span class='icon text-white-50'>
                           <i class='fas fa-edit'></i>
                        </span>
                        <span class='text'>Edit</span>
                     </a>
                     <a href='delete.php?id=<?php echo $student->student_id; ?>' class='btn btn-danger btn-icon-split'
                        onclick="return confirm('Are you sure you want to delete this coordinator?')"
                        class='btn btn-danger btn-icon-split btn-sm'>
                        <span class='icon text-white-50'>
                           <i class='fas fa-trash'></i>
                        </span>
                        <span class='text'>Delete</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


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