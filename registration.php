<?php include 'includes/header.php'  ?>
    <title>Registration</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<div class='form_login_container'>
<h1>Account registration</h1>
<form id='reg_form' action='' method='post' onsubmit="return validateForm()">
  <div class="mb-3">
    <?php registerUser(); ?>
    <div id='verify_email' class='alert alert-danger  alert-dismissible fade show' role='alert'>
           
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
    <label for="exampleInputEmail1" class="form-label" id='email_label'>Email address </label>
    <input type="email" class="form-control" id="email" name='elearn_mail' aria-describedby="emailHelp" value=''  required>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" id='name_label'>Full Names</label>
    <input type="text" class="form-control" id="ful_name" name='username' aria-describedby="emailHelp" value=''  required>
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label" id='pwd_label'>Password</label>
    <input type="password" class="form-control" id="pwd" name='pwd'   required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label" id='pwd_repeat_label'>Repeat password</label>
    <input type="password" class="form-control" id="pwd_repeat" name='pwd_repeat'   required>
  </div>

  <button type="submit" class="btn btn-primary" id='register_btn' name='register_user'>Submit</button>
</form>
<div class="mb-3">
  Already have an account <a href="login.php">Login </a>
</div>

</div>
<script>
    function validateForm(){
        var pwd = document.getElementById("pwd").value;
        var pwd_repeat = document.getElementById("pwd_repeat").value;
        var text;
        var demo = document.getElementById("verify_email");


        if(pwd !== pwd_repeat){
            text = "Passwords do not match.";
            demo.innerHTML = text;
            demo.style.display = "block";
            
            demo.scrollIntoView({behavior: "smooth"});
         return false;


        }
      

    }
</script>



<?php include 'includes/footer.php'  ?>