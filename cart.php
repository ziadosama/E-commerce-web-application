<?php
	session_start();
	include_once 'dbconnect.php';
	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	$msg="";
	$userID=$_SESSION['userSession'];
	$cart=$DBcon->query("SELECT * FROM cart WHERE buyerID='$userID';");
	$userRow=$cart->fetch_array();
	$cartP=$DBcon->query("SELECT P.productName, C.quantity FROM `cart-product` C, Product P WHERE cartID='$userRow[cartID]' AND C.productID= P.productID;");
	
	if (isset($_POST['btn-make'])) {
		
	}
	
	$DBcon->close();

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
    <h1>Cart
	  <a href="buye.php" class="btn btn-default" style="float:right;">back</a>
	  </h1>
  	<hr>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
	  
        <h3>Cart Info</h3>
        
        <form class="form-horizontal" role="form" method="post">
         
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		  <?php
			echo "<table style='width:100%'>"; // start a table tag in the HTML
			$count=1;
			while($row = mysqli_fetch_array($cartP)){   //Creates a loop to loop through results
			echo "<tr><th>Number</th><th>Product Name</th><th>Quantity</th></tr><tr><td>" . $count++ . "</td><td>" . $row['productName'] . "</td><td>" . $row['quantity'] . "</td></tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML
		  ?>
		  
		  <div class="form-group">
			  <button style="float: center;" type="submit" class="btn btn-default" name="btn-make">
			  <span class="glyphicon glyphicon-save-changes"></span> Make Order
			  </button>
		  </div>
		  
		  
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>