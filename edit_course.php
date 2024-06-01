<?php include 'includes/header.php'  ?>
    <title>Update course</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php
//call functions
checkUsrSession();

  ?>
<?php
if(isset($_GET['course_edit'])){
    $usr_id = $_SESSION['usr_id']; 
  $the_csr_id =  $_GET['course_edit'];
  $the_csr_id = mysqli_real_escape_string($connection,$the_csr_id);

  $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id' AND usr_id = '$usr_id'";
  $select_edit_course = mysqli_query($connection,$query);
  if($select_edit_course){
    while($row = mysqli_fetch_assoc($select_edit_course)){
       $csr_title = $row['csr_title'];
       $csr_desc = $row['csr_desc'];
     
    }
  }




?>


<!-- Edit course  -->

<div class='form_login_container'>
<a href="instructor.php" class='btn btn-secondary'><i class='fas fa-angle-left'></i> INSTRUCTOR PANEL</a>


<h1>Update course</h1>

<?php 
  if(isset($_POST['edit_course'])){
    $csr_title =  $_POST['csr_title'];
    $topic_id =  $_POST['topic_id'];
    $csr_desc =   $_POST['csr_desc'];

    $lvl_id = $_POST['lvl_id'];
  

    $csr_title  = mysqli_real_escape_string($connection,$csr_title);
    $topic_id  = mysqli_real_escape_string($connection,$topic_id);
    $csr_desc  = mysqli_real_escape_string($connection,$csr_desc);
  
    $lvl_id  = mysqli_real_escape_string($connection,$lvl_id);

    $csr_img = $_FILES['image']['name'];
    $csr_img_temp= $_FILES['image']['tmp_name'];

    $res = $_FILES['pdf']['name'];
    $res_temp= $_FILES['pdf']['tmp_name'];

    //move file
    move_uploaded_file($csr_img_temp,"uploads/$csr_img");
    move_uploaded_file($res_temp,"uploads/$res");

    $query = "UPDATE courses SET csr_title = '$csr_title' , topic_id = $topic_id , csr_desc = '$csr_desc',lvl_id = $lvl_id,csr_img = '$csr_img',res = '$res' WHERE csr_id = '$the_csr_id'";
    $update_course = mysqli_query($connection,$query);
    if($update_course){
      
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
         Course updated successfully!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

    }



}

?>
<!---form cc-->
<form action="" method="post" enctype="multipart/form-data" >

<label for="exampleInputEmail1" class="form-label">Course title</label>  
<input type="text" class="form-control" id="exampleFormControlInput1" name='csr_title' placeholder="Course name..." value='<?php echo $csr_title ?>' required>

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Description</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name='csr_desc' rows="10" required><?php echo $csr_desc ?></textarea>
</div>
<div class="mb-3">
  <label for="formFile" class="form-label">Course thumbnail (image)</label>
  <input class="form-control" type="file" name='image' id="formFile" accept="image/x-png,image/gif,image/jpeg" required>
</div>



<label for="exampleInputEmail1" class="form-label">Choose topic under course</label>
<select class="form-select" name='topic_id' aria-label="Default select example">
    <?php selectTopics(); ?>
</select>
<label for="exampleInputEmail1" class="form-label">Level</label>
<select class="form-select" name='lvl_id' aria-label="Default select example" required>
<?php selectLevels(); ?>

</select>
<br>
<div class="mb-3">
  <label for="formFile" class="form-label">Resource / Course outline(Optional)</label>
  <input class="form-control" type="file" name='pdf' id="formFile" accept="application/pdf">
</div>
 <button type="submit" name='edit_course' class="btn btn-primary">Submit form</button>
        </form>
      </div>
    
       
</div>
<!-- Edit course Modal -->
<?php
}else{
    header("Location: instructor.php");
}

?>

<?php include 'includes/footer.php'  ?>