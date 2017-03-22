<?php
  include_once 'config.php';
  //connect to mysql database
  $con = mysqli_connect("$servername", "$dbusername", "$dbpassword", "$dbname") or die("Error " . mysqli_error($con));
?>
