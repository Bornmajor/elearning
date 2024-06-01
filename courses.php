<?php include 'includes/header.php'  ?>
    <title>Courses</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<div class='img_container'><img  src="images/elearn.png" alt=""></div>

<?php include 'includes/search.php'  ?>


<hr>
<?php 
  if(isset($_GET['q'])){
  $course_title =  $_GET['q'];
  $course_title = mysqli_real_escape_string($connection,$course_title);

  }else{
    header("Location: index.php");
  }
?>

<!--COURSES-->
<div class='lec_cards'><!--lec_cards-->
  <!-- <h2 class='pop_title'>Popular courses</h2> -->


<?php 

$query = "SELECT * FROM courses WHERE csr_title LIKE '%$course_title%'";
$select_pop_courses = mysqli_query($connection,$query);
if($select_pop_courses){
    while($row = mysqli_fetch_assoc($select_pop_courses)){
      $csr_id =  $row['csr_id'];
      $csr_title = $row['csr_title'];
      $csr_img = $row['csr_img'];
      $usr_id = $row['usr_id'];

      ?>
              <!--card-->
<a class='lec_link' href="view_course.php?csr_id=<?php echo $csr_id ?>">
<div class="card" style="width: 15rem;">
<img src="uploads/<?php echo $csr_img ?>" class="card-img-top" alt="...">
<div class="card-body">
<div class='card_b_title'><img width='30px' src='images/icons8-licence-50.png' alt=""><?php echo $csr_title ?></div>
<div class='card_b_inst'><i class="fas fa-chalkboard-teacher"></i>
<!--Instructor--->
<?php 
$query = "SELECT * FROM users WHERE usr_id = '$usr_id'";
$select_instructor = mysqli_query($connection,$query);
if($select_instructor){
while($row = mysqli_fetch_assoc($select_instructor)){
  $username =  $row['username'];
}
echo $username;
}
?>

</div>
<?php  
$query = "SELECT * FROM usr_course WHERE csr_id = '$csr_id'";
$check_usr_csr = mysqli_query($connection,$query);
if($check_usr_csr){
$total_stud_csr = mysqli_num_rows($check_usr_csr);
}


?>
<div class='card_b_stud'><i class="fas fa-users"></i> Students enrolled: <?php echo $total_stud_csr; ?></div>
<!-- <div class='card_b_time'><i class="fas fa-clock"></i> 4.6 hrs</div> -->
<a href="lectures.php?csr_id=<?php echo $csr_id  ?>&continue=<?php echo $csr_id  ?>" id='card_b_view' class='btn btn-primary'>View more</a>

<!-- <h6>Ratings</h6> -->
<!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
</div>
</div>
</a>
<!--card-->
  <?php  }


}

?>
</div>


<?php include 'includes/footer.php'  ?>
