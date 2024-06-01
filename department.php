<?php include 'includes/header.php'  ?>
    <title>
        <?php
        if(isset($_GET['ind_id'])){
            $the_ind_id = $_GET['ind_id'];
            $query = "SELECT * FROM industries WHERE ind_id = $the_ind_id";
            $select_title = mysqli_query($connection,$query);
            if($select_title){
                while($row = mysqli_fetch_assoc($select_title)){
                    $ind_title = $row['ind_title'];
                }
                echo $ind_title;

      
        ?>
    </title>
 
</head>
<body>
<?php include 'includes/navbar.php'  ?>
<div class='lec_cards'><!--lec_cards-->

<h2 class='pop_title'>Course related to <?php 
  $the_ind_id = $_GET['ind_id'];
  $query = "SELECT * FROM industries WHERE ind_id = $the_ind_id";
  $select_title = mysqli_query($connection,$query);
  if($select_title){
      while($row = mysqli_fetch_assoc($select_title)){
          $ind_title = $row['ind_title'];
      }
      echo $ind_title;
    }


?></h2>

<?php viewCourseTopics();  ?>



</div><!--lec_cards-->

<?php       }else{
    die("Fetch ind id query failed");
}
        }
 ?>
<?php include 'includes/footer.php'  ?>