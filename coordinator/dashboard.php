<?php
   session_start();
   require '../config/config.php';

   if(!isset($_SESSION['user_id'])){
      header("location: ../auth/login.php");
   }

   // get total number of students under the logged in coordinator
   $get_all_student = "SELECT * FROM students WHERE coordinator_id = :coordinator_id";
   $stmt = $conn->prepare($get_all_student);
   $stmt->execute(
      array(
         'coordinator_id' => $_SESSION['user_id']
      )
   );
   $total_students = $stmt->rowCount();

   // get details of the logged in user
   $get_user = "SELECT * FROM users WHERE user_id = :user_id";
   $stmt = $conn->prepare($get_user);
   $stmt->execute(
      array(
         'user_id' => $_SESSION['user_id']
      )
   );
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // get details of the logged in coordinator
   $get_coordinator = "SELECT * FROM coordinators WHERE coordinator_id = :coordinator_id";
   $stmt = $conn->prepare($get_coordinator);
   $stmt->execute(
      array(
         'coordinator_id' => $_SESSION['user_id']
      )
   );
   $coordinator = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <title>App Title</title>

   <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- Custom styles for this template-->
   <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

</head>

<body id="page-top"></body>
<!-- Page Wrapper -->
<div id="wrapper" style="background-color: #003043">

   <?php
      include 'include/sidebar.php';
   ?>

   <!-- Content Wrapper -->
   <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

         <?php
            include 'include/navbar.php';
         ?>
         <!-- Begin Page Content -->
         <div class="container-fluid">
            <?php
            if(isset($_SESSION['message'])){
               echo '<div class="alert alert-success">
               <strong>Success!</strong> '.$_SESSION['message'].'
               </div>';
               unset($_SESSION['message']);
            }
         ?>
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
               <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

               <div class="col-xl-6 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-body">
                        <div class="row no-gutters align-items-center">
                           <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                 Total Students</div>
                              <div class="h1 mb-0 font-weight-bold text-gray-800">
                                 <?php echo $total_students; ?>
                              </div>
                           </div>
                           <div class="col-auto">
                              <i class="fas fa-user-graduate fa-2x text-gray-500"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-body">
                        <div class="row no-gutters align-items-center">
                           <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                 Total Task Created</div>
                              <div class="h1 mb-0 font-weight-bold text-gray-800">
                                 <?php echo $total_students; ?>
                              </div>
                           </div>
                           <div class="col-auto">
                              <i class="fas fa-list-check fa-2x text-gray-500"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">YOUR STUDENTS</h6>
                     </div>
                     <div class="card-body">
                        <div class="table-responsive">
                           <table id="dataTable" class="display" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>Complete Name</th>
                                    <th>Coordinator</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <?php
                                 $get_all_student = "SELECT * FROM students WHERE coordinator_id = :coordinator_id";
                                 $stmt = $conn->prepare($get_all_student);
                                 $stmt->execute(
                                    array(
                                       'coordinator_id' => $_SESSION['user_id']
                                    )
                                 );
                                 $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                 foreach($students as $student) : ?>

                                    <td> <?php echo $student['first_name'].' '.$student['last_name']; ?> </td>
                                    <td> <?php echo $coordinator['first_name'].' '.$coordinator['last_name'] ?></td>
                                    <td>
                                       <!-- button dropdown -->
                                       <div class="btn-group">
                                          <button type="button" class="btn btn-primary">Action</button>
                                          <button type="button"
                                             class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <div class="dropdown-menu">
                                             <a class="dropdown-item"
                                                href="student_profile.php?student_id=<?php echo $student['student_id']; ?>">View
                                                Profile</a>
                                             <a class="dropdown-item"
                                                href="student_task.php?student_id=<?php echo $student['student_id']; ?>">View
                                                Task</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item"
                                                href="student_task.php?student_id=<?php echo $student['student_id']; ?>">Add
                                                Task</a>
                                          </div>
                                       </div>
                                    </td>
                                    <?php endforeach; ?>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">TASK CREATED</h6>
                     </div>
                     <div class="card-body">
                        <div class="table-responsive">
                           <table id="dataTable2" class="display" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- End of Main Content -->
      </div>
      <!-- End of Content Wrapper -->

   </div>
   <!-- End of Page Wrapper -->
   <!-- Logout -->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
               <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
         </div>
      </div>
   </div>

   <!-- Scroll to Top Button-->
   <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
   </a>



   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
   <script src="../assets/vendor/chart.js/Chart.min.js"></script>
   <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

   <script src="../assets/js/sb-admin-2.min.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js">
   </script>
   <script>
   $(document).ready(function() {
      $('#dataTable').DataTable();
      $('#dataTable2').DataTable();
   });
   </script>

   </body>

</html>