<?php
	session_start();
	include_once 'dbconnect.php';
	$bs=$_GET['bs'];

	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	
	if (isset($_POST['btn-save'])) {
		$name=strip_tags($_POST['name']);
		$phone=strip_tags($_POST['phone']);
		$email=strip_tags($_POST['email']);
		$password=strip_tags($_POST['password']);
		$password2=strip_tags($_POST['password2']);
		
		if($password!=$password2){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Mismatching passwords !
				</div>";
		}
		else{
			$name=$DBcon->real_escape_string($name);
			$phone=$DBcon->real_escape_string($phone);
			$email=$DBcon->real_escape_string($email);
			$password=$DBcon->real_escape_string($password);
			
			$hashed_password=password_hash($password, PASSWORD_DEFAULT);
			if($bs=='b'){
				if(!empty($name)){
					$update = $DBcon->query("UPDATE buyer SET buyerName= '$name' WHERE buyerID=".$_SESSION['userSession']);
				}
				
				if(!empty($phone)){
					$update = $DBcon->query("UPDATE buyer SET buyerPhone= '$phone' WHERE buyerID=".$_SESSION['userSession']);
				}
				
				if(!empty($email)){
					$update = $DBcon->query("UPDATE buyer SET buyerEmail= '$email' WHERE buyerID=".$_SESSION['userSession']);
				}
				
				if(!empty($password)){
					$update = $DBcon->query("UPDATE buyer SET buyerPwd= '$hashed_password' WHERE buyerID=".$_SESSION['userSession']);
				}
			}
			else if($bs=='s'){
				if(!empty($name)){
					$update = $DBcon->query("UPDATE seller SET sellerName= '$name' WHERE sellerID=".$_SESSION['userSession']);
				}
				
				if(!empty($phone)){
					$update = $DBcon->query("UPDATE seller SET sellerPhone= '$phone' WHERE sellerID=".$_SESSION['userSession']);
				}
				
				if(!empty($email)){
					$update = $DBcon->query("UPDATE seller SET sellerEmail= '$email' WHERE sellerID=".$_SESSION['userSession']);
				}
				
				if(!empty($password)){
					$update = $DBcon->query("UPDATE seller SET sellerPwd= '$hashed_password' WHERE sellerID=".$_SESSION['userSession']);
				}
			}
		}
	}
	
	if(isset($_POST['btn-buyer'])){
		$query=$DBcon->query("SELECT  sellerEmail FROM seller WHERE sellerID=".$_SESSION['userSession']);
		$row=$query->fetch_array();
		$check_email=$DBcon->query("SELECT  buyerEmail FROM buyer WHERE buyerEmail='$row[sellerEmail]'");
		$count=$check_email->num_rows;
		if($count==0){
			$query=$DBcon->query("SELECT  * FROM seller WHERE sellerID=".$_SESSION['userSession']);
			$row=$query->fetch_array();
			$query="INSERT INTO buyer(buyerPhone,buyerName,buyerEmail,buyerPwd) VALUES('$row[sellerPhone]','$row[sellerName]','$row[sellerEmail]','$row[sellerPwd]')";
		}
		header("Location=change.php?bs=b");
	}
	
	if(isset($_POST['btn-seller'])){
		$query=$DBcon->query("SELECT  buyerEmail FROM buyer WHERE buyerID=".$_SESSION['userSession']);
		$row=$query->fetch_array();
		$check_email=$DBcon->query("SELECT  sellerEmail FROM seller WHERE sellerEmail='row[buyerEmail]'");
		$count=$check_email->num_rows;
		if($count==0){
			$query=$DBcon->query("SELECT  * FROM buyer WHERE buyerID=".$_SESSION['userSession']);
			$row=$query->fetch_array();
			$query="INSERT INTO seller(sellerPhone,sellerName,sellerEmail,sellerPwd) VALUES('$row[buyerPhone]','$row[buyerName]','$row[buyerEmail]','$row[buyerPwd]')";
		}
		header("Location=change.php?bs=s");
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
    <h1>Edit Profile</h1>
  	<hr>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <h3>Personal info</h3>
        
        <form class="form-horizontal" role="form" method="post">
          
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		 
		  <div class="form-group">
			<label class="col-lg-3 control-label">User Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="User Name" name="name">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Phone:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Phone" name="phone">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Email:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Email" name="email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Password:</label>
			<div class="col-md-8">
			  <input class="form-control" type="password" placeholder="Password" name="password">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Confirm password:</label>
			<div class="col-md-8">
			  <input class="form-control" type="password" placeholder="Confirm Password" name="password2">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-save">
			  <span class="glyphicon glyphicon-save-changes"></span> &nbsp; Save Changes
			  </button>
			  <a href="javascript:history.back()" class="btn btn-default" style="float:right;">Cancel</a>
			</div>
		  </div>
		  
		  <?php if($bs=='b'){  ?>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Change to seller</label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-seller">
			  <span class="glyphicon glyphicon-seller-change"></span> &nbsp; Seller Change
			  </button>
			</div>
		  </div>
		  
		  <?php } elseif($bs=='s'){ ?>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Change to buyer</label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-buyer">
			  <span class="glyphicon glyphicon-buyer-change"></span> &nbsp; Buyer Change
			  </button>
			</div>
		  </div>
		  
		  <?php } ?>
		  
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>