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
  <title>Welcome</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
  <script src="js/jquery-1.10.2.js"></script>

  <script>
    // Delete database value code
    $(document).on('click','.delete',function(){
      var element = $(this);
      var del_id = element.attr('data-id');
      var del_table = element.attr('data-table');
      var info = 'id=' + del_id +'&table='+ del_table;
      if(confirm("Are you sure you want to delete this?")) {
        $.ajax({
          type: "POST",
          url: "ajaxdelete.php",
          data: info,
          success: function(){
          }
        });
        $(this).parents("li").animate({ backgroundColor: "#003" }, "slow")
        .animate({ opacity: "hide" }, "slow");
      }
      return false;
    });

    function showEdit(editableObj) {
      $(editableObj).css("background","#3d3d3d");
    }

    function saveToDatabase(table,editableObj,column,id) {
      $(editableObj).css("background","#3d3d3d url(loaderIcon.gif) no-repeat right");
      $.ajax({
        url: "ajaxedit.php",
        type: "POST",
        data:'table='+table+'&column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(data){
          $(editableObj).css("background","#000");
        }
      });
    }

    //on the click of the submit button - INSERT ITEM
  	$(document).on('click','#btn_submit',function(){
  		var form = $('form')[0]; // You need to use standard javascript object here
  		var formData = new FormData(form);
      console.log(formData);
  		$.ajax({
  	    url : "ajaxinsert.php",
  	    type: "POST",
  	    data : formData,
  			contentType: false,
  			processData: false,
  	    success: function(data)
  	    {
  	      //if success then1 just output the text to the status div then clear the form inputs to prepare for new data
  	      $("#status_text").html("<p>OK</p>");
  	    }
  		});
  	});

    $(document).on('click','#btn_submit1',function(){
  		var form = $('form')[1]; // You need to use standard javascript object here
  		var formData = new FormData(form);
      console.log(formData);
  		$.ajax({
  	    url : "ajaxinsert.php",
  	    type: "POST",
  	    data : formData,
  			contentType: false,
  			processData: false,
  	    success: function(data)
  	    {
  	      //if success then1 just output the text to the status div then clear the form inputs to prepare for new data
  	      $("#status_text").html("<p>OK</p>");
  	    }
  		});
  	});
  </script>

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
            <li><span contenteditable="true" onBlur="saveToDatabase('income',this,'description','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row['description'] ?></span> | <?php echo $row['amount'] ?> | <a data-table="income" data-id="<?php echo $row['id'] ?>" class="delete" href="#">Delete</a></li>
          <?php } ?>
          </ul>
          <p>Total: <?php echo $totalIncome ?></p>
        <?php } ?>
      </div>
      	      <form class="form" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
      						<div class="row">
      							<div class="col-sm-6">
      			          <label for="note">Description:</label>
      			          <input type="text" id="description" class="form-control" name="description">
                      <input type="hidden" name="table" value="income">
      			        </div>
      							<div class="col-sm-6">
      								<label for="other">Amount:</label>
      								<input type="text" id="amount" class="form-control" name="amount">
      							</div>
      						</div>
      					</div>
                <button type="submit" id="btn_submit" class="btn btn-default">Submit income</button>
              </form>
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
            <li><span contenteditable="true" onBlur="saveToDatabase('outcome',this,'description','<?php echo $row2["id"] ?>')" onClick="showEdit(this);"><?php echo $row2['description'] ?> | <?php echo $row2['amount'] ?> | <a data-table="outcome" data-id="<?php echo $row2['id'] ?>" class="delete" href="#">Delete</a></li>
          <?php } ?>
          </ul>
          <p>Total: <?php echo $totalOutcome ?></p>
        <?php } ?>
      </div>
      <form class="form" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col-sm-6">
              <label for="note">Description:</label>
              <input type="text" id="description" class="form-control" name="description">
              <input type="hidden" name="table" value="outcome">
            </div>
            <div class="col-sm-6">
              <label for="other">Amount:</label>
              <input type="text" id="amount" class="form-control" name="amount">
            </div>
          </div>
        </div>
        <button type="submit" id="btn_submit1" class="btn btn-default">Submit outcome</button>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12" style="padding: 0 15px;">
        <h1>TOT:</h1>
        <h3><?php echo $totalIncome - $totalOutcome ?></h3>
    </div>
  </div>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
