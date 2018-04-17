<?php
	session_start();
	include_once 'dbconnect.php';
	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	$msg="";
	$userID=$_SESSION['userSession'];
	
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<div class="container">
   <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Buyer Page</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="../change.php?bs=b">Edit Info</a></li>
            <li><a href="../search.php">Search</a></li>
            <li><a href="../cart.php">Cart</a></li>
            <li class="active"><a href="../orderHistory.php">Order History</a></li>
          </ul>
		  <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;</a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<br><br></br></br>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
	  
        <h3>Order History</h3>
        
        <form class="form-horizontal" role="form" method="post">
         
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		  <?php
			echo "<table style='width:100%'>"; // start a table tag in the HTML
			$orders=$DBcon->query("SELECT * FROM orrder WHERE buyerID='$userID';");
			while($row = mysqli_fetch_array($orders)){   //Creates a loop to loop through results
				$orderP=$DBcon->query("SELECT P.productName, O.quantity FROM `order-product` O,  product P WHERE O.productID=P.productID AND O.orderID='$row[orderID]';");
				while($row2 = mysqli_fetch_array($orderP)){   //Creates a loop to loop through results{
					echo "<tr><th>Order ID</th><th>Date</th><th>Product Name</th><th>Quantity</th></tr><tr><td>" . $row['orderID'] . "</td><td>" . $row['orderDate'] . "</td><td>" . $row2['productName'] . "</td><td>" . $row2['quantity'] . "</td></tr>";  //$row['index'] the index here is a field name
				}
			}

			echo "</table>"; //Close the table in HTML
			$DBcon->close();
		  ?>
		  <hr>
		  
		 
		  
		  
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>