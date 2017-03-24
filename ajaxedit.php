<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
}

if($_POST['table']=="income") {
  extract($_POST);
  $id=mysqli_real_escape_string($con,$id);
  $sql = $con->query("UPDATE income set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id='$id'");
}

if($_POST['table']=="outcome") {
  extract($_POST);
  $id=mysqli_real_escape_string($con,$id);
  $sql = $con->query("UPDATE outcome set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id='$id'");
}

?>
