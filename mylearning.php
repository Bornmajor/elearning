<?php include 'includes/header.php'  ?>
    <title>My courses</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>


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










<?php include 'includes/footer.php'  ?>
