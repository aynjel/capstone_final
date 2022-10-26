<?php
   require '../../config/config.php';
   session_start();
   
   $sql = "SELECT * FROM students";
   $c_stmt = $conn->prepare($sql);
   $c_stmt->execute();
   $students = $c_stmt->fetchAll(PDO::FETCH_OBJ);
   // count the number of coordinators
   $count = $c_stmt->rowCount();
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <title>Students</title>

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
            <a href="../dashboard.php" class="link-primary" style="font-size: 22px;"><i class="fas fa-angle-left"></i>
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
            // display error message
            if (isset($_SESSION['error'])) {
               echo '
                  <div class="alert alert-danger" role="alert">
                     ' . $_SESSION['error'] . '
                  </div>
               ';
               unset($_SESSION['error']);
            }
         ?>
         <div class="card shadow mb-4">
            <div class="card-header">
               <h1 class="h4 text-gray-800"><i class="fas fa-building-user"></i> Students</h1>
               <a href="create.php" class="btn btn-primary btn-icon-split float-right">
                  <span class="icon text-white-50">
                     <i class="fas fa-plus"></i>
                  </span>
                  <span class="text">Create</span>
               </a>
            </div>
            <div class="card-body">
               <div class="row">
                  <?php
                     if($count > 0) :
                        foreach($students as $student) :
                            // get status from specific coordinator
                           $sql = "SELECT * FROM users WHERE user_id = :user_id";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute([':user_id' => $student->student_id]);
                           $user = $stmt->fetch(PDO::FETCH_OBJ);
                  ?>
                  <div class="col-lg-4 col-md-6 mb-4">
                     <div class="card h-100">
                        <div class="card-body">
                           <h4 class="card-title">
                              <a href="show.php?id=<?php echo $student->student_id; ?>">
                                 <?php echo $student->first_name . ' ' . $student->last_name; ?>
                              </a>
                           </h4>
                           <p class="card-text">
                              <?php 
                                 if($user->status == 'Active') {
                                    echo '<span class="badge badge-success">Active</span>';
                                 } else {
                                    echo '<span class="badge badge-danger">Inactive</span>';
                                 }
                              ?>
                           </p>
                        </div>
                        <div class="card-footer">
                           <a href="show.php?id=<?php echo $student->student_id; ?>"
                              class="btn btn-primary btn-icon-split">
                              <span class="icon text-white-50">
                                 <i class="fas fa-eye"></i>
                              </span>
                              <span class="text">View</span>
                           </a>
                        </div>
                     </div>
                  </div>
                  <?php
                        endforeach;
                     else :
                  ?>

                  <div class="col-lg-12 text-center">
                     <div class="alert alert-info" role="alert">
                        No students found!
                     </div>
                  </div>

                  <?php
                     endif;
                  ?>
                  <!-- End of Content Wrapper -->
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