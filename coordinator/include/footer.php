      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
         <i class="fas fa-angle-up"></i>
      </a>



      <script src="../assets/vendor/jquery/jquery.min.js"></script>
      <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="../assets/vendor/chart.js/Chart.min.js"></script>
      <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <script src="../assets/js/sb-admin-2.min.js"></script>
      <script>
$(document).ready(function() {
   $('#dataTable').DataTable();
});
      </script>
      <!--
      <script src="../assets/js/demo/chart-area-demo.js"></script>
      <script src="../assets/js/demo/chart-pie-demo.js"></script>
      -->

      </body>

      </html>
      <table id="dataTable" class="table table-bordered" style="width:100%">
                        <thead>
                           <tr>
                              <th>ID No.</th>
                              <th>Complete Name</th>
                              <th>Age</th>
                              <th>Gender</th>
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
                                 foreach($students as $student){
                                    echo '<tr>
                                       <td>'.$student['student_id'].'</td>
                                       <td>'.$student['first_name'].' '.$student['last_name'].'</td>
                                       <td>'.$student['age'].'</td>
                                       <td>'.$student['gender'].'</td>
                                       <td>'.$coordinator['first_name'].' '.$coordinator['last_name'].'</td>
                                       <td>
                                          <a href="student.php?student_id='.$student['student_id'].'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>
                                       </td>
                                    </tr>';
                                 }
                              ?>
                           </tr>
                        </tbody>
                     </table>