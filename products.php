<?php
	session_start();
	include_once 'dbconnect.php';
	$check_store=$DBcon->query("SELECT * FROM product WHERE sellerID=".$_SESSION['userSession']);
	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	$msg="";
	$userID=$_SESSION['userSession'];
	$categoryQ=$DBcon->query("SELECT * FROM product WHERE sellerID='$userID'");
	
	if (isset($_POST['btn-save'])) {
		
		$productName = strip_tags($_POST['productName']);
		$productName = $DBcon->real_escape_string($productName);
		$productID = strip_tags($_POST['productID']);
		$productID = $DBcon->real_escape_string($productID);
		$catName = strip_tags($_POST['catName']);
		$catName = $DBcon->real_escape_string($catName);
		$categoryID=$DBcon->query("SELECT categoryID FROM category WHERE sellerID='$userID' AND catName='$catName';");
		$userRow=$categoryID->fetch_array();
		if(empty($productID) AND empty($productName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; product ID and name empty!
				</div>";
		}
		elseif(empty($productID)){
			$result=$DBcon->query("INSERT INTO product(categoryID, sellerID,productName) VALUES ('$userRow[categoryID]','$userID','$productName'); ");
			header("Location: products.php");
		}else{
			$categoryQ=$DBcon->query("UPDATE product SET productName='$productName' WHERE sellerID='$userID' AND productID='$productID';");
			header("Location: products.php");
		}
	}
	if (isset($_POST['btn-delete'])) {
		
		$productName = strip_tags($_POST['productName']);
		$productName = $DBcon->real_escape_string($productName);
		$productID = strip_tags($_POST['productID']);
		$productID = $DBcon->real_escape_string($productID);
		if(empty($productID) AND empty($productName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; product ID and name empty!
				</div>";
		}
		elseif(empty($productID) OR empty($productName)){
			$result=$DBcon->query("DELETE FROM `product` WHERE (productID = '$productID' OR productName = '$productName')AND sellerID='$userID'");
			header("Location: products.php");
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
    <h1>Products
	  <a href="category.php" class="btn btn-default" style="float:right;">back</a>
	  </h1>
  	<hr>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
	  
        <h3>Product info</h3>
        
        <form class="form-horizontal" role="form" method="post">
         
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		  <?php
			echo "<table style='width:100%'>"; // start a table tag in the HTML

			while($row = mysqli_fetch_array($categoryQ)){   //Creates a loop to loop through results
			echo "<tr><th>Product ID</th><th>Product Name</th></tr><tr><td>" . $row['productID'] . "</td><td>" . $row['productName'] . "</td></tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML
		  ?>
		  <hr>
		  <h4>Change Product Info</h4>
		  <div class="form-group">
			<label class="col-lg-3 control-label">Product ID:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Product ID to change name (leave empty to add new products)" name="productID">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Category Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Category Name to change name (leave empty to add new categories)" name="catName" required>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label class="col-lg-3 control-label">Product Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Product Name" name="productName">
			</div>
		  </div>
		  
		  
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-save">
			  <span class="glyphicon glyphicon-save-changes"></span> Save Changes
			  </button>
			  <button style="float: right;" type="submit" class="btn btn-default" name="btn-delete">
			  <span class="glyphicon glyphicon-delete-categories"></span> Delete Peoducts
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