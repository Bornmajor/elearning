<?php include 'includes/header.php'  ?>
    <title>Add video</title>
 
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php
//check usr session
checkUsrSession();

if(isset($_GET['sect_id'])){
   $the_sect_id = $_GET['sect_id'];
   $the_sect_id = mysqli_real_escape_string($connection,$the_sect_id);




?>
<div class='form_login_container'>
<div><a href="modules.php?csr_id=<?php echo $_GET['csr_id']; ?>"  class='btn btn-secondary'><i class='fas fa-angle-left'></i> BACK</a></div>
<?php
$query = "SELECT * FROM modules_section WHERE sect_id = $the_sect_id";
$select_title = mysqli_query($connection,$query);
if($select_title){
    while($row = mysqli_fetch_assoc($select_title)){
    $objective = $row['objective'];
    }
}

?>
<h2>Section : <?php  echo $objective ?></h2>
<?php insertVideo(); ?>

<!-- Create video  -->

<form action="" method="post">
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Video title</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name='lec_title' placeholder="Video title.."  required>
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Video URL</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name='video_url' placeholder="Video url.."  required>
</div>

<input type="hidden" class="form-control" id="exampleFormControlInput1" name='sect_id' value='<?php echo $the_sect_id ?>'  required>
<input type="hidden" class="form-control" id="exampleFormControlInput1" name='csr_id' value='<?php echo $_GET['csr_id']; ?>'  required>

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Video description</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name='lec_desc' rows="10" ></textarea>
</div>

<br>
<button type="submit" name='add_video' class="btn btn-primary">Submit form</button>
<a id='back_form_btn' href="modules.php?csr_id=<?php echo $_GET['csr_id']; ?>" class='btn btn-secondary'>Back to section</a>


      
</div>
   
<!-- Create video -->

<?php 
}else{
    header("Location: instructor.php");
}
?>
<?php include 'includes/footer.php'  ?>