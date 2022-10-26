<?php
session_start();

require 'include/header.php';
require '../config/config.php';

if(isset($_POST['login'])){
   if (empty($_POST['email']) || empty($_POST['password'])) {
      $error = "All fields are required to login";
   } else {
      $email = $_POST['email'];
      $password = $_POST['password'];
      
      $query = "SELECT * FROM users WHERE email = :email AND password = :password";
      $stmt = $conn->prepare($query);
      $stmt->execute(
         array(
            'email' => $email,
            'password' => $password
         )
      );
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($count > 0){
         $_SESSION['user_id'] = $row['user_id'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['role'] = $row['role'];

         if($_SESSION['role'] == 'Admin'){
            $_SESSION['message'] = "You are logged in as Admin";
            header("location: ../admin/dashboard.php");
         } 

         if($_SESSION['role'] == 'Student'){
            $_SESSION['message'] = "You are logged in as Student";
            header("location: ../student/dashboard.php");
         } 
         
         if($_SESSION['role'] == 'Coordinator'){
            $_SESSION['message'] = "You are logged in as Coordinator";
            header("location: ../coordinator/dashboard.php");
         }
      }else{
         $error = "Invalid email or password";
      }
   }
}
?>
<form class="mx-auto" method="POST" style="max-width: 400px;"
   action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   <?php
         if(isset($error)){
            echo '<div class="alert alert-danger alert-dismissible fade show role="alert">
            <strong>Failed!</strong> '.$error.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
         }
         // if(isset($success)){
         //    echo '<div class="alert alert-success alert-dismissible fade show role="alert">
         //    <strong>Success!</strong> '.$success.'
         //    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         //    </div>';
         // }
         ?>
   <div class="card px-2">
      <div class="card-body">
         <h2 class="text-center">Log In</h2>
         <div class=" form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
               value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
         </div>
         <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
         </div>
         <br>
         <div class="form-group">
            <input type="submit" name="login" value="Log In" class="btn btn-primary btn-block form-control">
         </div>
         <div class="form-group text-center">
            <a href="register.php" class="btn">Sign Up</a>
         </div>
      </div>
   </div>
</form>
<?php
require 'include/footer.php';
?>