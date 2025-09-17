<?php 
   $con = mysqli_connect("localhost", "root", "", "innerbalance");

   if (!$con) {
       die("Connection failed: " . mysqli_connect_error());
   }
   
?>