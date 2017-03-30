<?php

  $servername = $dbusername = $dbpassword = $dbname = $useremail = $userpassword = $username = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = htmlspecialchars($_POST['host']);
    $dbusername = htmlspecialchars($_POST['dbusername']);
    $dbpassword = htmlspecialchars($_POST['dbpassword']);
    $dbname = htmlspecialchars($_POST['dbname']);
  }

  $data = "<?php
    \$servername = \"$servername\";
    \$dbusername = \"$dbusername\";
    \$dbpassword = \"$dbpassword\";
    \$dbname = \"$dbname\";
  ?>";

  file_put_contents("config.php", $data);

  include_once 'config.php';

  // Create connection
  $con = new mysqli($servername, $dbusername, $dbpassword);
  // Check connection
  if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }

  // Create database
  $sql = "CREATE DATABASE IF NOT EXISTS `".$dbname."`";
  if ($con->query($sql) === TRUE) {
    echo "Database created successfully!";
  } else {
    echo "Error creating database: " . $con->error;
  }

  echo "<br>";

  // Create connection
  $con2 = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($con2->connect_error) {
    die("Connection failed: " . $con2->connect_error);
  }

  $sql1 = "CREATE TABLE IF NOT EXISTS income (
    id int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    description varchar(255) NOT NULL,
    amount varchar(64) NOT NULL,
    date date NOT NULL
  );";

  $sql1 .= "CREATE TABLE IF NOT EXISTS outcome (
    id int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    description varchar(255) NOT NULL,
    amount varchar(64) NOT NULL,
    date date NOT NULL
  );";

  if ($con2->multi_query($sql1) === TRUE) {
    echo "<p>Tables created successfully!</p>
      <h2>Remember to delete install.php and create.php from your server!</h2>
      <p>Go to <a href='index.php'>login</a>
      and start adding items to your expenses tracker!</p>";
  } else {
    echo "Error creating tables: " . $con2->error;
  }

  $con->close();
  $con2->close();
?>
