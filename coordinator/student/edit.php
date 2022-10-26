<?php
   session_start();
   require '../../config/config.php';

   if(isset($_GET['id'])) {
      $id = $_GET['id'];

      $sql_select_s = $conn->query("SELECT * FROM students WHERE student_id = '$id'");
      $sql_select_s->execute();
      $student = $sql_select_s->fetch(PDO::FETCH_OBJ);

      $sql_select_c = $conn->query("SELECT * FROM coordinators");
      $sql_select_c->execute();
      $coordinators = $sql_select_c->fetchAll(PDO::FETCH_OBJ);

      $sql_select_u = $conn->query("SELECT * FROM users WHERE user_id = '$id'");
      $sql_select_u->execute();
      $user = $sql_select_u->fetch(PDO::FETCH_OBJ);
      // if the form was submitted
      if (isset($_POST['update'])) {

         // get the form data
         $email = $_POST['email'];
         $password = $_POST['password'];
         $status = $_POST['status'];
         $role = 'Student';

         $update_users = $conn->prepare("UPDATE users SET email = :email, password = :password, status = :status WHERE user_id = $id");
         $update_users->execute([
            ':email' => $email,
            ':password' => $password,
            ':status' => $status
         ]);

         $first_name = $_POST['first_name'];
         $last_name = $_POST['last_name'];
         $age = $_POST['age'];
         $gender = $_POST['gender'];
         $coordinator_id = $_POST['coordinator_id'];

         $update_coordinator = $conn->prepare("UPDATE students SET first_name = :first_name, last_name = :last_name, age = :age, gender = :gender, coordinator_id = :coordinator_id WHERE student_id = $id");
         $update_coordinator->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':age' => $age,
            ':gender' => $gender,
            ':coordinator_id' => $coordinator_id,
         ]);

         if ($update_users && $update_coordinator) {
            $_SESSION['success'] = 'Student ' . $first_name . ' ' . $last_name . ' updated successfully';
            header('location: index.php');
         } else {
            $error = 'Student update failed';
         }
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

   <title>Update Students</title>

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
            <a href="show.php?id=<?php echo $student->student_id; ?>" class="btn btn-primary btn-icon-split">
               <span class="icon text-white-50">
                  <i class="fas fa-arrow-left"></i>
               </span>
               <span class="text">Back</span>
            </a>
         </nav>
         <!-- End of Topbar -->
         <?php
            if (isset($error)) {
               echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
         ?>
         <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
               <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-pen"></i> Update Student Details</h1>
            </div>
            <div class="card-body">
               <!-- UPDATE FORM -->
               <form method="POST" action="edit.php?id=<?php echo $student->student_id; ?>">
                  <div class="row mb-4">
                     <div class="col-md-3">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                           value="<?php echo $student->first_name; ?>">
                     </div>
                     <div class="col-md-3">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                           value="<?php echo $student->last_name; ?>">
                     </div>
                     <div class="col-md-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                           value="<?php echo $user->email; ?>">
                     </div>
                     <div class="col-md-3">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password"
                           value="<?php echo $user->password; ?>">
                     </div>
                  </div>
                  <div class="row mb-4">
                     <div class="col-md-3">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" id="role" name="role" value="<?php echo $user->role; ?>"
                           readonly>
                     </div>
                     <div class="col-md-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                           <?php
                              $status = ['Active', 'Inactive'];
                              foreach ($status as $key => $value) {
                                 if ($value == $user->status) {
                                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                                 } else {
                                    echo '<option value="' . $value . '">' . $value . '</option>';
                                 }
                              }
                           ?>
                        </select>
                     </div>
                     <div class="col-md-3">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" id="age" name="age"
                           value="<?php echo $student->age; ?>">
                     </div>
                     <div class="col-md-3">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                           <?php
                              $genders = ['Male', 'Female'];
                              foreach ($genders as $key => $value) {
                                 if ($value == $student->gender) {
                                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                                 } else {
                                    echo '<option value="' . $value . '">' . $value . '</option>';
                                 }
                              }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-4">
                     <div class="col-md-3">
                        <label for="coordinator_id">Coordinator</label>
                        <select class="form-control" id="coordinator_id" name="coordinator_id">
                           <?php
                              foreach ($coordinators as $coordinator) {
                                 if ($coordinator->coordinator_id == $student->coordinator_id) {
                                    echo '<option value="' . $coordinator->coordinator_id . '" selected>' . $coordinator->first_name . ' ' . $coordinator->last_name . '</option>';
                                 } else {
                                    echo '<option value="' . $coordinator->coordinator_id . '">' . $coordinator->first_name . ' ' . $coordinator->last_name . '</option>';
                                 }
                              }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <button name="update" class="btn btn-primary btn-icon-split" type="submit"
                           onclick="return confirm('Are you sure you want to update this student?')">
                           <span class="icon text-white-50">
                              <i class="fas fa-save"></i>
                           </span>
                           <span class="text">Update</span>
                        </button>
                     </div>
                  </div>
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