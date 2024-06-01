<?php include 'includes/header.php'  ?>
    <title>Contact Us |E-learning </title>
   
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<div class='form_login_container'>

<div><a href="#" onclick="history.back()" class='btn btn-secondary'><i class='fas fa-angle-left'></i> BACK</a></div>
<h2>Contact Form</h2>

<div class="alert alert-success alert-dismissible fade show contact_msg" role="alert" style="display:none;">
Thank you for your message! It has been received successfully. Our team will get back to you within 24 hours.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<form id='reg_form' action='' method='post' >
  <div class="mb-3">
    <?php  ?>

    <label for="exampleInputEmail1" class="form-label" id='email_label'>Email address </label>
    <input type="email" class="form-control" id="email" name='email' aria-describedby="emailHelp" value='' placeholder='Email address'  required>
  </div>
  <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Message </label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" required></textarea>
</div>

  <button type="submit" class="btn btn-primary" id='register_btn' name='register_user'>Submit</button>
  <a id='back_form_btn' href="index.php" class='btn btn-secondary'>Back Home</a>
</form>
You can also send mail directly via elearning@yahoo.com
</div>

<?php include 'includes/footer.php'  ?>

<script>
  $('#reg_form').submit(function(event){
    event.preventDefault();
    $(this)[0].reset();

    $('.contact_msg').slideDown(1000);

  })
</script>