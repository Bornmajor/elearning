<?php include 'connection.php'  ?>
<?php  include 'functions.php' ?>

<div id='save_enroll_cont'>   <!--save_enroll_cont-->
<?php displaySaveEnroll();  ?>

</div> <!--save_enroll_cont-->

<script>
 $(document).ready(function(){

// save course
$('#save_course').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
    var confirmalert = confirm("Are you sure you want to save?");
    if (confirmalert == true) {
        // AJAX Request
        $.ajax({
            url: 'view_course.php?csr_id=<?php echo $the_csr_id; ?>',
            type: 'POST',
            data: { id:id },
         
        });
        $.ajax({
                    url: "includes/check_save.php",
                    type: 'POST',
                    cache: false,
                  success: function(data){
                    $('#save_enroll_cont').html(data); 
                  }
                    
      
                });
              

        
  
    }
});
});




</script>