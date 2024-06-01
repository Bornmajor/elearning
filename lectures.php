<?php
if(isset($_POST['insert_note'])){
  $note = $_POST['editordata'];

  setcookie("Elearn_note",$note,time()+30*24*60*60);

  header("Location: lectures.php?csr_id=".$_GET['csr_id']."&continue={$the_csr_id}");
}
// setcookie("name","Osborn",time()+30*24*60*60);
  

// echo $_COOKIE['PHPSESSID'];
  


?>
<?php include 'includes/header.php'  ?>
<style> 

.section_div{
    margin:20px;
}
.section_col{
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 5px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 14px;
}

.active, .section_cole:hover {
  background-color: #555;
}

.section_col:after {
  content: '\002B';
  color: white;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}

.content {
  padding: 0 15px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background-color: #f1f1f1;
}

</style>
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
   

    ?>

</title>
<!-- include libraries(jQuery, bootstrap) -->
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php 
//call functions
checkUsrSession(); 
?>
<?php
//UPDATE last watched
if(isset($_GET['check_last_watch'])){
    $sess_usr_id  = $_SESSION['usr_id'];
    $watch_id = $_GET['check_last_watch'];
    $watch_id  = mysqli_real_escape_string($connection,$watch_id);

    $query = "UPDATE last_watch_lecture SET lect_id = $watch_id WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
    $update_last_watched = mysqli_query($connection,$query);
    if(!$update_last_watched){
        die("Updated last watched query failed");
    }
}

?>

<div class='video_section'><!--video_section-->

<div class='video_div'><!--video_div-->
<?php
if(isset($_GET['firsttime'])){
    //check if already enrolled course

    $sess_usr_id = $_SESSION['usr_id'];
    $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
    $check_course_exist = mysqli_query($connection,$query);
    if($check_course_exist){
        while($row = mysqli_fetch_assoc($check_course_exist)){
         $db_exist_csr_id =  $row['csr_id'];
        }
      
            if($the_csr_id !== $db_exist_csr_id){


                //display first video in  a csr
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
                      $first_lect_id = $row['lect_id'];
                      $video_url =  $row['video_url'];
                      $lec_title = $row['lec_title'];
                    } 
                    displayLecture();

                  }
                }
            
                //enrol user in acourse
                //extract topic id and add usr_course
                $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id'";
                $select_topic_id = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($select_topic_id)){
                  $inst_id = $row['usr_id'];
                $topic_id =  $row['topic_id'];
                }

                $sess_usr_id = $_SESSION['usr_id'];
                $query = "INSERT INTO usr_course(usr_id,csr_id,topic_id,inst_id)VALUES('$sess_usr_id','$the_csr_id',$topic_id,'$inst_id')";
                $enrol_first_csr = mysqli_query($connection,$query);
                if($enrol_first_csr){
                    echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
                    You are now enrolled in this course!!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }else{
                    die("Course enrollement failed!!");
                }
                //record last watch video in this csr
                $query = "INSERT INTO last_watch_lecture(usr_id,csr_id,lect_id)VALUES('$sess_usr_id','$the_csr_id',$first_lect_id)";
                $insert_query = mysqli_query($connection,$query);
                if($insert_query){

                    echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
                    You can now track your learning progress
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                     //redirect
                     
                       header("Location: lectures.php?csr_id=".$_GET['csr_id']."&continue={$the_csr_id}");
                    
                }else{
                    die("Track progress admission failed!!");
                }
            

            
            }else{
           
                header("Location: lectures.php?csr_id=".$_GET['csr_id']."&continue={$the_csr_id}");

            }
        

    }

   



}
 if(isset($_GET['continue'])){
    //check if usr enroll to this course
    $sess_usr_id = $_SESSION['usr_id'];
    
    $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
    $check_enrolled = mysqli_query($connection,$query);
     while($row = mysqli_fetch_assoc($check_enrolled)){
      $db_csr_id = $row['csr_id'];
     }
      //check if db csr id exist
     
        if($the_csr_id !== $db_csr_id){
            header("Location: view_course.php?csr_id=".$_GET['csr_id']."");


        }else{
        //csr exist
           //fetch last watch  lecture
           $sess_usr_id = $_SESSION['usr_id'];
       $query = "SELECT * FROM last_watch_lecture WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
       $fetch_last_watched = mysqli_query($connection,$query);
       if($fetch_last_watched){
        while($row = mysqli_fetch_assoc($fetch_last_watched)){
        $lect_id = $row['lect_id'];

        }
       
        $query = "SELECT * FROM lectures WHERE lect_id = $lect_id";
        $select_cur_lect = mysqli_query($connection,$query);
        if($select_cur_lect){
            while($row = mysqli_fetch_assoc($select_cur_lect)){
             $video_url =  $row['video_url'];
             $lect_id = $row['lect_id'];
             $lec_title = $row['lec_title'];
            }
      
        displayLecture();

         
        }
      }


    }
    



}

?>
<!--btn progress-->
<?php
if(isset($_GET['done'])){
  //record progresss via progress btn
  $sess_usr_id = $_SESSION['usr_id'];
  $done_lecture = $_GET['done'];
  $done_lecture = mysqli_real_escape_string($connection,$done_lecture);
  
  $query = "SELECT * FROM cover_lectures WHERE lect_id = $done_lecture AND usr_id = '$sess_usr_id'";
  $check_cover_exist = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($check_cover_exist)){
  $db_lect_cvr_id =  $row['lect_id'];


  }
  // echo $db_lect_cvr_id;
 
  if(!isset($db_lect_cvr_id)){
  
      //not cover the lecture
    //record cover lectures via progress btn
      $query = "INSERT INTO cover_lectures(lect_id,usr_id,csr_id)VALUES('$done_lecture','$sess_usr_id','$the_csr_id')";
      $insert_cover_lecture = mysqli_query($connection,$query);
      if(!$insert_cover_lecture){
        die("Cover lecture query failed!!");
      }
  }

}
?>
<?php

 $query = "SELECT * FROM lectures WHERE lect_id > $lect_id AND csr_id = '$the_csr_id' ORDER BY lect_id ASC LIMIT 1 ";
 $select_nxt_lect = mysqli_query($connection,$query);
 if($select_nxt_lect){
  while($row = mysqli_fetch_assoc($select_nxt_lect)){
  $nxt_lect =  $row['lect_id'];
  }
  // echo $nxt_lect;
 }

 $query = "SELECT MAX(lect_id) as max_items FROM  lectures WHERE csr_id = '$the_csr_id'";
 $select_last_lect = mysqli_query($connection,$query);
 while($row = mysqli_fetch_assoc($select_last_lect)){
 $last_lect_id = $row['max_items'];
 
 }

if($last_lect_id === $lect_id){

   //count total lectures for current course
    $query ="SELECT * FROM lectures WHERE csr_id = '$the_csr_id'";
    $count_total_lects = mysqli_query($connection,$query);
    $all_total_lectures = mysqli_num_rows($count_total_lects);


    //count total covered by current_usr
    $sess_usr_id = $_SESSION['usr_id'];
    $query = "SELECT * FROM cover_lectures WHERE csr_id = '$the_csr_id' AND usr_id = '$sess_usr_id '";
    $count_total_covered = mysqli_query($connection,$query);
    $all_covered_usr_lecture = mysqli_num_rows($count_total_covered);
   
   
 
    if($all_total_lectures == $all_covered_usr_lecture){
       echo "<div class='alert alert-success' role='alert'>
       Congratulation you have completed this course
     </div>";
 
    }else{
      echo " <div class='btn_progress'><a href='lectures.php?csr_id=$the_csr_id&continue=$the_csr_id&done=$lect_id' class='btn btn-success'> Finish</a></div>";
   
    }   
  ?>

 
 <?php
  }else{
   //fetch last watch  lecture
  
    // echo $lect_id;
  ?>
  <div class='btn_progress'><a href="lectures.php?csr_id=<?php echo $the_csr_id ?>&continue=<?php echo $the_csr_id ?>&check_last_watch=<?php echo $nxt_lect ?>&done=<?php echo $lect_id ?>" class='btn btn-primary'>Progress</a></div>


<?php }

   //count total lectures for current course
   $query ="SELECT * FROM lectures WHERE csr_id = '$the_csr_id'";
   $count_total_lects = mysqli_query($connection,$query);
   $all_total_lectures = mysqli_num_rows($count_total_lects);


   //count total covered by current_usr
   $sess_usr_id = $_SESSION['usr_id'];
   $query = "SELECT * FROM cover_lectures WHERE csr_id = '$the_csr_id' AND usr_id = '$sess_usr_id '";
   $count_total_covered = mysqli_query($connection,$query);
   $all_covered_usr_lecture = mysqli_num_rows($count_total_covered);


 echo "<div 
      class='alert alert-info' role='alert'>
     You have $all_covered_usr_lecture|$all_total_lectures lectures completed
    </div>";

?>




</div>

<div class='section_div'><!--section_div--->
<?php
$a =1;
$query = "SELECT * FROM modules_section WHERE csr_id = '$the_csr_id'";
$select_sections = mysqli_query($connection,$query);
if($select_sections){
    while($row = mysqli_fetch_assoc($select_sections)){
        $sect_id = $row['sect_id'];
    $objective =  $row['objective'];


    ?>
<button class="section_col"><span><?php echo $a++; ?>.</span> <?php echo $objective  ?></button>
<div class="content">
    <?php
    $b = 1;
    $query = "SELECT * FROM lectures WHERE sect_id = $sect_id ";
    $select_all_modules = mysqli_query($connection,$query);
    if($select_all_modules){
        while($row = mysqli_fetch_assoc($select_all_modules)){
         $lect_id =  $row['lect_id'];
         $lec_title =   $row['lec_title'];

         ?>
  <div><span><?php echo $b++; ?>.</span> <a  href="lectures.php?csr_id=<?php echo $the_csr_id ?>&continue=<?php echo $the_csr_id ?>&check_last_watch=<?php echo $lect_id ?>"><?php echo $lec_title ?></a>
     <span>
      <?php
      $query = "SELECT * FROM cover_lectures WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
      $check_complete_lect = mysqli_query($connection,$query);
      while($row = mysqli_fetch_assoc($check_complete_lect)){
      $db_comp_lect_id =  $row['lect_id'];
      
      if(isset($db_comp_lect_id)){
        if($db_comp_lect_id === $lect_id){
          //check if usr covered lecture id

          //if usr covered this lecture
        echo "<i style='color:green;' class='fas fa-check-circle'></i>";
        }
      
      }
      }
      ?>
    

    </span>
        </div>
        <?php }
    }

    ?>

</div>
    <?php }
}

?>

<div class='notes'>
  <h3 style='text-decoration:underline;'>Notepad tool</h3>
  <form  id='form_note' method="post">
  <textarea id="summernote" name="editordata">

  </textarea>

</form>
 <div class='btn_note_submit' ><button id='insert_note' onclick='setCookie();' class='btn btn-secondary' type="submit" name='insert_note'>SAVE</button></div>


</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
    
  //  var noteText = document.getElementById("summernote").value ;
// document.getElementById("summernote").innerHTML =  document.cookie ;
   function setCookie(){
     var noteText = document.getElementById("summernote").value;

    document.cookie = "note="+noteText;

    

     

   }

 
 
    
  </script>
 


</div><!--section_div--->


</div><!--video_section-->


<div>

</div>




<script>
var sect = document.getElementsByClassName("section_col");
var i;

for (i = 0; i < sect.length; i++) {
  sect[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>

<?php  } ?>
<?php include 'includes/footer.php'  ?>
