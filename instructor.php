<?php include 'includes/header.php'  ?>
    <title>Instructors</title>
   
</head>
<body>
<?php include 'includes/navbar.php'  ?>


<?php
//call functions
checkUsrSession();
 insertCourse();
  ?>




<!-- Create course Modal -->

<div class="modal fade" id="createCourse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Course</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<!---form cc-->
<form action="" method="post" enctype="multipart/form-data" >

<label for="exampleInputEmail1" class="form-label">Course title</label>  
<input type="text" class="form-control" id="exampleFormControlInput1" name='csr_title' placeholder="Course name..." required>

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Description</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name='csr_desc' rows="10" required></textarea>
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



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name='insert_course' class="btn btn-primary">Submit form</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Create course Modal -->






<!--My courses-->

<div class='lec_cards'><!--lec_cards-->

<?php
$db_usr_id = $_SESSION['usr_id'];

$query = "SELECT * FROM courses WHERE usr_id = '$db_usr_id'";
$check_courses_count = mysqli_query($connection,$query);
if($check_courses_count){
  $no_course_in_usr =  mysqli_num_rows($check_courses_count);
}
if($check_courses_count !== 0){
    echo " <h2 class='pop_title'>My Instructor Courses</h2>";
}

?>
 

<div id='loadMyCourses'>
<?php checkMyCourse();  ?>
</div>



</div><!--lec_cards-->




<!--My courses-->


<!--create account-->
<div class='create_crt_container'>

<div class='crt_card'>

<div class='card_img'>
    <img src="images/create_course.jpg" alt="">
</div>
<div class='card_desc'>
      <h4>Get started</h4>
    <a href="#" data-bs-toggle="modal" data-bs-target="#createCourse" class='btn_cc'><i class="fa fa-plus"></i> Create course</a>
</div>

</div>


</div>




<!--create account-->

<!--process-->
<div class='process_cc'>
<h3 >Process of creating  course</h3>
<ol>
    
    <li>Create course.</li>
    <li>Add objective for the course.</li>
    <li>Add modules/sections for the course include resources if any.</li>
    <li>Add video under each module/section(first video becomes overview video).</li>
    <li>Optional: Also add other instructors if there is collaboration.</li>
</ol>



</div>
<!--process-->

<!--video tutorial-->
<!-- <div class='process_cc'>

<h4 style='text-decoration:underline;' >Video tutorial</h4>
<div class='tutorial_container'>
<video width='100%'  controls>
  <source src="media/video1.mp4" type="video/mp4">

</video>

</div>


</div> -->
<!--video tutorial-->


<!--helper-->



<!--helper-->


<script>
 $(document).ready(function(){

// Delete 
$('.course_delete').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
    var confirmalert = confirm("Are you sure you want to delete?");
    if (confirmalert == true) {
        // AJAX Request
        $.ajax({
            url: 'instructor.php',
            type: 'POST',
            data: { id:id },
         
        });
        $.ajax({
                    url: "includes/check_courses.php",
                    type: 'POST',
                    cache: false,
                  success: function(data){
                    $('#loadMyCourses').html(data); 
                  }
                    
      
                });
              

        
  
    }
});
});




</script>









<?php
if(isset($_POST['id'])){
    $the_csr_id = $_POST['id'];
    $the_csr_id = mysqli_real_escape_string($connection,$the_csr_id);

    $query = "DELETE FROM courses WHERE csr_id = '$the_csr_id'";
    $delete_course = mysqli_query($connection,$query);

    if(!$delete_course){
        die("Delete course query failed");

    }
}



?>
<?php include 'includes/footer.php'  ?>