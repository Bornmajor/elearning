<?php include 'includes/header.php'  ?>
    <title>Modules & Video</title>
 
</head>
<body>
<?php
//call functions
checkUsrSession();


if(isset($_GET['csr_id'])){
  $csr_id = $_GET['csr_id'];
  $the_csr_id  = mysqli_real_escape_string($connection,$csr_id);


}else{
  header("Location: instructor.php");
}
  ?>
<?php include 'includes/navbar.php'  ?>
<?php insertModule(); ?>

<!-- Create section Modal -->
<div class="modal fade" id="createSection" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
        <?php
        $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id'";
        $select_title = mysqli_query($connection,$query);
        if($select_title){
          while($row = mysqli_fetch_assoc($select_title)){
           $csr_title = $row['csr_title'];
          }

        echo  $csr_title;
        }

        ?>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

<form action="" method="post" enctype="multipart/form-data">

<label for="exampleInputEmail1" class="form-label"> Section title</label>  
<input type="text" class="form-control" id="exampleFormControlInput1" name='objective' placeholder="Objective..."  required>

<input type="hidden" class="form-control" id="exampleFormControlInput1" name='csr_id' value='<?php echo $_GET['csr_id'] ?>'   required>
<br>
<div class="mb-3">
  <label for="formFile" class="form-label">Resource (Optional)</label>
  <input class="form-control" type="file" name='pdf' id="formFile" accept="application/pdf">
</div>





      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name='add_module' class="btn btn-primary">Submit form</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Create section Modal -->





<div class='sect_container'><!--sect_container-->
<div>
<?php
        $query = "SELECT * FROM courses WHERE csr_id = '$the_csr_id'";
        $select_title = mysqli_query($connection,$query);
        if($select_title){
          while($row = mysqli_fetch_assoc($select_title)){
           $csr_title = $row['csr_title'];
          }
          ?>

      <img width='50px' src='images/icons8-licence-50.png' alt=""><span style='font-weight:700;'>Course Name : </span><?php echo $csr_title; ?>
       <?php }

        ?>
     </div>  
     <br>

<div><a  href="instructor.php" class='btn btn-secondary' ><i class='fas fa-angle-left'></i> BACK TO MY COURSES</a></div>     
<br>
<div><a class='btn_add_sect' href="#" data-bs-toggle="modal" data-bs-target="#createSection" > <i class="fa fa-plus"></i> ADD SECTION</a></div>

<br>
<?php
 $i=1;
$query = "SELECT * FROM modules_section WHERE csr_id = '$the_csr_id'";
$select_modules = mysqli_query($connection,$query);
if($select_modules){
  while($row = mysqli_fetch_assoc($select_modules)){
  $sect_id =  $row['sect_id'];
  $objective = $row['objective'];
  

?>

<button class="collapsible"><span><?php  echo $i++; ?></span>. <span style='margin-right:10px;'><?php echo $objective ?></span></button>
<div class="content">
 <br>   

<a class='btn_add_vid' href="add_video.php?sect_id=<?php echo $sect_id ?>&csr_id=<?php echo $the_csr_id ?>" > <i class="fa fa-plus"></i> ADD VIDEO</a>
<a class='btn_edit_vid' href="edit_module.php?sect_id=<?php echo $sect_id ?>&csr_id=<?php echo $the_csr_id ?>" > <i class="fas fa-edit"></i> EDIT SECTION</a>
<a class='btn_edit_vid' href="modules.php?delete_sect=<?php echo $sect_id ?>&csr_id=<?php echo $the_csr_id ?>" > <i class="fas fa-trash"></i> DELETE SECTION</a>
<br>
<br>
<div id='loadMyVideo'>
<?php checkMyVideo(); ?>
</div>


<!-- <div class='vid_container'>
<span>2.</span>
    <span><i class="fab fa-youtube"></i></span> 
    <span class='vid_title'>Introduction to Go language </span> 
    <span id='edit_vid'><i class="fas fa-edit"></i></span>  
    <span id='delete_vid'><i class="fas fa-trash"></i></span>
</div> -->


</div>


<?php   }
} ?>





<!-- <button class="collapsible">Installation of text editor XAMP</button>
<div class="content">
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</div>
<button class="collapsible">Syntax of Go programming language</button>
<div class="content">
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</div> -->




</div><!--sect_container-->
<script>
//   $(document).ready(function(){

// // Delete 
// $('.delete_vid').click(function(){
//     var el = this;

//     // Delete id
//     var id = $(this).data('id');
    
//     var confirmalert = confirm("Are you sure you want to delete?");
//     if (confirmalert == true) {
//         // AJAX Request
//         $.ajax({
//             url: 'modules.php',
//             type: 'POST',
//             data: { id:id },
         
//         });
//         $.ajax({
//                     url: "includes/check_video.php",
//                     type: 'POST',
//                     cache: false,
//                   success: function(data){
//                     $('#loadMyVideo').html(data); 
//                   }
                    
      
//                 });
              

        
  
//     }
// });
// });

</script>

<?php
if(isset($_GET['delete_lect'])){
 
    $the_lect_id = $_GET['delete_lect'];
    $the_lect_id = mysqli_real_escape_string($connection,$the_lect_id);

    $query = "DELETE FROM lectures WHERE lect_id = $the_lect_id";
    $delete_video = mysqli_query($connection,$query);
    if($delete_video){
      header("Location: modules.php?csr_id=".$_GET['csr_id']."");
    }else{
      die("Delete video query failed");
    }
    
        
  
}

if(isset($_GET['delete_sect'])){
 
  $the_sect_id = $_GET['delete_sect'];
  $the_sect_id = mysqli_real_escape_string($connection,$the_sect_id);

  $query = "DELETE FROM modules_section WHERE  sect_id = $the_sect_id";
  $delete_section = mysqli_query($connection,$query);
  if($delete_section){
     header("Location: modules.php?csr_id=".$_GET['csr_id']."");
  }else{
    die("Delete section query failed");
  }
  
     

}


?>



<?php include 'includes/footer.php'  ?>