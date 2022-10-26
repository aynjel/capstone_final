<?php
require 'include/header.php';
require '../config/config.php';

if(isset($_POST['register'])){
   if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['age']) || empty($_POST['gender'])){
      $error = "All fields are required";
   }
   else if($_POST['password'] != $_POST['confirm_password']){
         $error = "Password does not match";
   }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $error = "Invalid email format";
   }else if(!preg_match("/^[a-zA-Z ]*$/", $_POST['first_name']) || !preg_match("/^[a-zA-Z ]*$/", $_POST['last_name'])){
      $error = "Only letters and white space allowed";
   }else if(!preg_match("/^[0-9]*$/", $_POST['age'])){
      $error = "Only numbers allowed";
   }
   else{
      // $organization_id = $_POST['organization_id'];
      
      $email = $_POST['email'];
      $password = $_POST['password'];
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $age = $_POST['age'];
      $gender = $_POST['gender'];
      $role = "Student";

      // admin data
      // $email = "admin@gmail.com";
      // $password = "admin";
      // $first_name = "John";
      // $last_name = "Doe";
      // $age = 25;
      // $gender = "Male";
      // $role = "Admin";
      
      $user_insert_query = "INSERT INTO users (email, password, role) VALUES (:email, :password, :role)";
      
      $user_insert_stmt = $conn->prepare($user_insert_query);
      
      $user_insert_stmt->execute(
         array(
            'email' => $email,
            'password' => $password,
            'role' => $role,
            )
         );

      if($role == 'Admin'){
         $admin_insert_query = "INSERT INTO admins (admin_id, first_name, last_name, age, gender) VALUES (:admin_id, :first_name, :last_name, :age, :gender)"; 

         $admin_insert_stmt = $conn->prepare($admin_insert_query);
            
         $admin_insert_stmt->execute(
            array(
               'admin_id' => $conn->lastInsertId(),
               'first_name' => $first_name,
               'last_name' => $last_name,
               'age' => $age,
               'gender' => $gender,
               )
            );

      }
      
      if($role == 'Coordinator'){
         $coordinator_insert_query = "INSERT INTO coordinators (coordinator_id, first_name, last_name, organization_id, gender, age) VALUES (:coordinator_id, :first_name, :last_name, :organization_id, :gender, :age)";
         
         $coordinator_insert_stmt = $conn->prepare($coordinator_insert_query);

         $coordinator_insert_stmt->execute(
            array(
               'coordinator_id' => $conn->lastInsertId(),
               'first_name' => $first_name,
               'last_name' => $last_name,
               'organization_id' => $organization_id,
               'gender' => $gender,
               'age' => $age,
               )
            );
      }
      
      if($role == 'Student'){
         $student_insert_query = "INSERT INTO students (student_id, first_name, last_name, age, gender) VALUES (:student_id, :first_name, :last_name, :age, :gender)";

         $student_insert_stmt = $conn->prepare($student_insert_query);

         $student_insert_stmt->execute(
            array(
               'student_id' => $conn->lastInsertId(),
               'first_name' => $first_name,
               'last_name' => $last_name,
               'age' => $age,
               'gender' => $gender,
            )
         );
      }
      $count = $user_insert_stmt->rowCount();
      if($count > 0){
         $success = "Registration successful";
      }else{
         $error = "Something went wrong";
      }
   }
}
?>
<form class="mx-auto" method="POST" style="max-width: 500px;"
   action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   <?php
         if(isset($error)){
            echo '<div class="alert alert-danger alert-dismissible fade show role="alert">
            <strong>Success!</strong> '.$error.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
         }
         if(isset($success)){
            echo '<div class="alert alert-success alert-dismissible fade show role="alert">
            <strong>Success!</strong> '.$success.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
         }
         ?>
   <div class="card px-2">
      <div class="card-body">
         <h2 class="text-center">Register</h2>
         <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control"
               value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; } ?>" placeholder="First Name">
         </div>
         <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control"
               value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; } ?>" placeholder="Last Name">
         </div>
         <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" class="form-control"
               value="<?php if(isset($_POST['age'])){ echo $_POST['age']; } ?>" placeholder="Age">
         </div>
         <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
               <option selected hidden disabled>Select</option>
               <option value="Male">Male</option>
               <option value="Female">Female</option>
            </select>
         </div>
         <div class=" form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
               value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
         </div>
         <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
         </div>
         <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
               placeholder="Confirm password">
         </div>
         <br>
         <div class="form-group">
            <input type="submit" name="register" value="Register" class="btn btn-primary btn-block form-control">
         </div>
         <div class="form-group text-center">
            <a href="login.php" class="btn">Login</a>
         </div>
      </div>
   </div>
</form>
<?php
require 'include/footer.php';
?>