
<?php
    session_start();
    if(sizeof($_SESSION)){
        header('Location: home.php');
    }
    $title = "Login to Book Store!";
?>

<?php
    // Login Handler
    include('../connection.php');
    
    if(isset($_POST['submit'])){
        $teacher_id = $_POST['teacher_id'];
        $password = md5($_POST['password']);
        $result = mysqli_query($connection, "SELECT * FROM teachers WHERE teacher_id='$teacher_id' and t_password= '$password';");
        
        $result_array = mysqli_fetch_assoc($result);
        
        if($result_array){
            session_start();
            $_SESSION = $result_array;
            header('Location: home.php');
        }
        else{
            $message = 'Wrong Credentials'; 
        }
    }

?>

<?php include('../templates/header.php');?>

<link rel="stylesheet" href="../assets/css/register.css">

<form class="signInForm form border-light p-5" method='POST'>

    <p class="h4 mb-4 text-center">ADMIN Login</p>

    <input type="text" name='teacher_id' class="form-control mb-4" placeholder="Teacher ID">

    <input type="password" id="signInPassword" name='password' class="form-control mb-4" placeholder="Password">
    
    <?php
        if(isset($message)){
            echo '<p style="color:red;">'.$message.'</p>';
        }
    ?>
    <input type="submit" name="submit" id='signIn' class="btn btn-outline-primary" value='Login'>
</form>
<?php include('../templates/footer.php');?>
