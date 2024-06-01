<?php include 'includes/header.php'  ?>
    <title>Wishlist</title>
   
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<?php 
//call functions
checkUsrSession();
?>

<!--WISHLIST  COURSES-->
<div class='lec_cards'><!--lec_cards-->
  <h2 class='pop_title'>Wishlisted courses</h2>
<?php viewWishlistCourses(); ?>
</div><!--lec_cards-->

<?php include 'includes/footer.php'  ?>