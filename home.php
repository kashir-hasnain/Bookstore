<?php
    session_start();
    if(!sizeof($_SESSION)){
      header('location: index.php');
    }
    $title = "Home";
    
    include('templates/header.php');
?>


<?php
    include('connection.php');

    if(isset($_POST['submit'])){
      $isbn=$_POST['isbn'];
      $title=$_POST['title'];
      $author=$_POST['author'];
      
      $image = $_FILES['image']['name']==''?NULL:$_FILES['image']['name'];

      $is_exe = mysqli_query($connection, "INSERT INTO `book`(`ISBN`, `Title`, `Author`, `Image`) VALUES ($isbn, '$title', '$author', '$image')");


      if($_FILES['image']['name']!=''){
        move_uploaded_file($_FILES['image']['tmp_name'], "./assets/images/uploads/".$image);
      }

      $message = $is_exe?'Added': 'Not Added';

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
<?php include('templates/navigation.php');?>
<div class="row" style='padding: 20px'>
  <div class='col-sm-3'>
    <form method='POST' enctype='multipart/form-data'>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">ISBN</label>
        <input type="number" name='isbn' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Title</label>
        <input type="text" name='title' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Author</label>
        <input type="text" name='author' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>

      <section class="section-preview">
      
        <div class="input-group my-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" name='image' class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>

      </section>

      <?php
        if(isset($message)){
            echo '<p style="color:orange;">'.$message.'</p>';
            }
        ?>

      <button type="submit" name='submit' class="btn btn-primary">Add Book</button>
    </form>
  </div>

  <div class='col-sm-9'>
    <table class="table">
    <thead>
      <tr>
        <th scope="col">ISBN</th>
        <th scope="col">Title</th>
        <th scope="col">Author</th>
        <th scope="col">Image</th>
        <th scope="col">Rate Here</th>
      </tr>
    </thead>

    <tbody>
      <?php
            $result = mysqli_query($connection, "SELECT * FROM `book`;");
            if(!mysqli_num_rows($result)){
                echo "<p>ISBN No $search not Found.</p>";
            }
            while($row = mysqli_fetch_assoc($result)){
                
        ?>  
        <tr>
          <form action="rate.php" method="get">
            <td>
              <input name='ISBN' class="form-control" type="text" value='<?php echo $row['ISBN'];?>' readonly>
            </td>
            <td><?php echo $row['Title'];?></td>
            <td><?php echo $row['Author'];?></td>
            <td>
                  <img class='upload-image' src="assets/images/uploads/<?php echo $row['Image'];?>" alt="Image Not available">
            </td>
            <td>
              <select name='rating' class="form-control">
                <?php
                  for($i=1; $i<=10; $i++){
                ?>
                    <option value='<?php echo $i;?>'><?php echo $i;?></option>
                <?php
                  }
                ?>
              </select>
              <button name='submit' type="submit" class="btn btn-primary mb-2">Rate</button>
            </td>
          </form>
        </tr>
        <?php
            }
        ?>
      </tbody>

    
  </div>
</div>


<!--Page ends Here-->

<?php
    include('templates/footer.php');
?>