<?php
	session_start();
	include_once 'dbconnect.php';
	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	$msg="";
	$userID=$_SESSION['userSession'];
	$products=$DBcon->query("SELECT C.catName, C.categoryID, P.productID, P.productName FROM product P, category C Where P.categoryID = C.categoryID;");
	
	if (isset($_POST['btn-search'])) {
		$productName = strip_tags($_POST['productName']);
		$productName = $DBcon->real_escape_string($productName);
		if( empty($productName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; product name empty!
				</div>";
		} else{
			$products=$DBcon->query("SELECT C.catName, C.categoryID, P.productID, P.productName FROM product P, category C Where P.productName='$productName' And P.categoryID = C.categoryID");
		}
	}
	
	if (isset($_POST['btn-category'])) {
		$catName = strip_tags($_POST['catName']);
		$catName = $DBcon->real_escape_string($catName);
		if( empty($catName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; category name empty!
				</div>";
		} else{
			$products=$DBcon->query("SELECT C.catName, C.categoryID, P.productID, P.productName FROM product P, category C Where C.catName='$catName' And P.categoryID = C.categoryID");
		}
	}
	
	if (isset($_POST['btn-add'])) {
		$productName = strip_tags($_POST['productName']);
		$productName = $DBcon->real_escape_string($productName);
		if( empty($productName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; category name empty!
				</div>";
		} else{
			$addProduct=$DBcon->query("SELECT P.productID FROM product P, category C Where P.productName='$productName' And P.categoryID = C.categoryID");
			$userRow=$addProduct->fetch_array();
			$check_cart = $DBcon->query("SELECT buyerID FROM cart WHERE buyerID='$userID'");
			$count=$check_cart->num_rows;
			if($count==0){
				$result=$DBcon->query("INSERT INTO cart(buyerID) VALUES ('$userID'); ");
			}
			$addCartProduct=$DBcon->query("SELECT cartID FROM cart WHERE buyerID='$userID'; ");
			$cartIDrow=$addCartProduct->fetch_array();
			$check_product = $DBcon->query("SELECT * FROM `cart-product` WHERE productID='$userRow[productID]' AND cartID='$cartIDrow[cartID]'");
			$count=$check_product->num_rows;
			if($count==0){
				$result2=$DBcon->query("INSERT INTO `cart-product`(productID,cartID, quantity) VALUES ('$userRow[productID]','$cartIDrow[cartID]', 1); ");
			} else{
				$result2=$DBcon->query("UPDATE `cart-product` SET quantity=quantity+1 Where productID='$userRow[productID]' AND cartID='$cartIDrow[cartID]';");
			}
		}
	}
	
	if(isset($_POST['btn-remove'])){
		$productName = strip_tags($_POST['productName']);
		$productName = $DBcon->real_escape_string($productName);
		if( empty($productName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; product name empty!
				</div>";
		} else{
			$addCartProduct=$DBcon->query("SELECT cartID FROM cart WHERE buyerID='$userID'; ");
			$cartIDrow=$addCartProduct->fetch_array();
			$addProduct=$DBcon->query("SELECT P.productID FROM product P, category C Where P.productName='$productName' And P.categoryID = C.categoryID");
			$userRow=$addProduct->fetch_array();
			$result=$DBcon->query("DELETE FROM `cart-product` Where productID='$userRow[productID]' AND quantity=1 AND cartID='$cartIDrow[cartID]'");
			$result2=$DBcon->query("UPDATE `cart-product` SET quantity=quantity-1 Where productID='$userRow[productID]'  AND cartID='$cartIDrow[cartID]'");
		}
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
            <li class="active"><a href="../search.php">Search</a></li>
            <li><a href="../cart.php">Cart</a></li>
            <li><a href="../orderHistory.php">Order History</a></li>
          </ul>
		  <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; </a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<br><br></br></br>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
	  
        <h3>Products</h3>
        
        <form class="form-horizontal" role="form" method="post">
         
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		  <?php
			echo "<table style='width:100%'>"; // start a table tag in the HTML

			while($row = mysqli_fetch_assoc($products)){   //Creates a loop to loop through results
				echo "<tr><th>Category ID</th><th>Category Name</th><th>Product ID</th><th>Product Name</th></tr><tr><td>" . $row['categoryID'] . "</td><td>" . $row['catName'] . "</td><td>" . $row['productID'] . "</td><td>" . $row['productName'] . "</td></tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML
		  ?>
		  <hr>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Product Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Product Name" name="productName">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-search">
			  <span class="glyphicon glyphicon-save-changes"></span> Search Product
			  </button>
			   <button type="submit" class="btn btn-default" name="btn-add">
			  <span class="glyphicon glyphicon-save-changes"></span> Add to cart
			  </button>
			  </button>
			   <button type="submit" class="btn btn-default" name="btn-remove">
			  <span class="glyphicon glyphicon-save-changes"></span> Remove from cart
			  </button>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label class="col-lg-3 control-label">Category Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Category Name" name="catName">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-category">
			  <span class="glyphicon glyphicon-save-changes"></span> Search Category
			  </button>
			</div>
		  </div>
		  
		  
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>