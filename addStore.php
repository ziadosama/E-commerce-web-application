<?php
	session_start();
	include_once 'dbconnect.php';

	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	$userID=$_SESSION['userSession'];
	
	if (isset($_POST['btn-save'])) {
		$sname = strip_tags($_POST['name']);
		$sname = $DBcon->real_escape_string($sname);
		$result=$DBcon->query("INSERT INTO store(storeName, sellerID) VALUES ('$sname',$_SESSION[userSession]) ");
		header("Location: addStore.php");
	}
	if(isset($_POST['btn-update'])){
		
		$result=$DBcon->query("DELETE FROM store WHERE sellerID='$userID' ");
		header("Location: addStore.php");
	}
	if(isset($_POST['btn-category'])){
		header("Location: category.php");
	}
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
    <h1>Store
	  <a href="seller.php" class="btn btn-default" style="float:right;">back</a>
	  </h1>
  	<hr>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
	  
        <h3>Store info</h3>
        
        <form class="form-horizontal" role="form" method="post">
          
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		 <?php
		 $check_store=$DBcon->query("SELECT * FROM store WHERE sellerID=".$_SESSION['userSession']);
		 $count=$check_store->num_rows;
		 if($count==0){
			 ?>
		  <div class="form-group">
			<label class="col-lg-3 control-label">Store Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Store Name" name="name" required>
			</div>
		  </div>
		  
		  
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-save">
			  <span class="glyphicon glyphicon-save-changes"></span> &nbsp; Save Changes
			  </button>
			  <a href="seller.php" class="btn btn-default" style="float:right;">Cancel</a>
			</div>
		  </div>
		  
		 <?php
		 }else{
			 $result = $DBcon->query("SELECT * FROM store WHERE sellerID=".$_SESSION['userSession']);
			 $row=$result->fetch_array();
			 echo "Store Name: " .$row['storeName']. "<br>";
		?>
		<br>
		  <div class="form-group">
			<label class="col-md-0 control-label"></label>
			<div class="col-md-8">
			 <button type='submit' class='btn btn-default' name='btn-update'>
		     <span class='glyphicon glyphicon-save-changes'></span> Delete
			</div>
		  </div>
		  <hr>
          <div class="form-group">
			<label class="col-md-0 control-label"></label>
			<div class="col-md-8">
			 <button href="../category.php" type="submit"  class='btn btn-default' name='btn-category'>
		     <span class='glyphicon glyphicon-save-category'></span> Setup Categories
			</div>
		  </div>
		  <br>
		<?php
		 }
		 ?>
		  
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>