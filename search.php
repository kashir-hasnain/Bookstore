<?php
    session_start();
    if(!sizeof($_SESSION)){
      header('location: index.php');
    }
    $title = "Search";
    
    include('templates/header.php');
    include('connection.php');
    
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
<!-- Page starts here-->
<?php include('templates/navigation.php');?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Search Books</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <form class="form-inline my-2 my-lg-0" method='GET'>
      <input name='search' class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button type='submit' name='submit' class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<?php
    if(isset($_GET['submit']) && $_GET['search']!=''){
        $search = $_GET['search'];
      
        setcookie('previous_search', $search, time() + (86400 * 30), "/");
    }
    else{
       
        $search = $_COOKIE['previous_search'];
        
    }
?>



<table class="table">
  <thead>
    <tr>
      <th scope="col">ISBN</th>
      <th scope="col">Title</th>
      <th scope="col">Author</th>
      <th scope="col">Image</th>
      <th scope="col" colspan=2>Actions</th>
    </tr>
  </thead>

  <tbody>
  <?php
        $result = mysqli_query($connection, "SELECT * FROM `book` WHERE `ISBN`=$search");
        if(!mysqli_num_rows($result)){
             echo "<p>ISBN No $search not Found.</p>";
        }
        while($row = mysqli_fetch_assoc($result)){
            
    ?>  
    <tr>
      <td><?php echo $row['ISBN'];?></td>
      <td><?php echo $row['Title'];?></td>
      <td><?php echo $row['Author'];?></td>
      <td>
            <img class='upload-image' src="assets/images/uploads/<?php echo $row['Image'];?>" alt="Image Not available">
      </td>
        
      <td>
        <a href="edit.php?book=<?php echo $row['ISBN'];?>"><button type="button" class="btn btn-warning">Edit</button></a>
      </td>
      
      <td>
        <a href="delete.php?book=<?php echo $row['ISBN'];?>"><button type="button" class="btn btn-danger">Delete</button></a>
      </td>
      
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