<?php include 'connection.php'  ?>
<?php  include 'functions.php' ?>

<div id='loadMyCourses'>
<?php checkMyCourse();  ?>
</div>


<script>
 $(document).ready(function(){

// Delete 
$('.course_delete').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
    var confirmalert = confirm("Are you sure you want to delete?");
    if (confirmalert == true) {
        // AJAX Request
        $.ajax({
            url: 'instructor.php',
            type: 'POST',
            data: { id:id },
         
        });
        $.ajax({
                    url: "includes/check_courses.php",
                    type: 'POST',
                    cache: false,
                  success: function(data){
                    $('#loadMyCourses').html(data); 
                  }
                    
      
                });
              

        
  
    }
});
});

</script>