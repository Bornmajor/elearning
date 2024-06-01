<?php include 'includes/header.php'  ?>
    <title>Goals:
 <?php
 if(isset($_GET['csr_id'])){
    $the_csr_id =   $_GET['csr_id'];
    $the_csr_id = mysqli_real_escape_string($connection,$the_csr_id);
    $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id'";
    $select_course = mysqli_query($connection,$query);
    if($select_course){
        while($row = mysqli_fetch_assoc($select_course)){
         $csr_title =   $row['csr_title'];
        }
        echo $csr_title;
    }



 }else{
    header("Location: instructor.php");
 }
 ?>


    </title>
   
</head>
<body>
<?php include 'includes/navbar.php'  ?>

<div style='margin:20px;'><a href="instructor.php"  class='btn btn-secondary'><i class='fas fa-angle-left'></i> BACK</a></div>
<?php
//call functions  
checkUsrSession();
?>
 <?php insertCourseGoal(); ?>
<div class='goals_form_container'>

<form  action='' method='post'>
<img width='50px' src='images/icons8-licence-50.png' alt=""><span style='font-size:20px;font-weight:700;'><?php   echo $csr_title; ?></span>
    <h3 style='text-decoration:underline;'>Add objective in form below</h3>
    <br>
  <div class="mb-3">
   
    <label for="exampleInputEmail1" class="form-label" id='name_label'>Objective</label>
    <input type="text" class="form-control" id="ful_name" name='goal' aria-describedby="emailHelp" value='' placeholder='Enter course objective...'  required>
  </div>
  <input type="hidden" class="form-control"  name='csr_id' aria-describedby="emailHelp" value='<?php echo $the_csr_id ?>'   required>

  <button type="submit" class="btn btn-primary" id='register_btn' name='insert_goal'>Submit form</button>
  <a id='back_form_btn' href="instructor.php" class='btn btn-secondary'>Instructor panel</a>
</form>

<div class='goals_view_container'>
    
    <h4><?php echo $csr_title ?> (objectives)</h4>
   
        <?php viewCourseGoal(); ?>
       
    

</div>



</div>



<?php
if(isset($_GET['delete_goal'])){
 
    $the_object_id = $_GET['delete_goal'];
    $the_object_id = mysqli_real_escape_string($connection,$the_object_id);
  
    $query = "DELETE FROM objectives_course WHERE  object_id = $the_object_id";
    $delete_goal = mysqli_query($connection,$query);
    if($delete_goal){
       header("Location: view_goals.php?csr_id=".$_GET['csr_id']."");
    }else{
      die("Delete goal query failed");
    }
    
       
  
  }
  

?>

<?php include 'includes/footer.php'  ?>