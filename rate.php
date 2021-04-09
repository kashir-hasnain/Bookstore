<?php
     session_start();
     if(!sizeof($_SESSION)){
       header('location: index.php');
     }
     $title = "Ratings...";
     
     include('templates/header.php');
?>

<?php
    include('connection.php');
    

    $student_id = $_SESSION['student_id'];
    $ISBN = $_GET['ISBN'];
    $rating = $_GET['rating'];

    // var_dump($_GET);

    if(isset($_GET['submit'])){
        $res = mysqli_query($connection, "INSERT INTO `rating`(`rating_value`, `book_id`, `student_id`) VALUES ($rating, $ISBN, $student_id)");
        if($res){
            echo '
            <div class="alert alert-success" role="alert">
                Rating Done!
            </div>';
        }
        else{
            echo '
            <div class="alert alert-danger" role="alert">
                Already Rated...
            </div>';
        }
    }

    

?>
<!--Page Starts Here-->

<?php include('templates/navigation.php');?>

<?php
    $book_row = mysqli_query($connection, "SELECT * FROM book WHERE `ISBN`=$ISBN");
    $book_row = mysqli_fetch_assoc($book_row);
    
?>

<div style='width: max-content; margin:20px'>
    <div><img src="assets/images/uploads/<?php echo $book_row['Image'];?>" alt="ISBN" style='width: 100px; height: 100px; object-fit:contain;'></div>
    <div class='row'>
        <div class='col'>
            <p>ISBN</p>
        </div>
        <div class='col'>
            <p><?php echo $book_row['ISBN'];?></p>
        </div>
    </div>
    <div class='row'>
        <div class='col'>
            <p>Title</p>
        </div>
        <div class='col'>
            <p><?php echo $book_row['Title'];?></p>
        </div>
    </div>
    <div class='row'>
        <div class='col'>
            <p>Author</p>
        </div>
        <div class='col'>
            <p><?php echo $book_row['Author'];?></p>
        </div>
    </div>

</div>


<table class="table">
  <thead>
    <tr>
      <th scope="col">Student ID</th>
      <th scope="col">Student Email</th>
      <th scope="col">Rating</th>
    </tr>
  </thead>

  <tbody>
  <?php
        $result = mysqli_query($connection, "SELECT * FROM `student_ratings_books` WHERE `ISBN`=$ISBN");
        if(!mysqli_num_rows($result)){
             echo "<p>No ratings...</p>";
        }
        while($row = mysqli_fetch_assoc($result)){
            
    ?>  
    <tr>
      <td><?php echo $row['student_id'];?></td>
      <td><?php echo $row['s_email'];?></td>
      <td><?php echo $row['rating_value'];?></td>
    </tr>
    <?php
        }
    ?>
  </tbody>
</table>





<!--Page ends Here-->

<?php
    include('templates/footer.php');
?>