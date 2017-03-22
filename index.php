<?php
  session_start();
  include_once 'dbconnect.php';

  $sql = "SELECT * FROM income";
	$result = $con->query($sql);

  $sql2 = "SELECT * FROM outcome";
	$result2 = $con->query($sql2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Welcome - <?php echo $userRow['email']; ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12" style="padding: 0 15px; background-color:#356b67; color:#FFF;">
        <?php if ($result->num_rows > 0) {
          $totalIncome = 0;
        ?>
          <h1>IN</h1>
          <ul>
          <?php while($row = $result->fetch_array()) {
            $totalIncome = $totalIncome + $row['amount'];
          ?>
            <li><?php echo $row['description'] ?> | <?php echo $row['amount'] ?></li>
          <?php } ?>
          </ul>
          <p>Total: <?php echo $totalIncome ?></p>
        <?php } ?>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12" style="padding: 0 15px; background-color:#893939; color:#FFF;">
        <?php if ($result2->num_rows > 0) {
          $totalOutcome = 0;
        ?>
          <h1>OUT</h1>
          <ul>
          <?php while($row2 = $result2->fetch_array()) {
            $totalOutcome = $totalOutcome + $row2['amount'];
          ?>
            <li><?php echo $row2['description'] ?> | <?php echo $row2['amount'] ?></li>
          <?php } ?>
          </ul>
          <p>Total: <?php echo $totalOutcome ?></p>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12" style="padding: 0 15px;">
        <h1>TOT:</h1>
        <h3><?php echo $totalIncome - $totalOutcome ?></h3>
    </div>
  </div>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
