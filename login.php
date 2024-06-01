<?php include 'includes/header.php'  ?>
    <title>LogIn</title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<div class='form_login_container'>
<h1>Account login</h1>
<?php loginUser(); ?>
<form action='' method='post'>
  <div class="mb-3">
    <div id='verify_email'></div>
    <label for="exampleInputEmail1" class="form-label" id='email_label'>Email address </label>
    <input type="email" class="form-control" id="email" name='elearn_mail' aria-describedby="emailHelp" value='' >
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label" id='pwd_label'>Password</label>
    <input type="password" class="form-control" id="pwd" name='pwd'   required>
  </div>

  <button type="submit" class="btn btn-primary" id='login_btn' name='login_user'>Login</button>
</form>
<div class="mb-3">
  Need an acccount? <a href="registration.php">Click here</a>
</div>

</div>




<?php include 'includes/footer.php'  ?>