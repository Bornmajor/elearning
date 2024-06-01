<?php include 'includes/header.php'  ?>
    <title>
     <?php
     if(isset($_POST['instructor'])){

      $inst_id =  $_POST['inst_id'];

      $inst_id = mysqli_real_escape_string($connection,$inst_id);
         $query = "SELECT * FROM users WHERE usr_id = '$inst_id'";
 $select_user = mysqli_query($connection,$query);
 if($select_user){
    while($row = mysqli_fetch_assoc($select_user)){
       $username = $row['username'];
       $elearn_mail = $row['elearn_mail'];
       $prof = $row['prof'];
    }
  echo $username;
 }

     }else{
        header("Location:index.php");
     }


?>
    </title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>    

<div class='container_prof'>


   <div class='inst_prof_div'><!--inst_prof_div--->

     <div class='inst_prof_img'><!--inst_prof_img--->
        <img src="images/profile.png" alt="">

     </div><!--inst_prof_img--->

    <div class='inst_details'><!--inst_details--->
  
     <div class='inst_prof_text'><span class='inst_prof_text_title'> Name</span> : <?php echo $username; ?></div>
     <div class='inst_prof_text'><span class='inst_prof_text_title'> Email</span>: <?php echo $elearn_mail; ?> </div>
     <div class='inst_prof_text'><span class='inst_prof_text_title'> Specialization</span>: <?php  echo $prof ?></div>
     <?php  
     $query = "SELECT * FROM courses WHERE usr_id = '$inst_id'";
   $select_courses = mysqli_query($connection,$query);
   $total_courses = mysqli_num_rows($select_courses);

     ?>
     <div class='inst_prof_text'><span class='inst_prof_text_title'>Courses teaching </span> : <?php echo $total_courses ?> </div>

       <?php
    $query = "SELECT * FROM usr_course WHERE inst_id = '$inst_id'";
      $select_usr_course = mysqli_query($connection,$query);
     $total_students = mysqli_num_rows($select_usr_course);

    ?>
     
     <div class='inst_prof_text'><span class='inst_prof_text_title'> Students taught </span> : <?php echo $total_students ?> </div>



    </div><!--inst_details--->


   </div><!--inst_prof_div--->




</div>


<?php include 'includes/footer.php'  ?>