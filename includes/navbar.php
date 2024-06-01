<nav class="navbar sticky-top navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand " href="index.php"><img width='80px' src="images/elearn.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul  class="navbar-nav me-5  mb-2 mb-lg-0">
    <li class="nav-item ">
          <a class="nav-link" style='cursor:pointer;' href='mylearning.php'>My learning</a>
        </li>
        <?php if(isLoggedIn()){
          ?>
        <li class="nav-item">
          <a class="nav-link" href="wishlist.php">Wishlist</a>
        </li>
        <?php
        }?>

        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Road maps</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li>
        <?php if(isLoggedIn()){
          ?>
             <li class="nav-item">
          <a class="nav-link" href="instructor.php">Instructors</a>
        </li>

          <?php
        }?>
     

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Categories
          </a>
          <ul class="dropdown-menu">
            <?php
            $query = "SELECT * FROM industries";
            $select_industries = mysqli_query($connection,$query);
          if($select_industries){
            while($row = mysqli_fetch_assoc($select_industries)){
              $ind_id = $row['ind_id'];
              $ind_title = $row['ind_title'];
          
              ?>
            <li><a class="dropdown-item" href="department.php?ind_id=<?php echo $ind_id ?>"><?php echo $ind_title ?></a></li>
              <?php
            }
          }

            ?>
           
            <!-- <li><a class="dropdown-item" href="#">Another action</a></li> -->
         
          </ul>
        </li>
    <?php if(isLoggedIn()){
      ?>
       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php  echo $_SESSION['elearn_mail'] ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="signout.php">Logout</a></li>
         
          </ul>
        </li>
    


   <?php } else{
      ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Account
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="login.php">Login</a></li>
            <li><a class="dropdown-item" href="registration.php">Registration</a></li>
         
          </ul>
        </li>

   <?php }
    
    
    ?>
      


</ul>
</div>


    </div>

  </div>
</nav>
<script>

 function  myLearning(){
  document.getElementById("lec_cards").scrollIntoView();
 }
</script>