<?php
  session_start();
  include_once 'dbconnect.php';

  $sql = "SELECT * FROM income";
	$result = $con->query($sql);

  $sql2 = "SELECT * FROM outcome";
	$result2 = $con->query($sql2);

  $totIncome = 0;

  $sql3="SELECT sum(amount) as total FROM income";
  $result3 = $con->query($sql3);
  while ($row3 = mysqli_fetch_assoc($result3))
  {
    $totIncome = $row3['total'];
  }

  $sql4="SELECT sum(amount) as total FROM outcome";
  $result4 = $con->query($sql4);
  while ($row4 = mysqli_fetch_assoc($result4))
  {
     $totOutcome = $row4['total'];
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>EXPENSES TRACKER</title>
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
            $(this).parents("li").animate({ backgroundColor: "#003" }, "slow")
            .animate({ opacity: "hide" }, "slow");
            window.location.reload();
          }
        });
      }
      return false;
    });

    function showEdit(editableObj) {
      $(editableObj).css("background-color","#3d3d3d");
    }

    function saveToDatabase(table,editableObj,column,id) {
      $(editableObj).css("background-color","#3d3d3d");
      $.ajax({
        url: "ajaxedit.php",
        type: "POST",
        data:'table='+table+'&column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(data){
          $(editableObj).css("background","#000");
          window.location.reload();
        }
      });
    }

    //on the click of the submit button - INSERT ITEM
  	$(document).on('click','#btn_submit',function(){
  		var form = $('form')[0]; // You need to use standard javascript object here
  		var formData = new FormData(form);
  		$.ajax({
  	    url : "ajaxinsert.php",
  	    type: "POST",
  	    data : formData,
  			contentType: false,
  			processData: false,
  	    success: function(data)
  	    {
  	    }
  		});
  	});

    $(document).on('click','#btn_submit1',function(){
  		var form = $('form')[1]; // You need to use standard javascript object here
  		var formData = new FormData(form);
  		$.ajax({
  	    url : "ajaxinsert.php",
  	    type: "POST",
  	    data : formData,
  			contentType: false,
  			processData: false,
  	    success: function(data)
  	    {
  	    }
  		});
  	});

    $(document).on('click','#btn_clearIN',function(){
      if(confirm("Are you sure you want to delete everything?")) {
    		$.ajax({
    	    url : "ajaxdelete.php",
    	    type: "POST",
    	    data : 'clear=in',
    	    success: function(data)
    	    {
            window.location.reload();
    	    }
    		});
      }
      return false;
  	});

    $(document).on('click','#btn_clearOUT',function(){
      if(confirm("Are you sure you want to delete everything?")) {
    		$.ajax({
    	    url : "ajaxdelete.php",
    	    type: "POST",
    	    data : 'clear=out',
    	    success: function(data)
    	    {
            window.location.reload();
    	    }
    		});
      }
      return false;
  	});
  </script>

</head>

<body>
  <style>
    a{color: #ababab;}
  </style>
  <div class="container-fluid">
    <div class="row" style="background-color:#427242; color:#FFF;">
      <div class="col-sm-12">
          <h1>IN</h1>
          <?php if ($result->num_rows > 0) {
            ?>
          <ul style="list-style:none; padding:0;">
          <?php while($row = $result->fetch_array()) {
          ?>
            <li style="background-color:#2c4f2c; margin: 8px 0; padding:8px;">
              <strong><span class="incomeAmount" contenteditable="true" onBlur="saveToDatabase('income',this,'amount','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row['amount'] ?></span>
               €</strong> |
               <span contenteditable="true" onBlur="saveToDatabase('income',this,'description','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row['description'] ?></span>
               | <?php echo date("d-m-Y", strtotime($row["date"])) ?>
               | <a data-table="income" data-id="<?php echo $row['id'] ?>" class="delete" href="#">Delete</a>
            </li>
          <?php } ?>
          </ul>
          <div id="totIncome" class="text-center">
            <h2>Total: <?php echo $totIncome ?> €</h2>
          </div>
        <?php } ?>
      </div>
      <div class="col-sm-12">
      	      <form class="form" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
      						<div class="row">
                    <div class="text-center">
                      <button type="button" style="margin: 10px 20px;" class="btn btn-success" data-toggle="collapse" data-target="#demo">NEW</button>
                    </div>
                    <div id="demo" class="collapse" style="padding: 0 10px;">
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
                      <div class="row">
          							<div class="col-sm-12 text-center" style="margin-top:20px;">
                          <button type="submit" id="btn_submit" class="btn btn-default">Submit income</button>
                        </div>
                      </div>
                    </div>
      						</div>
      					</div>
              </form>
      </div>
      <div class="col-sm-12 text-center">
        <button type="button" style="margin: 10px 20px;" id="btn_clearIN" class="btn btn-warning">CLEAR ALL</button>
      </div>
    </div>

    <div class="row" style="background-color:#842626; color:#FFF;">
      <div class="col-sm-12">
          <h1>OUT</h1>
          <?php if ($result2->num_rows > 0) {
            ?>
          <ul style="list-style:none; padding:0;">
          <?php while($row2 = $result2->fetch_array()) {
          ?>
            <li style="background-color:#651c1c; margin: 8px 0; padding:8px;">
              <strong><span contenteditable="true" onBlur="saveToDatabase('outcome',this,'amount','<?php echo $row2["id"] ?>')" onClick="showEdit(this);"><?php echo $row2['amount'] ?></span>
               €</strong> |
               <span contenteditable="true" onBlur="saveToDatabase('outcome',this,'description','<?php echo $row2["id"] ?>')" onClick="showEdit(this);"><?php echo $row2['description'] ?></span>
                | <?php echo date("d-m-Y", strtotime($row2["date"])) ?>
                | <a data-table="outcome" data-id="<?php echo $row2['id'] ?>" class="delete" href="#">Delete</a>
            </li>
          <?php } ?>
          </ul>
          <div id="totOutcome" class="text-center">
            <h2>Total: <?php echo $totOutcome ?> €</h2>
          </div>
        <?php } ?>
      </div>
      <div class="col-sm-12">
      	      <form class="form" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
      						<div class="row">
                    <div class="text-center">
                      <button type="button" style="margin: 10px 20px;" class="btn btn-danger" data-toggle="collapse" data-target="#demo1">NEW</button>
                    </div>
                    <div id="demo1" class="collapse" style="padding: 0 10px;">
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
                      <div class="row">
          							<div class="col-sm-12 text-center" style="margin-top:20px;">
                          <button type="submit" id="btn_submit1" class="btn btn-default">Submit outcome</button>
                        </div>
                      </div>
                    </div>
      						</div>
      					</div>
              </form>
      </div>
      <div class="col-sm-12 text-center">
        <button type="button" style="margin: 10px 20px;" id="btn_clearOUT" class="btn btn-warning">CLEAR ALL</button>
      </div>
    </div>

    <div class="row"  style="background-color: #426472; padding:20px; color:#FFF;">
      <div class="col-sm-12 text-center">
          <h1>SALDO:</h1>
          <div style="background-color:#224857; padding:4px;">
            <h2><?php echo $totIncome - $totOutcome ?> €</h2>
          </div>
      </div>
    </div>
  </div>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
