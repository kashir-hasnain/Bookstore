<?php
    session_start();
    if(!sizeof($_SESSION)){
      header('location: index.php');
    }
    $title = "Password Reset";
    
    include('../templates/header.php');
?>
<?php include('templates/navigation.php');?>

<?php
    include('../connection.php');
    $new_password = 'e19d5cd5af0378da05f63f891c7467af';
    if(isset($_GET['student'])){
      $student=$_GET['student'];
      
      $is_exe = mysqli_query($connection, "UPDATE `students` SET `s_password`='$new_password' WHERE `student_id`=$student");  
      echo '<p>Password of student has been reset to <b>'.'</b> <b>abcd1234</b> is tthe default password</p>';
    }

?>


<?php
    include('../templates/footer.php');
?>