<?php include 'includes/header.php'  ?>
    <title>Update section</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php
//call functions
checkUsrSession();

  ?>
<?php
if(isset($_GET['sect_id'])){

  $the_sect_id =  $_GET['sect_id'];
  $the_sect_id = mysqli_real_escape_string($connection,$the_sect_id);

  $query = "SELECT * FROM modules_section WHERE sect_id = $the_sect_id ";
  $select_edit_course = mysqli_query($connection,$query);
  if($select_edit_course){
    while($row = mysqli_fetch_assoc($select_edit_course)){
       $objective = $row['objective'];
       $csr_id = $row['csr_id'];
     
     
    }
  }




?>


<!-- Edit course  -->

<div class='form_login_container'>
<div><a href="#" onclick="history.back()" class='btn btn-secondary'><i class='fas fa-angle-left'></i> BACK</a></div>

<h1>Update section </h1>

<?php 
  if(isset($_POST['edit_mod'])){
    $objective =   $_POST['objective'];
    $csr_id = $_POST['csr_id'];

    $objective = mysqli_real_escape_string($connection,$objective);
    $csr_id = mysqli_real_escape_string($connection,$csr_id);

    $res = $_FILES['pdf']['name'];
    $res_temp= $_FILES['pdf']['tmp_name'];

    move_uploaded_file($res_temp,"uploads/$res");
  

  


    $query = "UPDATE modules_section SET objective = '$objective' , csr_id =  '$csr_id', res = '$res' WHERE sect_id = $the_sect_id";
    $update_course = mysqli_query($connection,$query);
    if($update_course){
      
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        Section updated successfully!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

    }



}

?>
<!-- Create video  -->

<form action="" method="post" enctype="multipart/form-data">

<label for="exampleInputEmail1" class="form-label">Objective</label>  
<input type="text" class="form-control" id="exampleFormControlInput1" name='objective' placeholder="Objective..." value='<?php echo $objective ?>'  required>

<input type="hidden" class="form-control" id="exampleFormControlInput1" name='csr_id' value='<?php echo $csr_id ?>'   required>
<br>
<div class="mb-3">
  <label for="formFile" class="form-label">Resource (Optional)</label>
  <input class="form-control" type="file" name='pdf' id="formFile" accept="application/pdf">
</div>


<br>
<button type="submit" name='edit_mod' class="btn btn-primary">Submit form</button>
<a id='back_form_btn' href="modules.php?csr_id=<?php echo $_GET['csr_id']; ?>" class='btn btn-secondary'>Back to section</a>


      
</div>
   
<!-- Create video -->
<?php
}else{
    header("Location: index.php");
}

?>

<?php include 'includes/footer.php'  ?>