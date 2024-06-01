<?php include 'connection.php'  ?>
<?php  include 'functions.php' ?>

<div id='loadMyVideo'>
    
<?php checkMyVideo($sect_id); ?>
</div>


<script>
 $(document).ready(function(){

// Delete 
$('.delete_vid').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
    var confirmalert = confirm("Are you sure you want to delete?");
    if (confirmalert == true) {
        // AJAX Request
        $.ajax({
            url: 'modules.php',
            type: 'POST',
            data: { id:id },
         
        });
        $.ajax({
                    url: "includes/check_video.php",
                    type: 'POST',
                    cache: false,
                  success: function(data){
                    $('#loadMyVideo').html(data); 
                  }
                    
      
                });
              

        
  
    }
});
});

</script>