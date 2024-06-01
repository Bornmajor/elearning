<div class='search_container'>
 
<!-- The form -->
<form class="form_search"  method='GET' action="courses.php" >
  <input class='search_txt'   type="text" placeholder="Search for course.." name="q"  id="myInput" onkeyup="mySearch()" autocomplete='off'>
  <ul id="myUL">
    <?php
    $query = "SELECT * FROM courses";
    $select_courses = mysqli_query($connection,$query);
    if($select_courses){
        while($row = mysqli_fetch_assoc($select_courses)){
         $csr_title = $row['csr_title'];

         ?>
  <li><a href="courses.php?q=<?php echo $csr_title ?>"><?php echo $csr_title  ?></a></li>
         <?php
        }
    }

    ?>


</ul>


</form>
<div id='lec_cards'></div>

</div>
<script>
function mySearch() {
    ul = document.getElementById("myUL");
    ul.style.display = 'block';

    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if(input.value == "" || input.value == " " ){
            ul.style.display = 'none';
        }
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
</script>