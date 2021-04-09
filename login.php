<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
    </body>
    </html>


<?php
    session_start();
    if(sizeof($_SESSION)){
        header('Location: home.php');
    }
    $title = "Login to Book Store!";
?>

<?php
    // Login Handler
    include('connection.php');

    
    
    if(isset($_POST['submit']) && $_POST['g-recaptcha-response'] != ""){
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $secret = '6LeVxJ4aAAAAALBn4MWYOMnL7X1prW5Z5ax1Stxy';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
        $result = mysqli_query($connection, "SELECT * FROM students WHERE s_email='$email' and s_password= '$password';");
        
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

<?php include('templates/header.php');?>

<link rel="stylesheet" href="assets/css/register.css">

<form class="signInForm form border-light p-5" method='POST'>

    <p class="h4 mb-4 text-center">Student Login</p>

    <input type="email" id="signInEmail" name='email' class="form-control mb-4" placeholder="E-mail">

    <input type="password" id="signInPassword" name='password' class="form-control mb-4" placeholder="Password">
    
    <?php
        if(isset($message)){
            echo '<p style="color:red;">'.$message.'</p>';
        }
    ?>
    <div class="g-recaptcha" data-sitekey="6LeVxJ4aAAAAAIuOoLmFbz8Qij0WrBYZiIKOr1vx"></div>
    <input type="submit" name="submit" id='signIn' class="btn btn-outline-primary" value='Login'>
</form>
<?php include('templates/footer.php');?>
