<?php
function checkUsrSession(){
    global  $connection;
    if(!isset($_SESSION['elearn_mail'])){
        header("Location: index.php");

    }



}

function insertCourse(){
    global  $connection;
    if(isset($_POST['insert_course'])){

      $csr_id = bin2hex(random_bytes(8));
      $csr_title =  $_POST['csr_title'];
      $topic_id =  $_POST['topic_id'];
      $csr_desc =   $_POST['csr_desc'];
      $usr_id =  $_SESSION['usr_id'];
    
      $lvl_id = $_POST['lvl_id'];
      

      $csr_title  = mysqli_real_escape_string($connection,$csr_title);
      $topic_id  = mysqli_real_escape_string($connection,$topic_id);
      $csr_desc  = mysqli_real_escape_string($connection,$csr_desc);
      $usr_id  = mysqli_real_escape_string($connection,$usr_id);
    
      $lvl_id  = mysqli_real_escape_string($connection,$lvl_id);
      




      $csr_img = $_FILES['image']['name'];
      $csr_img_temp= $_FILES['image']['tmp_name'];

      $res = $_FILES['pdf']['name'];
      $res_temp= $_FILES['pdf']['tmp_name'];

      //move file
      move_uploaded_file($csr_img_temp,"uploads/$csr_img");
      move_uploaded_file($res_temp,"uploads/$res");

      //check  csr id exist
       $query = "SELECT * FROM courses  WHERE csr_id = '$csr_id'";
       $select_course = mysqli_query($connection,$query);
       if($select_course){
        while($row = mysqli_fetch_assoc($select_course)){
           $db_csr_id = $row['csr_id'];

        }
        if(isset($db_csr_id)){
            if($csr_id === $db_csr_id){
                $csr_id = bin2hex(random_bytes(8));

            }

        }

      
        $query = "INSERT INTO courses(csr_id,csr_title,topic_id,csr_desc,usr_id,csr_img,lvl_id,res)VALUES('$csr_id','$csr_title',$topic_id,'$csr_desc','$usr_id','$csr_img',$lvl_id,'$res') ";
        $insert_query = mysqli_query($connection,$query);
        if($insert_query){
            echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
            <strong>You have successfully created your course</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        //
        
        $query = "SELECT * FROM users WHERE usr_id = '$usr_id'";
        $check_inst = mysqli_query($connection,$query);
        if($check_inst){
            while($row = mysqli_fetch_assoc($check_inst)){
             $db_usr_role = $row['usr_role'];

            }
            if(isset($db_usr_role)){
                if($db_usr_role !== 'instructor'){
                    $query = "UPDATE users SET usr_role = 'instructor' WHERE usr_id = '$usr_id'";
                    $update_role = mysqli_query($connection,$query);
                    if($update_role){
                        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
                        <i class='fas fa-chalkboard-teacher'></i> You are now a instructor
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";


                    }else{
                        die("User role query failed");
                    }

                }
            }
        }
           

        }
 }
    }

}


function insertCourseGoal(){
    global  $connection;
    if(isset($_POST['insert_goal'])){
    $goal = $_POST['goal'];
    $csr_id =  $_POST['csr_id'];

    $goal =  mysqli_real_escape_string($connection,$goal);
    $csr_id = mysqli_real_escape_string($connection,$csr_id);

    $query = "INSERT INTO objectives_course(goal,csr_id)VALUES('$goal','$csr_id')";
    $insert_goal = mysqli_query($connection,$query);
    if($insert_goal){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        Objective Added successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";


    }




    }


}
function viewCourseGoal(){
    global  $connection;
    global $the_csr_id;

    $query = "SELECT * FROM objectives_course WHERE csr_id =  '$the_csr_id'";
    $view_goals = mysqli_query($connection,$query);
    if($view_goals){
   
      while($row = mysqli_fetch_assoc($view_goals)){
        $object_id =  $row['object_id'];
        $goal =  $row['goal'];
        ?>
         <div style='display:block;padding:5px;'><span ><i class="fas fa-check-circle"></i>  </span> <?php echo $goal;  ?> <a class='link_color' title='Delete item' href="view_goals.php?delete_goal=<?php echo $object_id  ?>&csr_id=<?php echo $the_csr_id ?>"><i class="fas fa-trash"></i></a></div>

      <?php }

    }


    
}
function addCollaborators(){
    global  $connection;
     
    if(isset($_POST['add_collaborator'])){
      $csr_id =  $_POST['csr_id'];
      $inst_id =  $_POST['inst_id'];

      $query = "INSERT INTO course_instructor(csr_id,inst_id)VALUES('$csr_id','$inst_id')";
      $insert_collaborator = mysqli_query($connection,$query);
      if($insert_collaborator){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        Instructor added successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
      }else{
        die("Addcollaborators query failed!!");
      }

    }


}
function viewOtherInstructors(){
    global  $connection;
    global $the_csr_id;

    $query = "SELECT * FROM course_instructor WHERE csr_id =  '$the_csr_id'";
    $view_instructors = mysqli_query($connection,$query);
    if($view_instructors){
   
      while($row = mysqli_fetch_assoc($view_instructors)){
        $csr_inst_id =  $row['csr_inst_id'];
        $inst_id =  $row['inst_id'];
        ?>
         <div style='display:block;padding:5px;'><span ><i class="fas fa-chalkboard-teacher"></i> </span> <?php
         //check usr who is fellow instructor
         $query = "SELECT * FROM users WHERE usr_id = '$inst_id'";
         $select_other_inst = mysqli_query($connection,$query);
         if($select_other_inst){
            while($row = mysqli_fetch_assoc($select_other_inst)){
              $username =   $row['username'];
            }
          echo $username;

         }
         ?> 
         <a class='link_color' title='Delete item' href="add_instructor.php?delete_inst=<?php echo  $csr_inst_id  ?>&csr_id=<?php echo $the_csr_id ?>"><i class="fas fa-trash"></i></a></div>

      <?php }

    }


    
}
function viewUsersInstructors(){
    global  $connection;

    $query = "SELECT * FROM users WHERE usr_role = 'instructor'";
    $select_user_instructors  = mysqli_query($connection,$query);
    if($select_user_instructors){
        while($row = mysqli_fetch_assoc($select_user_instructors)){
           $usr_id = $row['usr_id'];
           $username = $row['username'];

           ?>
         <option value="<?php echo $usr_id ?>"><?php echo $username ?></option>

        <?php }
    }

}

function selectTopics(){
    global  $connection;
    $query = "SELECT * FROM topics ";
    $select_topics = mysqli_query($connection,$query);
    if($select_topics){
        while($row = mysqli_fetch_assoc($select_topics)){
            $top_id = $row['top_id'];
           $top_title = $row['top_title'];

      
        ?>
   
    
    <option value="<?php echo $top_id ?>"><?php echo $top_title ?></option>
  
 

        <?php  }
    }

}

function selectLevels(){
    global  $connection;
    $query = "SELECT * FROM level_course";
    $select_levels = mysqli_query($connection,$query);
    if($select_levels){
        while($row = mysqli_fetch_assoc($select_levels)){
            $lvl_id = $row['lvl_id'];
           $lvl_title = $row['lvl_title'];

      
        ?>
   
    
    <option value="<?php echo $lvl_id ?>"><?php echo $lvl_title ?></option>
  
 

        <?php  }
    }




}
function registerUser(){
    global  $connection;

    if(isset($_POST['register_user'])){
    $usr_id = uniqid();
    $elearn_mail = $_POST['elearn_mail'];
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];

    $elearn_mail =  mysqli_real_escape_string($connection,$elearn_mail);
    $username = mysqli_real_escape_string($connection,$username);
    $pwd = mysqli_real_escape_string($connection,$pwd);
    
     $elearn_mail = strtolower($elearn_mail);

    $check_usr_query = "SELECT * FROM users WHERE elearn_mail = '$elearn_mail'";
    $select_usr = mysqli_query($connection,$check_usr_query);
    while($row = mysqli_fetch_assoc($select_usr)){
    $db_el_mail = $row['elearn_mail'];

    }
    if(isset($db_el_mail)){
        if($elearn_mail === $db_el_mail){
            echo "<div class='alert alert-danger  alert-dismissible fade show' role='alert'>
            Email used already exist!!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";  
        }
    }else{
        $check_usr_id = "SELECT * FROM users WHERE usr_id = '$usr_id'";
        $select_id = mysqli_query($connection,$check_usr_id);
        while($row = mysqli_fetch_assoc($select_id)){
        $db_usr_id = $row['usr_id'];
    
        }
        if(isset($db_usr_id)){
             if($db_usr_id === $usr_id){
                //regenerate id if already exist
            $usr_id = uniqid();      
        } 
        }
        $pwd = password_hash($pwd,PASSWORD_BCRYPT,array('cost' => 12));

    $query = "INSERT INTO users(usr_id,elearn_mail,username,pwd)VALUES('$usr_id','$elearn_mail','$username','$pwd')";
    $insert_usr = mysqli_query($connection,$query);
    if($insert_usr){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        <strong>You have successfully setup your account</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }

    
     }


  
    }
  

}
function loginUser(){
    global  $connection;

    if(isset($_POST['login_user'])){
       $elearn_mail = $_POST['elearn_mail'];
      $pwd =  $_POST['pwd'];

      $elearn_mail =  mysqli_real_escape_string($connection,$elearn_mail);
      $pwd = mysqli_real_escape_string($connection,$pwd);

      $query = "SELECT * FROM users WHERE elearn_mail = '$elearn_mail'";
      $select_usr = mysqli_query($connection,$query);
      if($select_usr){
        while($row = mysqli_fetch_assoc($select_usr)){
          $db_el_mail =  $row['elearn_mail'];
          $db_pwd =  $row['pwd'];
          $db_usr_id = $row['usr_id'];
        }
        if(isset($db_el_mail)){
            if(password_verify($pwd,$db_pwd)){
                $_SESSION['usr_id'] = $db_usr_id;
                $_SESSION['elearn_mail'] = $db_el_mail;
                
                echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
                <strong>You have successfully login</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";


                      //redirect
                        echo "
                            <script type='text/javascript'>
                            window.setTimeout(function() {
                                window.location = 'index.php';
                            }, 2000);
                            </script>
                            ";

               



            }else{
                echo "<div class='alert alert-danger  alert-dismissible fade show' role='alert'>
                Password is incorrect!!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";  

            }
        }else{
          echo "<div class='alert alert-danger  alert-dismissible fade show' role='alert'>
         User email does not exist!!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>"; 

        }
      }

    }

}
function isLoggedIn(){
    if(isset($_SESSION['elearn_mail'])){
        return true;
    }
    return false;
}
function viewMyCourses(){
    global  $connection;
    global $sess_usr_id;

    $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id'";
    $select_mycourse = mysqli_query($connection,$query);
    if($select_mycourse){
        while($row = mysqli_fetch_assoc($select_mycourse)){
        $usr_enrol_csr_id =  $row['csr_id'];

       
        $query = "SELECT * FROM courses WHERE csr_id = '$usr_enrol_csr_id'";
        $get_my_courses = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($get_my_courses)){
            $csr_id =  $row['csr_id'];
            $csr_title = $row['csr_title'];
            $csr_img = $row['csr_img'];
            $usr_id = $row['usr_id'];
        }
        ?>
                <!--card-->
<a class='lec_link' href="view_course.php?csr_id=<?php echo $csr_id ?>">
<div class="card" style="width: 15rem;">
  <img src="uploads/<?php echo $csr_img ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <div class='card_b_title'>
    
    <?php echo $csr_title = substr($csr_title,0,20).'...'; ?>
  </div>
    <div class='card_b_inst'>
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
   <button class='inst_link' name='instructor' type='submit'><i class='fas fa-chalkboard-teacher'></i> <?php  echo  $username;  ?></button>

  </form>
     <!--Instructor--->
   </div>
   <?php  
   $query = "SELECT * FROM usr_course WHERE csr_id = '$csr_id'";
   $check_usr_csr = mysqli_query($connection,$query);
   if($check_usr_csr){
   $total_stud_csr = mysqli_num_rows($check_usr_csr);
   }


   ?>
   </a>
   <div class='card_b_stud'><i class="fas fa-users"></i> Students enrolled: <?php echo $total_stud_csr; ?></div>

    <!-- <div class='card_b_time'><i class="fas fa-clock"></i> 4.6 hrs</div> -->
    <a href="lectures.php?csr_id=<?php echo $csr_id  ?>&continue=<?php echo $csr_id  ?>" id='card_b_view' class='btn btn-primary'>Continue</a>
   
   <?php 
   $query = "SELECT * FROM cover_lectures WHERE csr_id = '$csr_id' AND usr_id = '$sess_usr_id '";
    $count_total_covered = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($count_total_covered)){
     $cvr_usr_id = $row['usr_id'];
    }
    if(isset($cvr_usr_id)){
 //count total lectures for current course
    $query ="SELECT * FROM lectures WHERE csr_id = '$csr_id'";
    $count_total_lects = mysqli_query($connection,$query);
    $all_total_lectures = mysqli_num_rows($count_total_lects);
 
 
    //count total covered by current_usr
     $sess_usr_id = $_SESSION['usr_id'];

   
    $all_covered_usr_lecture = mysqli_num_rows($count_total_covered);

    //check if user completed a course
    if($all_total_lectures == $all_covered_usr_lecture){
      echo "<div style='padding:5px;margin-top:5px;font-size:14px;'
    class='alert alert-success' role='alert'>
    Congratulation you have completed this course
  </div>";
    }else{
    echo "<div style='padding:5px;margin-top:5px;font-size:14px;'
    class='alert alert-info' role='alert'>
   You have $all_covered_usr_lecture|$all_total_lectures lectures completed
  </div>";

    }
 


    }
   


   

   
   ?>
    
    <!-- <h6>Ratings</h6> -->
    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
  </div>
</div>
</a>
<!--card-->

       <?php }  
    }



}

function userCourseProgress(){
  global  $connection;
  global $csr_id;

   //count total lectures for current course
   $query ="SELECT * FROM lectures WHERE csr_id = '$csr_id'";
   $count_total_lects = mysqli_query($connection,$query);
   $all_total_lectures = mysqli_num_rows($count_total_lects);


   //count total covered by current_usr
   $sess_usr_id = $_SESSION['usr_id'];
   $query = "SELECT * FROM cover_lectures WHERE csr_id = '$csr_id' AND usr_id = '$sess_usr_id '";
   $count_total_covered = mysqli_query($connection,$query);
   $all_covered_usr_lecture = mysqli_num_rows($count_total_covered);


 echo  $all_covered_usr_lecture / $all_total_lectures ;
    
  
}


function viewCourseTopics(){
  global  $connection;
  global $the_ind_id;
    global $sess_usr_id;

    $query = "SELECT * FROM topics WHERE ind_id = $the_ind_id ";
    $select_topic = mysqli_query($connection,$query);
    if($select_topic){
       while($row = mysqli_fetch_assoc($select_topic)){
        $top_id = $row['top_id'];
     
       $query = "SELECT * FROM courses WHERE topic_id = $top_id";
       $select_csr_topics = mysqli_query($connection,$query);
       if($select_csr_topics){
        while($row = mysqli_fetch_assoc($select_csr_topics)){
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
    <div class='card_b_title'>
    <?php echo $csr_title = substr($csr_title,0,15).'...'; ?>
  </div>
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
          


        <?php
          }
     
         }
      }
     
   
       }
       
        
    }
        



function viewPopularCourses(){
    global  $connection;

    $query = "SELECT * FROM courses LIMIT 10";
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
  <img  src="uploads/<?php echo $csr_img ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <div class='card_b_title'>
    <?php echo $csr_title = substr($csr_title,0,25).'...'; ?>
  </div>
    <div class='card_b_inst'>

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
   <button class='inst_link' name='instructor' type='submit'><i class='fas fa-chalkboard-teacher'></i> <?php  echo  $username;  ?></button>

  </form>
     <!--Instructor--->

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
}

function viewSearchCourses(){
  global  $connection;
  global $course_title;



  $query = "SELECT * FROM courses WHERE csr_title LIKE '$course_title'";
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
  <div class='card_b_title'></div>
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
}


function viewWishlistCourses(){
  global  $connection;
  $sess_usr_id = $_SESSION['usr_id'];
  $query = "SELECT * FROM saved_courses WHERE usr_id = '$sess_usr_id' ";
  $select_wishlist = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($select_wishlist)){
    $db_saved_csr_id = $row['csr_id'];

  

  $query = "SELECT * FROM courses WHERE csr_id = '$db_saved_csr_id'";
  $select_saved_courses = mysqli_query($connection,$query);
  if($select_saved_courses){
      while($row = mysqli_fetch_assoc($select_saved_courses)){
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
  <div class='card_b_title'><?php echo $csr_title ?></div>
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
}
 $total_saved = mysqli_num_rows($select_wishlist);
 if($total_saved == 0){
  echo "<div class='empty_rows'>Your wishlist is empty</div>";
 }
}





function viewRecommendCourse(){
  global  $connection;
  global $sess_usr_id;

  if(isset($sess_usr_id)){
    $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id'";
    $select_usr_csr = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_usr_csr)){
    $usr_topic_id =  $row['topic_id'];

    if(isset($usr_topic_id)){

      $query = "SELECT * FROM topics WHERE top_id =$usr_topic_id";
      $select_int_topics = mysqli_query($connection,$query);
 
      if($select_int_topics){
         while($row = mysqli_fetch_assoc($select_int_topics)){
          $top_id = $row['top_id'];
          $top_title =  $row['top_title'];

          
    $query = "SELECT * FROM courses WHERE topic_id = $top_id";
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
    <div class='card_b_title'><?php echo $csr_title = substr($csr_title,0,25).'...'; ?></div>
    <div class='card_b_inst'>
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
   <button class='inst_link' name='instructor' type='submit'><i class='fas fa-chalkboard-teacher'></i> <?php  echo  $username;  ?></button>

  </form>
     <!--Instructor--->
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
 
        <?php 
         }
        }  
      }
 
  
       }

    }




   }
 
   }

}



function viewInterestTopics(){
    global  $connection;
    global $sess_usr_id;

     if(isset($sess_usr_id)){
      $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id'";
      $select_usr_csr = mysqli_query($connection,$query);
      while($row = mysqli_fetch_assoc($select_usr_csr)){
      $usr_topic_id =  $row['topic_id'];

      if(isset($usr_topic_id)){

        $query = "SELECT * FROM topics WHERE top_id =$usr_topic_id";
        $select_int_topics = mysqli_query($connection,$query);
   
        if($select_int_topics){
           while($row = mysqli_fetch_assoc($select_int_topics)){
            $top_id = $row['top_id'];
            $top_title =  $row['top_title'];
   
            ?>
    <!--topic card-->
   <a id='btn_topics'class="btn btn-primary btn-lg" href="topic.php?top_id=<?php echo $top_id ?>" role="button"><?php echo $top_title ?></a>
   <!--topic card-->
   
          <?php }
   
    
         }

      }

 


     }
   
     }

}

function checkMyCourse(){
    global  $connection;

   $usr_id = $_SESSION['usr_id'];  
    $query = "SELECT * FROM courses WHERE usr_id = '$usr_id'";
    $check_mycourse = mysqli_query($connection,$query);
    if($check_mycourse){
    while($row = mysqli_fetch_assoc($check_mycourse)){
    $csr_id = $row['csr_id'];
     $csr_title = $row['csr_title'];
     $csr_img = $row['csr_img'];
    
    
    if(isset($csr_id)){
        //if isset csr_id
        ?>
    <!--card-->
<div class="card" style="width: 15rem;">
  <img src="uploads/<?php echo $csr_img ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <div style='font-weight:600;' ><?php echo $csr_title ?></div>
   <?php  

   //check if section > 1
   $query = "SELECT * FROM modules_section WHERE csr_id = '$csr_id'";
   $check_section = mysqli_query($connection,$query);
   while($row = mysqli_fetch_assoc($check_section)){
   $sect_csr_id = $row['csr_id'];
   }
  if($csr_id !== $sect_csr_id){
   echo"<div style='padding:5px;' class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Video required</div>"; 
 
 
  }
    //check if objective > 1
    $query = "SELECT * FROM objectives_course WHERE csr_id = '$csr_id'";
    $check_objective = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($check_objective)){
    $object_csr_id = $row['csr_id'];
    }
   if($csr_id !== $object_csr_id){
    echo"<div style='padding:5px;' class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Ojectives required</div>"; 
  
  
   }
 



  ?>
    <a class='view_link'  href="modules.php?csr_id=<?php echo $csr_id ?>"><i class="fa fa-clone"></i> Add section 
     <?php  
     //check if section exist in csr
    if($csr_id !== $sect_csr_id){

echo "<span style='color:red;padding-left:5px;'><i class='fas fa-exclamation'></i> Required</span>"; } ?> 
</a>
 
  
    <a class='view_link'  href="view_goals.php?csr_id=<?php echo $csr_id ?>"><i class="fas fa-check"></i> Add objectives
    <?php  
     //check if objectives exist in csr
    if($csr_id !== $object_csr_id){

echo "<span style='color:red;padding-left:5px;'><i class='fas fa-exclamation'></i> Required</span>"; } ?> 
  </a>
    <a class='view_link'  href="add_instructor.php?csr_id=<?php echo $csr_id ?>"><i class="fas fa-chalkboard-teacher"></i> Add instructor(optional)</a>
    <br>
    <a class='course_edit'   href="edit_course.php?course_edit=<?php echo $csr_id; ?>"><i class="fa fa-edit"></i> Edit course</a>
    <a class='course_delete'  data-id='<?php echo $csr_id ?>' href="#"><i class="fas fa-trash"></i> Delete course</a>
    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
  </div>
</div>

<!--card-->


   <?php 
}   
}


}
}
function checkExistSection(){
  global  $connection;
  global  $csr_id;

  $query = "SELECT * FROM modules_section WHERE csr_id = '$csr_id'";
  $check_section = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($check_section)){
  $sect_csr_id = $row['csr_id'];
  }
 if($csr_id !== $sect_csr_id){
  echo "<span>Required</span>";

 }


}

function viewRelatedTopicCourses(){
  global  $connection;
  global $the_top_id;
  global $top_title;
?>


<!--RELATEDTOPICSCOURSE-->
<div class='lec_cards'><!--lec_cards-->

<h1 class='pop_title'><?php echo $top_title ?> related courses</h1>

<?php
$query = "SELECT * FROM courses WHERE topic_id = $the_top_id";
$select_course_topic = mysqli_query($connection,$query);
if($select_course_topic){
    while($row = mysqli_fetch_assoc($select_course_topic)){
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
  <div class='card_b_title'><?php echo $csr_title ?></div>
  <div class='card_b_inst'>
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
   <button class='inst_link' name='instructor' type='submit'><i class='fas fa-chalkboard-teacher'></i> <?php  echo  $username;  ?></button>

  </form>
     <!--Instructor--->
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
<?php
    }
}

?>

</div>

 <?php 
}

function checkMyVideo(){
    global  $connection;
    global $sect_id;
    global $the_csr_id;
    
  
     $a = 1;
    $query = "SELECT * FROM lectures WHERE sect_id = $sect_id ";
    $check_myvideo = mysqli_query($connection,$query);
    if($check_myvideo){
    while($row = mysqli_fetch_assoc($check_myvideo)){
    $lect_id = $row['lect_id'];
     $lec_title = $row['lec_title'];
     $video_url = $row['video_url'];

    
    
 
    
        ?>
   <div class='vid_container'>
<span><?php echo $a++; ?>.</span>
    <span><i class="fab fa-youtube"></i></span> 
    <span ><?php echo $lec_title ?></span> 
    <a href="edit_video.php?lect_id=<?php echo $lect_id; ?>" class='edit_vid'><span   ><i class="fas fa-edit"></i></span> </a> 
 
    <a onClick="javascript: return confirm('Are you sure you want to delete?')" href="modules.php?delete_lect=<?PHP echo $lect_id ?>&csr_id=<?php echo $the_csr_id  ?>"><span  class='delete_vid'><i class="fas fa-trash"></i></span></a>
</div>


   <?php 
   
}

}

}


function insertModule(){
    global  $connection;
    if(isset($_POST['add_module'])){
      $objective =   $_POST['objective'];
      $csr_id = $_POST['csr_id'];

      $objective = mysqli_real_escape_string($connection,$objective);
 
      $res = $_FILES['pdf']['name'];
      $res_temp= $_FILES['pdf']['tmp_name'];

      move_uploaded_file($res_temp,"uploads/$res");



      $query = "INSERT INTO modules_section(objective,csr_id,res)VALUES('$objective','$csr_id','$res')";
      $insert_module = mysqli_query($connection,$query);
      if($insert_module){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        Module added successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

      }
      


    }

}

function insertVideo(){
    global  $connection;
    if(isset($_POST['add_video'])){
      $lec_title =   $_POST['lec_title'];
      $sect_id = $_POST['sect_id'];
      $video_url = $_POST['video_url'];
      $lec_desc = $_POST['lec_desc'];
      $csr_id = $_POST['csr_id'];

  
      $lec_title = mysqli_real_escape_string($connection,$lec_title);
      $sect_id = mysqli_real_escape_string($connection,$sect_id);
      $lec_desc = mysqli_real_escape_string($connection,$lec_desc);
     $csr_id  = mysqli_real_escape_string($connection,$csr_id );
     $video_url = mysqli_real_escape_string($connection,$video_url);

     $video_url = str_replace("https://youtu.be/","",$video_url);





      $query = "INSERT INTO lectures(lec_title,video_url,lec_desc,sect_id,csr_id)VALUES('$lec_title','$video_url','$lec_desc',$sect_id,'$csr_id')";
      $insert_vid = mysqli_query($connection,$query);
      if($insert_vid){
       $lec_sub = substr($lec_title,0,15).'...';
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
        $lec_sub video added successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

      }
      


    }

}

function displaySaveEnroll(){
  global $connection;
  global $the_csr_id;
  global $instructor_id;
  global $sess_usr_id;
  ?>
  
<div id='btns_enrol_div'>
<?php
$sess_usr_id = $_SESSION['usr_id'];
$query = "SELECT * FROM saved_courses WHERE usr_id ='$sess_usr_id' AND csr_id = '$the_csr_id'";
$select_saved_csr = mysqli_query($connection,$query);
while($row = mysqli_fetch_assoc($select_saved_csr)){
 $saved_csr_id = $row['csr_id'];
}
if(!isset($saved_csr_id)){
 if(isset($sess_usr_id)){
  //if login display saved 
  echo "<a id='save_course'  data-id='$the_csr_id' class='btn btn-primary'  role='button'><i class='fas fa-bookmark'></i> Save course</a>";
 }else{
  echo "<a id='not_login_save_btn'   data-id='$the_csr_id' class='btn btn-primary'  role='button'><i class='fas fa-bookmark'></i> Save course</a>";
 }

}else{
  echo "<a id='unsave_course'  data-id='$the_csr_id' class='btn btn-primary' role='button'><i class='fas fa-check'></i> Saved </a>";
}

?>


<?php
if(isset($_SESSION['usr_id'])){
  if($_SESSION['usr_id'] === $instructor_id){
    echo "<a  class='btn btn-primary disabled'  role='button' ><i class='fas fa-lock'></i> Owner</a>";
  }else{
    //check if user already enroll this course
    $sess_usr_id =$_SESSION['usr_id'];
     $query = "SELECT * FROM usr_course WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
     $check_enrolled = mysqli_query($connection,$query);
     if($check_enrolled){
      while($row = mysqli_fetch_assoc($check_enrolled)){
       $db_csr_id = $row['csr_id'];
      }
      //check if db csr id exist
      if(isset($db_csr_id)){
     if($db_csr_id === $the_csr_id){
      //fetch last watch  lecture
      //optional
       $query = "SELECT * FROM last_watch_lecture WHERE usr_id = '$sess_usr_id' AND csr_id = '$the_csr_id'";
       $fetch_last_watched = mysqli_query($connection,$query);
       if($fetch_last_watched){
        while($row = mysqli_fetch_assoc($fetch_last_watched)){
        $lect_id = $row['lect_id'];

        }
      //  $sess_usr_id = $_SESSION['usr_id'];
        echo "<a  class='btn btn-primary' href='lectures.php?csr_id={$the_csr_id}&continue={$the_csr_id}' role='button'> Continue</a>";
       }
 
      }

      }else{
        echo "<a id='enroll_course' class='btn btn-primary' href='lectures.php?csr_id={$the_csr_id}&firsttime=1' role='button'><i class='fas fa-clipboard'></i> Enroll to start</a>";
      }
      
     }

    
  }
 

}else{
  echo "<a id='not_login_enroll_course' class='btn btn-primary '  role='button' ><i class='fas fa-lock'></i> Enroll to start</a>";
}

?>
<!--demo-->

<div id='demo_enrol'><i class="fas fa-exclamation-triangle"></i> Login to enroll this course</div>

</div>
<?php

}


function displayLecture(){
    
      global $video_url;
      global $lec_title;


     ?>
     <iframe 
        id="player"
        width="550" height="350" 
        src="https://www.youtube.com/embed/<?php  echo $video_url; ?>?rel=0" 
        title="YouTube video player" frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        allowfullscreen>

        </iframe>
      <div class='vid_title'>Topic :<?php echo $lec_title ?></div>
 <?php

}

function updateUsrProfile(){
  global $connection;

  if(isset($_POST['update_profile'])){

    $sess_usr_id = $_SESSION['usr_id'];

   $username = $_POST['username'];
  $url_ln =   $_POST['url_ln'];
   $prof = $_POST['prof'];

   $username = mysqli_real_escape_string($connection,$username);
   $url_ln = mysqli_real_escape_string($connection,$url_ln);
   $prof = mysqli_real_escape_string($connection,$prof);

    $query = "UPDATE users SET username = '$username' ,url_ln = '$url_ln',prof = '$prof' WHERE usr_id = '$sess_usr_id'";
    $update_profile = mysqli_query($connection,$query);
    if($update_profile){
      echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
     Profile Updated
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";

        //redirect
        echo "
        <script type='text/javascript'>
        window.setTimeout(function() {
            window.location = 'profile.php';
        }, 2000);
        </script>
        ";
      

    }else{
      die("Profile update query failed!!");
    }

  }
}





?>