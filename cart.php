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
	$cartP=$DBcon->query("SELECT P.productName, C.quantity FROM `cart-product` C, Product P WHERE C.cartID='$userRow[cartID]' AND C.productID= P.productID;");
	
	if (isset($_POST['btn-make'])) {
		$date = "2012-08-06";
		$date=date("Y-m-d",strtotime($date));
		$cartSelect=$DBcon->query("SELECT C.productID, C.quantity, P.sellerID FROM `cart-product` C,  product P WHERE C.productID=P.productID;");
		$userRow=$cartSelect->fetch_array();
		$result=$DBcon->query("INSERT INTO orrder(orderDate,sellerID, buyerID) VALUES ('$date','$userRow[sellerID]','$userID'); ");
		
		$ID=$DBcon->insert_id;
		
		$result2=$DBcon->query("INSERT INTO `order-product`(orderID, productID, quantity) VALUES ('$ID','$userRow[productID]','$userRow[quantity]'); ");
		while($row=mysqli_fetch_array($cartSelect)){
			$result2=$DBcon->query("INSERT INTO `order-product`(orderID, productID, quantity) VALUES ('$ID','$row[productID]','$row[quantity]'); ");
		}
		
		$buyerGet=$DBcon->query("SELECT * FROM cart WHERE buyerID='$userID'");
		$userRow2=$buyerGet->fetch_array();
		
		$empty=$DBcon->query("DELETE FROM `cart-product` WHERE cartID='$userRow2[cartID]'");
		$empty2=$DBcon->query("DELETE FROM cart WHERE cartID='$userRow2[cartID]'");
		
		header("Location: cart.php");
		
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
            <li class="active"><a href="../cart.php">Cart</a></li>
            <li><a href="../orderHistory.php">Order History</a></li>
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