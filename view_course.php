<?php include 'includes/header.php'  ?>
    <title>
    <?php
    if(isset($_GET['csr_id'])){
     $the_csr_id =   $_GET['csr_id'];
     $the_csr_id = mysqli_real_escape_string($connection,$the_csr_id);
     $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id'";
     $select_course = mysqli_query($connection,$query);
     if($select_course){
        while($row = mysqli_fetch_assoc($select_course)){
        $csr_title = $row['csr_title'];            
        }
        echo $csr_title;
     }
    }

    ?>

    </title>
    <style>
   


    </style>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php

if(isset($_GET['csr_id'])){
     $the_csr_id =   $_GET['csr_id'];
     $the_csr_id = mysqli_real_escape_string($connection,$the_csr_id);
     $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id'";
     $select_course = mysqli_query($connection,$query);
     if($select_course){
        while($row = mysqli_fetch_assoc($select_course)){
          $csr_id = $row['csr_id'];
        $csr_title = $row['csr_title'];  
        $topic_id = $row['topic_id'];
        $csr_desc = $row['csr_desc'];
        $instructor_id = $row['usr_id'];
        $lvl_id  = $row['lvl_id'];
        $res = $row['res'];          
     
      //check if csr has section and video

      //check if csr has section
     $query =  "SELECT * FROM modules_section WHERE csr_id = '$the_csr_id'";
     $check_exist_section = mysqli_query($connection,$query);
     while($row = mysqli_fetch_assoc($check_exist_section)){
     $db_csrID =  $row['csr_id'];
     }
     if(!isset($db_csrID)){
      header("Location: index.php");

     }
 
      //check if csr has a video
      $query =  "SELECT * FROM lectures WHERE csr_id = '$the_csr_id'";
      $check_exist_lecture = mysqli_query($connection,$query);
      while($row = mysqli_fetch_assoc($check_exist_lecture)){
      $db_lectID =  $row['csr_id'];
      }
      if(!isset($db_lectID)){
       header("Location: index.php");
 
      }




        }
    
     }
   
    ?>
<div class='background_course_container'>
  <div id='backg_csr_title'><img width='30px' src='images/icons8-certificate-50.png' alt=""><?php echo $csr_title ?></div> 
  <div id='backg_csr_instructor'><i class="fas fa-chalkboard-teacher"></i> <?php
  $query = "SELECT * FROM users WHERE usr_id  = '$instructor_id'";
  $select_instructor = mysqli_query($connection,$query);
  if($select_instructor){
    while($row = mysqli_fetch_assoc($select_instructor)){
    $instructor =  $row['username'];
    }
     echo $instructor; 
  }
 
  ?>
  </div>
  <div id='backg_csr_time'><i class="fas fa-clock"></i> 4.6 hrs</div>
  <div id='backg_csr_lang'><span><i class="fas fa-language"></i></span>  English</div>
  <div><span><i class="fas fa-user-graduate"></i></span> 
  <?php
  $query = "SELECT * FROM level_course WHERE lvl_id = $lvl_id"; 
  $select_level = mysqli_query($connection,$query);
  if($select_level){
    while($row = mysqli_fetch_assoc($select_level)){
     $lvl_title = $row['lvl_title'];
    }
    echo $lvl_title;
  }

  ?>
  
  </div>
  <div id='backg_res'><i class="fas fa-file"></i> 
 
  1 resources available</div>
  
</div>

<div id='save_enroll_cont'>   <!--save_enroll_cont-->
<?php displaySaveEnroll();  ?>

</div> <!--save_enroll_cont-->

    <div id='view_preview_cont'><!--view_preview_cont-->
  <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
  <?php
    $query = "SELECT * FROM modules_section WHERE csr_id = '$the_csr_id' ORDER BY sect_id ASC LIMIT 1 ";
    $first_section = mysqli_query($connection,$query);
    if($first_section){
      while($row = mysqli_fetch_assoc($first_section)){
        $sect_id = $row['sect_id'];
        
      }
      $query = "SELECT * FROM lectures WHERE sect_id = $sect_id ORDER BY lect_id ASC LIMIT 1";
      $first_lecture = mysqli_query($connection,$query);
      if($first_lecture){
        while($row = mysqli_fetch_assoc($first_lecture)){
          $video_url =  $row['video_url'];
          $lec_title = $row['lec_title'];
        } 
        ?>
        <iframe 
        id="player"
        width="550" height="350" 
        src="https://www.youtube.com/embed/<?php  echo $video_url; ?>?rel=0;" 
        title="YouTube video player" frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        allowfullscreen>

        </iframe>
    <?php  }
    }

    ?>
    
    
       
    
        <div id='course_objective'>
            <h2 style='text-decoration:underline;'>Course objectives</h2>
            <?php
             $query = "SELECT * FROM objectives_course WHERE csr_id =  '$the_csr_id'";
             $view_goals = mysqli_query($connection,$query);
             if($view_goals){
            
               while($row = mysqli_fetch_assoc($view_goals)){
             
                 $goal =  $row['goal'];


                 ?>
                <div style='display:block;'><span ><i class="fas fa-check-circle"></i>  </span> <?php echo  $goal;  ?> </div>
                 <?php }
                }

            ?>

        

        </div>
    </div><!--view_preview_cont-->
    
    <div class='desc_instructor'>

        <div class='course_desc'>
          <h3 style='text-decoration:underline;'>Description</h3>
        <?php echo $csr_desc ?>
        </div>

        <div class='instructor_div'>
         <h3 style='text-decoration:underline;'>Instructors</h3>

         <div class='profile_img_details'><!---profile_img_detail-->
         <?php
         $query = "SELECT * FROM users WHERE usr_id = '$instructor_id'";
         $get_main_inst = mysqli_query($connection,$query);
         if($get_main_inst){
          while($row = mysqli_fetch_assoc($get_main_inst)){
            $username =  $row['username'];
            $usr_id = $row['usr_id'];
          ?>
          
      
          <!--other profile-->
  <div class='prof_img'><img  src="images/profile.png" alt=""></div> 

         <div class='prof_details'>
         <div class='prof_title'><?php echo $username ?></div>
        <!-- <a href="instructor_profile.php?inst_id=<?php echo $usr_id ?>" class='view_link'>View profile</a> -->
        <!--Instructor--->
  <form action="profile_instructor.php" method="post">
     <?php 
   $query = "SELECT * FROM users WHERE usr_id = '$usr_id'";
   $select_instructor = mysqli_query($connection,$query);
   if($select_instructor){
    while($row = mysqli_fetch_assoc($select_instructor)){
      $username =  $row['username'];
    }
   
   }
   ?>
   <input type="hidden" value='<?php echo $usr_id ?>'name="inst_id">
   <button class='view_prof' name='instructor' type='submit'>view profile</button>

  </form>
     <!--Instructor--->
         </div>
        <div>
<!--profile-->
          
          <?php }
        
         }
         ?>






         <?php
         $query = "SELECT * FROM course_instructor WHERE csr_id = '$the_csr_id'";
         $get_instructors = mysqli_query($connection,$query);
         if($get_instructors){
          while($row = mysqli_fetch_assoc($get_instructors)){
             $inst_id =  $row['inst_id'];
          ?>
          
          <?php 
          $query = "SELECT * FROM users WHERE usr_id = '$inst_id'";
          $select_usr_inst = mysqli_query($connection,$query);
          while($row = mysqli_fetch_assoc($select_usr_inst)){
          $username =  $row['username'];
          $usr_id = $row['usr_id'];
          }
          ?>
          <!--other profile-->
  <div class='prof_img'><img  src="images/profile.png" alt=""></div> 

         <div class='prof_details'>
         <div class='prof_title'><?php echo $username ?></div>
        <!-- <a href="instructor_profile.php?inst_id=<?php echo $usr_id ?>" class='view_link'>View profile</a> -->
          <!--Instructor--->
  <form action="profile_instructor.php" method="post">
     <?php 
   $query = "SELECT * FROM users WHERE usr_id = '$usr_id'";
   $select_instructor = mysqli_query($connection,$query);
   if($select_instructor){
    while($row = mysqli_fetch_assoc($select_instructor)){
      $username =  $row['username'];
    }
   
   }
   ?>
   <input type="hidden" value='<?php echo $usr_id ?>'name="inst_id">
   <button class='view_prof' name='instructor' type='submit'>view profile</button>

  </form>
     <!--Instructor--->
         </div>
        <div>
<!--profile-->
          
          <?php }
        
         }
         ?>


        


         </div><!---profile_img_detail-->
       



        </div>
        

        
        </div><!--inst_profile-->

        </div>


    </div>

    <script>
 $(document).ready(function(){
   var the_csr_id = "<?php echo $the_csr_id; ?>";
// Delete 
$('#save_course').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
 
        // AJAX Request
        $.ajax({
            url: 'view_course.php?csr_id=<?php echo $the_csr_id; ?>',
            type: 'POST',
            data: { id:id }
         
        });
        document.getElementById("save_course").innerHTML = '<i class="fas fa-check"></i> Saved ';

        // $.ajax({
        //             url: "includes/check_save.php",
        //             type: 'POST',
        //             cache: false,
        //           success: function(data){
        //             $('#save_enroll_cont').html(data); 
        //           }
                    
      
        //         });
              

        
  
    
});
});




</script>


    <script>
      $(document).ready(function(){
  $("#not_login_enroll_course").click(function(){
     document.getElementById("demo_enrol").innerHTML = '<i class="fas fa-exclamation-triangle"></i> Login to enroll this course <a href="login.php">click here</a>';
    $("#demo_enrol").slideDown("slow");
    // $("#demo_enrol").slideUp(5000);

  });
});
$(document).ready(function(){
  $("#not_login_save_btn").click(function(){
    document.getElementById("demo_enrol").innerHTML = '<i class="fas fa-exclamation-triangle"></i> Login to save this course <a href="login.php">click here</a>';
    $("#demo_enrol").slideDown("slow");
    // $("#demo_enrol").slideUp(5000);

  });
});



     </script>

<?php
if(isset($_POST['id'])){
    $the_csr_id = $_POST['id'];
    $the_csr_id = mysqli_real_escape_string($connection,$the_csr_id);

    $sess_usr_id = $_SESSION['usr_id'];
    $query = "SELECT * FROM saved_courses WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
    $check_csr_saved = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($check_csr_saved)){
    $saved_csr_id = $row['csr_id'];
    }
    if(!isset($saved_csr_id)){

 $query = "INSERT INTO saved_courses(usr_id,csr_id)VALUES('$sess_usr_id','$the_csr_id')";
    $insert_saved_course = mysqli_query($connection,$query);

    if(!$insert_saved_course ){
        die("Saved course query failed");

    }

    }



   
}



?>



  <?php   }else{
    header("Location: index.php");
  } ?>
<?php include 'includes/footer.php'  ?>