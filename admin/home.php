<?php
    session_start();
    if(!sizeof($_SESSION)){
      header('location: index.php');
    }
    $title = "Home";
    
    include('../templates/header.php');
?>

<?php include('templates/navigation.php');?>

<?php
    include('../connection.php');

    if(isset($_POST['submit'])){
      $unique_id=$_POST['unique_id'];
      $email=$_POST['email'];
      $password=md5($_POST['password']);
      $cpassword=md5($_POST['cpassword']);
      
      if($password==$cpassword && strlen($unique_id)==9){
        $is_exe = mysqli_query($connection, "INSERT INTO `students`(`student_id`, `s_email`, `s_password`) VALUES ('$unique_id', '$email', '$password')");

        $message = $is_exe?'Member Added': 'Member Not Added';
      }
      else $message = 'Please check Unique Id(9 Digit ID) and Passwords...';
    }

?>
<style>
    .upload-image{
        width:100px;
        height:100px;
    }
    td{
        vertical-align: center;
    }
</style>

<!--Page starts here-->

<div class="row" style='padding: 20px'>
  <div class='col-sm-3'>
    <h2>New Member</h2>
    <form method='POST' enctype='multipart/form-data'>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Student ID</label>
        <input type="number" name='unique_id' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">E-Mail</label>
        <input type="email" name='email' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Password</label>
        <input type="password" name='password' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
        <input type="password" name='cpassword' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
      </div>

      <?php
        if(isset($message)){
            echo '<p style="color:orange;">'.$message.'</p>';
            }
        ?>

      <button type="submit" name='submit' class="btn btn-primary">Add Member</button>
    </form>
  </div>

  <div class='col-sm-9'>
    <table class="table">
    <thead>
      <tr>
        <th scope="col">Student ID</th>
        <th scope="col">Email</th>
        <th scope="col">Password</th>
        <th scope="col">Reset Password</th>
      </tr>
    </thead>

    <tbody>
      <?php
            $result = mysqli_query($connection, "SELECT * FROM `students`;");
            if(!mysqli_num_rows($result)){
                echo "<p>No student Found.</p>";
            }
            while($row = mysqli_fetch_assoc($result)){
                
        ?>  
        <tr>
            <td><?php echo $row['student_id'];?></td>
            <td><?php echo $row['s_email'];?></td>
            <td>*******</td>
            
            <td>
              <a href='resetpassword.php?student=<?php echo $row['student_id'];?>'>
                <button class="btn btn-primary mb-2">Reset Password</button>
              </a>
            </td>
        </tr>
        <?php
            }
        ?>
      </tbody>

    
  </div>
</div>


<!--Page ends Here-->

<?php
    include('../templates/footer.php');
?>