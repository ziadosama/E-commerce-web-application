<?php
	session_start();
	include_once 'dbconnect.php';
	$check_store=$DBcon->query("SELECT * FROM product WHERE sellerID=".$_SESSION['userSession']);
	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	$userID=$_SESSION['userSession'];
	$store=$DBcon->query("SELECT productID FROM product WHERE productID='$userID'");
	$userRow=$store->fetch_array();
	$storeID=$userRow['storeID'];
	$categoryQ=$DBcon->query("SELECT * FROM product WHERE productID='$userID'");
	
	if (isset($_POST['btn-save'])) {
		
		$catName = strip_tags($_POST['catName']);
		$catName = $DBcon->real_escape_string($catName);
		$catID = strip_tags($_POST['catID']);
		$catID = $DBcon->real_escape_string($catID);
		$categoryQ=$DBcon->query("SELECT * FROM product WHERE sellerID='$userID' AND categoryID");
		if(empty($catID)){
			$result=$DBcon->query("INSERT INTO product(catName, storeID, sellerID) VALUES ('$catName','$storeID','$userID'); ");
		}else{
			$categoryQ=$DBcon->query("UPDATE category SET catName='$catName' WHERE sellerID='$userID' AND categoryID='$catID';");

		}
		header("Location: category.php");
	}
	if (isset($_POST['btn-delete'])) {
		
		$catName = strip_tags($_POST['catName']);
		$catName = $DBcon->real_escape_string($catName);
		$catID = strip_tags($_POST['catID']);
		$catID = $DBcon->real_escape_string($catID);
		if(empty($catID) AND empty($catName)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; category ID and name empty!
				</div>";
		}
		else	
			$result=$DBcon->query("DELETE FROM `category` WHERE (categoryID = '$catID' OR catName = '$catName')AND sellerID='$userID'");
		
		header("Location: category.php");
	}
	if (isset($_POST['btn-products'])) {
		$catID = strip_tags($_POST['catID']);
		$catID = $DBcon->real_escape_string($catID);
		if(empty($catID)){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; category ID empty!
				</div>";
		}
		else header("Location:products.php?catID=catID");
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
			echo "<tr><th>Category ID</th><th>category Name</th></tr><tr><td>" . $row['categoryID'] . "</td><td>" . $row['catName'] . "</td></tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML
		  ?>
		  <hr>
		  <h4>Change Product Info</h4>
		  <div class="form-group">
			<label class="col-lg-3 control-label">Product ID:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Category ID to change name (leave empty to add new categories)" name="catID">
			</div>
		  </div>
		  
		   <div class="form-group">
			<label class="col-lg-3 control-label">Product Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Category Name" name="catName">
			</div>
		  </div>
		  
		  
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-save">
			  <span class="glyphicon glyphicon-save-changes"></span> Save Changes
			  </button>
			  <button style="float: right;" type="submit" class="btn btn-default" name="btn-delete">
			  <span class="glyphicon glyphicon-delete-categories"></span> Delete Categories
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