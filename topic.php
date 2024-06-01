<?php include 'includes/header.php'  ?>
    <title>
        <?php
        if(isset($_GET['top_id'])){
            $the_top_id = $_GET['top_id'];

            $the_top_id = mysqli_real_escape_string($connection,$the_top_id);


            $query = "SELECT * FROM topics WHERE top_id = $the_top_id";
            $select_title = mysqli_query($connection,$query);
            if($select_title){
                while($row = mysqli_fetch_assoc($select_title)){
            
                 $top_title =  $row['top_title'];
                }
                echo $top_title;
            }
        }
        ?>

    </title>
</head>
<body>
<?php include 'includes/navbar.php'  ?>

<?php viewRelatedTopicCourses(); ?>

<?php include 'includes/footer.php'  ?>
