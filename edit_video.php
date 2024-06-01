<?php include 'includes/header.php'  ?>
    <title>Update lecture</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php
//call functions
checkUsrSession();

  ?>
<?php
if(isset($_GET['lect_id'])){

  $the_lect_id =  $_GET['lect_id'];
  $the_lect_id = mysqli_real_escape_string($connection,$the_lect_id);

  $query = "SELECT * FROM lectures WHERE lect_id = $the_lect_id ";
  $select_edit_course = mysqli_query($connection,$query);
  if($select_edit_course){
    while($row = mysqli_fetch_assoc($select_edit_course)){
       $lec_title = $row['lec_title'];
       $lec_desc = $row['lec_desc'];
       $video_url = $row['video_url'];
       $sect_id = $row['sect_id'];
     
    }
  }




?>


<!-- Edit course  -->

<div class='form_login_container'>
<h1>Update lecture video</h1>

<?php 
  if(isset($_POST['edit_video'])){
    $lec_title =  $_POST['lec_title'];
    $video_url =  $_POST['video_url'];
    $sect_id =   $_POST['sect_id'];

    $lec_desc = $_POST['lec_desc'];
  

    $lec_title  = mysqli_real_escape_string($connection,$lec_title);
    $video_url   = mysqli_real_escape_string($connection,$video_url );
    $sect_id  = mysqli_real_escape_string($connection,$sect_id);
  
    $lec_desc  = mysqli_real_escape_string($connection,$lec_desc);

  


    $query = "UPDATE lectures SET lec_title = '$lec_title ' , video_url =  '$video_url', sect_id = $sect_id, lec_desc = '$lec_desc' WHERE lect_id = $the_lect_id";
    $update_course = mysqli_query($connection,$query);
    if($update_course){
      
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        Lecture updated successfully!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

    }



}

?>
<!-- Create video  -->

<form action="" method="post">
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Video title</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name='lec_title' placeholder="Video title.."  value='<?php echo $lec_title ?>' required>
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Video URL</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name='video_url' placeholder="Video url.." value='<?php echo $video_url ?>'  required>
</div>

<input type="hidden" class="form-control" id="exampleFormControlInput1" name='sect_id' value='<?php echo $sect_id ?>'  required>


<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Video description</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name='lec_desc' rows="10" ><?php echo $lec_desc  ?></textarea>
</div>

<br>
<button type="submit" name='edit_video' class="btn btn-primary">Submit form</button>


      
</div>
   
<!-- Create video -->
<?php
}else{
    header("Location: index.php");
}

?>

<?php include 'includes/footer.php'  ?>