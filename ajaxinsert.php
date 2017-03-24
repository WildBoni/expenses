<?php
  session_start();
  include_once 'dbconnect.php';

  $description = $amount = $table = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = htmlspecialchars($_POST['description']);
    $amount = htmlspecialchars($_POST['amount']);
    $table = htmlspecialchars($_POST['table']);
  }

  $sql7 = "INSERT INTO $table (description, amount)
  VALUES ('$description', '$amount')";

  if ($con->query($sql7) === TRUE) {
    echo "<p>New item created successfully</p>";
  } else {
    echo "Error: " . $sql7 . "<br>" . $con->error;
  }

  $con->close();

?>
