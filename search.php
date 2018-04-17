<?php
	session_start();
	include_once 'dbconnect.php';
	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	$msg="";
	$userID=$_SESSION['userSession'];
	$products=$DBcon->query("SELECT category.catName, category.categoryID, product.productID, product.productName,product.categoryID FROM product, category WHERE product.categoryID=category.categoryID;");
	$userRow=$products->fetch_array();
	
	if (isset($_POST['btn-delete'])) {
		
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
    <h1>Product
	  <a href="buye.php" class="btn btn-default" style="float:right;">back</a>
	  </h1>
  	<hr>
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

			while($row = mysqli_fetch_array($products)){   //Creates a loop to loop through results
			#echo "<tr><th>cart ID</th><th>product ID</th></tr><tr><td>" . $row['cartID'] . "</td><td>" . $row['producID'] . "</td></tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML
		  ?>
		  <hr>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Product Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Product Name" name="catID">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-search">
			  <span class="glyphicon glyphicon-save-changes"></span> Search Product
			  </button>
			   <button style={float:"right";} type="submit" class="btn btn-default" name="btn-add">
			  <span class="glyphicon glyphicon-save-changes"></span> Add Product
			  </button>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label class="col-lg-3 control-label">Category Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Category Name" name="catID">
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