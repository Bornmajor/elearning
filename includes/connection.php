<?php
 $connection = mysqli_connect("localhost","root","","e_learning");

 if($connection === false){
    die("Database connection failed!!".mysqli_connect_error());
 }

?>
<?php 
 // error_reporting(0); 
 ?>
<?php session_start();?>
<?php  ob_start(); ?>