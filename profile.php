<?php include 'includes/header.php'  ?>
    <title>Profile</title>
   
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php checkUsrSession();  ?>
<?php
    $sess_usr_id = $_SESSION['usr_id'];
  

 $query = "SELECT * FROM users WHERE usr_id = '$sess_usr_id'";
 $select_user = mysqli_query($connection,$query);
 if($select_user){
    while($row = mysqli_fetch_assoc($select_user)){
    $username = $row['username'];
      $url_ln =  $row['url_ln'];
      $prof =  $row['prof'];
    }
 }
?>

<div class='form_login_container'>
<div><a href="#" onclick="history.back()" class='btn btn-secondary'><i class='fas fa-angle-left'></i> BACK</a></div>
<br>
<h1>Profile information</h1>
<form id='reg_form' action='' method='post' >
  <div class="mb-3">
    <?php updateUsrProfile(); ?>
    <!-- <div id='verify_email' class='alert alert-danger  alert-dismissible fade show' role='alert'>
           
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div> -->

  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" id='name_label'>Full Names</label>
    <input type="text" class="form-control" id="ful_name" name='username' aria-describedby="emailHelp" value='<?php echo $username ?>'  required>
  </div>
   <label for="exampleInputEmail1" class="form-label" id='name_label'>Linkedin url </label>
  <div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"> <i style='font-size:20px;' class="fab fa-linkedin"></i></span>
   

    <input type="text" class="form-control" id="ful_name" name='url_ln' aria-describedby="emailHelp" value='<?php  echo $url_ln ?>'  >
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" id='name_label'>Profession <i class="fas fa-user-tie"></i> or Area of interest </label>
    <input type="text" class="form-control" id="ful_name" name='prof' aria-describedby="emailHelp" value='<?php echo $prof ?>'  >
  </div>
  <!-- <div class="mb-3">
  <label for="formFile" class="form-label">Profile Image</label>
  <input class="form-control" type="file" name='image' id="formFile" accept="image/x-png,image/gif,image/jpeg">
</div> -->

  <button type="submit" class="btn btn-primary" id='register_btn' name='update_profile'>Save profile</button>
  
</form>
</div>

<?php include 'includes/footer.php'  ?>