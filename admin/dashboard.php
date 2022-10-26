<?php
   session_start();

   include 'include/header.php';
   require '../config/config.php';

   if(!isset($_SESSION['user_id'])){
      header("location: ../auth/login.php");
   }
   
   // get total number of users
   $get_all_user = "SELECT * FROM users";
   $stmt = $conn->prepare($get_all_user);
   $stmt->execute();
   $total_users = $stmt->rowCount();

   // get total number of students
   $get_all_student = "SELECT * FROM students";
   $stmt = $conn->prepare($get_all_student);
   $stmt->execute();
   $total_students = $stmt->rowCount();

   // get total number of coordinators
   $get_all_coordinator = "SELECT * FROM coordinators";
   $stmt = $conn->prepare($get_all_coordinator);
   $stmt->execute();
   $total_coordinators = $stmt->rowCount();

   // get total number of organizations
   $get_all_organization = "SELECT * FROM organizations";
   $stmt = $conn->prepare($get_all_organization);
   $stmt->execute();
   $total_organizations = $stmt->rowCount();

   // get details of the logged in user
   $get_user = "SELECT * FROM users WHERE user_id = :user_id";
   $stmt = $conn->prepare($get_user);
   $stmt->execute(
      array(
         'user_id' => $_SESSION['user_id']
      )
   );
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // get details of the logged in admin
   $get_admin = "SELECT * FROM admins WHERE admin_id = :admin_id";
   $stmt = $conn->prepare($get_admin);
   $stmt->execute(
      array(
         'admin_id' => $_SESSION['user_id']
      )
   );
   $admin = $stmt->fetch(PDO::FETCH_ASSOC);

?>
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

               <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-body">
                        <div class="row no-gutters align-items-center">
                           <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                 Organizations</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <?php echo $total_organizations; ?>
                              </div>
                           </div>
                           <div class="col-auto">
                              <i class="fas fa-building fa-2x text-gray-300"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-body">
                        <div class="row no-gutters align-items-center">
                           <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                 Total Coordinator</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <?php echo $total_coordinators; ?>
                              </div>
                           </div>
                           <div class="col-auto">
                              <i class="fas fa-building-user fa-2x text-gray-300"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                     <div class="card-body">
                        <div class="row no-gutters align-items-center">
                           <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                 Total Student</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <?php echo $total_students; ?>
                              </div>
                           </div>
                           <div class="col-auto">
                              <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                           </div>
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

   <?php
      include 'include/footer.php';
   ?>