<?php include 'includes/header.php'  ?>
    <title>Home</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<div class='img_container'><img  src="images/elearn.png" alt=""></div>

<?php include 'includes/search.php'  ?>


<hr>

<!--MYLEARNING-->
<div  class='lec_cards'><!--lec_cards-->
<?php
$sess_usr_id  = $_SESSION['usr_id']; 

 $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id'";
 $check_exist_mycourse = mysqli_query($connection,$query);
 if($check_exist_mycourse){
  while($row = mysqli_fetch_assoc($check_exist_mycourse)){
   $db_usr_id = $row['usr_id'];
  }
  if(isset($db_usr_id)){
    echo " <h2 class='pop_title'>My Courses</h2>";
  }
 }
?>
 
 <?php    
 viewMyCourses();
 
 
 
 ?>

 






</div><!--lec_cards-->




<!--POPULAR COURSES-->
<div class='lec_cards'><!--lec_cards-->
  <h2 class='pop_title'>Popular courses</h2>

  <?php viewPopularCourses();  ?>






</div><!--lec_cards-->

<!--RECOMMENDED-->
<?php
if(isset($sess_usr_id)){
  $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id'";
  $select_csr_usr = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($select_csr_usr)){
   $usr_topic_id = $row['topic_id'];
  }
  if(isset($usr_topic_id)){
    ?>
<div class='lec_cards'><!--lec_cards-->
  <h2 class='pop_title'>Courses recommended for you</h2>
  <?php }
}

?>


 <?php viewRecommendCourse();  ?>




</div><!--lec_cards-->

<!--TOPICS-->
<?php
if(isset($sess_usr_id)){
  $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id'";
  $select_csr_usr = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($select_csr_usr)){
   $usr_topic_id = $row['topic_id'];
  }
  if(isset($usr_topic_id)){
    ?>

 <div class='pop_title'>Topics you might be interested</div>
  <?php }
}

?>

<div class='div_topics_cards'><!--div_topics_cards-->
 
<div class='topic_center'>
  
  
<?php
$sess_usr_id = $_SESSION['usr_id'];
 viewInterestTopics();
  ?>




</div>


</div><!--div_topics_cards-->





<?php include 'includes/footer.php'  ?>
