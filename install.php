<!DOCTYPE html>
<html>
<head>
	<title>BKMNGR</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>
	<div class="container-fluid">
	  <div class="row">
	    <div class="col-sm-12">
	      <h1>CONFIGURATION</h1>
	<!--      	<form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   -->
	      <form class="form"  method="post" action="create.php">
	        <h3>DATABASE CONNECTION</h3>
					<div class="form-group">
						<div class="row">
						  <div class="col-sm-6">
			          <label for="host">Host:</label>
			          <input type="text" class="form-control" name="host">
			        </div>
							<div class="col-sm-6">
			          <label for="dbname">DB name:</label>
			          <input type="text" class="form-control" name="dbname">
			        </div>
						</div>
					</div>
          <div class="form-group">
						<div class="row">
							<div class="col-sm-6">
			          <label for="dbusername">DB username:</label>
			          <input type="text" class="form-control" name="dbusername">
			        </div>
						  <div class="col-sm-6">
			          <label for="dbpassword">DB password:</label>
			          <input type="text" class="form-control" name="dbpassword">
			        </div>
						</div>
					</div>
	        <button type="submit" class="btn btn-default">Submit</button>
	 	    </form>
				<hr>
	    </div>
	  </div>
	</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
