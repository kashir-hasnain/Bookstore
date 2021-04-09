<?php
    $book_id = $_GET['book'];
    include('connection.php');
    mysqli_query($connection, "DELETE FROM `rating` WHERE `book_id`=$book_id");
    mysqli_query($connection, "DELETE FROM `book` WHERE `ISBN`=$book_id");
    
    header('Location: home.php');
?>